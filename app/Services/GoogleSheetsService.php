<?php

namespace App\Services;

use App\Http\Resources\GoogleSheetsResource;
use App\Repository\GrupoEmpresasRepository;
use Google\Service\Sheets;
use \Google\Service\Sheets\ValueRange;
use Google\Client;
use Illuminate\Support\Carbon;
use MongoDB\BSON\UTCDateTime;

class GoogleSheetsService
{
    private $client;
    private $googleSheetsRepository;
    private $dados;
    private $retorno;
    private $insertPlan;
    private $timezone = 'America/Sao_Paulo';


    public function __construct(GrupoEmpresasRepository $googleSheetsRepository)
    {
        $this->googleSheetsRepository = $googleSheetsRepository;
    }

    public function validarRequest($request)
    {
        $dataInicio = isset($request['dataInicio']) ? $request['dataInicio'] : null;
        $dataFim = isset($request['dataFim']) ? $request['dataFim'] : null;
        $retorno = $this->getData($dataInicio,$dataFim);
        return $retorno;
    }
    
    private function Client()
    {
        $this->client = new Client();
        $this->client->setApplicationName('nome da sua aplicação');
        $this->client->setScopes([Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(base_path(env('GOOGLE_CREDENTIALS_PATH')));
        $this->client->setPrompt('select_account consent');
        return $this->client;
    }

    public function insertPlanilha($dados, $empAtualizadas)
    {
        $service = new Sheets($this->Client());
        $body = new ValueRange([
            'values' => $dados
        ]);
        $rangeToWrite = "A2:Z";
        $params = [
            'valueInputOption' => 'RAW'
        ];
        $result = $service->spreadsheets_values->append(env('GOOGLE_ID_PLAN'), $rangeToWrite, $body, $params);

        if ($result->getUpdates()->getUpdatedCells() > 0) {
            $this->retorno = $empAtualizadas;
        } else {
            $this->retorno = $empAtualizadas;
        }
    }

    public function getData($dataInicio,$dataFim)
    {
          
        $gruposEmpresas = $this->googleSheetsRepository->getGrupoEmpresas();

        foreach ($gruposEmpresas as $grupoEmpresa) {
            $this->dados['grupo_emp'] = $grupoEmpresa['grupo_emp'];
            $this->dados['tipo_emp'] = $grupoEmpresa['tipo_emp'];
            $this->dados['estado'] = isset($grupoEmpresa['bases']['end']) ? $grupoEmpresa['bases']['end']['estado'] : $grupoEmpresa['bases'][0]['v']['end']['estado'];
            $this->dados['cidade'] = isset($grupoEmpresa['bases']['end']) ? $grupoEmpresa['bases']['end']['cidade'] : $grupoEmpresa['bases'][0]['v']['end']['cidade'];
            $this->dados['cnpj'] = isset($grupoEmpresa['cnpjs'][0])? $grupoEmpresa['cnpjs'][0] : "CNPJ NÂO ENCONTRADO";
            $this->dados['dataComeco'] = $grupoEmpresa['dataComeco'];
            $this->dados['totalDocs'] = $this->googleSheetsRepository->getTotalDocs($this->dados['grupo_emp'],$dataInicio, $dataFim);
            $this->dados['totalComprovacoes'] = $this->googleSheetsRepository->getTotalComprovados($this->dados['grupo_emp'],$dataInicio, $dataFim);
            $this->dados['ativo'] = $this->dados['totalComprovacoes'] == 0 ? "FALSE" : "TRUE";
            $tipoUser = [
                'GESTOR',
                'COLABORADOR',
                'MOTORISTA'
            ];
            $this->dados['tatico'] = $this->googleSheetsRepository->getUsers($this->dados['grupo_emp'], $tipoUser[0]);
            $this->dados['operacional'] = $this->googleSheetsRepository->getUsers($this->dados['grupo_emp'], $tipoUser[1]);
            $this->dados['Motoritas'] = $this->googleSheetsRepository->getUsers($this->dados['grupo_emp'], $tipoUser[2]);
            $this->dados['MotoritasAtivoDia'] = $this->googleSheetsRepository->getDocsRomaneio($this->dados['grupo_emp'],$dataInicio, $dataFim);
            $this->dados['NumeroIntegracoes'] = $this->googleSheetsRepository->getIntegracoes($this->dados['grupo_emp']);
            $this->dados['taxaComprovacao'] = $this->getTaxaComprovacao($this->dados['totalDocs'],$this->dados['totalComprovacoes']);
            $this->dados['dataConsulta'] = isset($dataInicio) ? Carbon::parse($dataInicio)->format('m/Y') : Carbon::now($this->timezone)->format('m/Y');
            $empAtualizadas[] = $this->dados['grupo_emp'];
            $this->dados = $this->prepararEnvio($this->dados);
            $this->insertPlan[] = $this->dados;       
        }
        $this->insertPlanilha($this->insertPlan, $empAtualizadas);
        return $this->retorno;
    }
    public function getTaxaComprovacao($totalDocs, $totalComprovacao)
    {
        $multiplicacao = $totalComprovacao * 100;
        $taxaComprovacao = $multiplicacao == 0 ? 0 : $multiplicacao / $totalDocs;
        $taxaComprovacaoArredondada = round($taxaComprovacao);
        return $taxaComprovacaoArredondada;
    }
    public function prepararEnvio($dados)
    {
        $dadosFormatados = [
            $dados['grupo_emp'],
            $dados['tipo_emp'],
            $dados['estado'],
            $dados['cidade'],
            $dados['cnpj'],
            $dados['dataComeco'],
            $dados['totalDocs'],
            $dados['totalComprovacoes'],
            $dados['ativo'],
            $dados['tatico'],
            $dados['operacional'],
            $dados['Motoritas'],
            $dados['MotoritasAtivoDia'],
            $dados['NumeroIntegracoes'],
            $dados['taxaComprovacao'],
            $dados['dataConsulta'],
        ];
    
        $dadosFormatados = array_map('strval', $dadosFormatados);
    
        return $dadosFormatados;
    }
}
