<?php

namespace App\Repository;

use App\Models\Grupo_empresas;
use App\Models\Doc;
use MongoDB\BSON\UTCDateTime;
use App\Models\Integracao;
use App\Models\Grupo_empresa;
use App\Models\User;
use Illuminate\Support\Carbon;

class GrupoEmpresasRepository
{
    private $timezone = 'America/Sao_Paulo';
    public function getGrupoEmpresas()
    {
        $grupoEmpresas = Grupo_empresa::all();
        return $grupoEmpresas;
    }
    public function getTotalDocs($grupo_emp, $dataInicio, $dataFim)
    {
        if (isset($dataInicio) && isset($dataFim)) {
            $docs = Doc::where('dt_emis', '>=', new UTCDateTime(Carbon::parse($dataInicio, $this->timezone)->startOfDay()))
                ->where('dt_emis', '<=',  new UTCDateTime(Carbon::parse($dataFim, $this->timezone)->endOfDay()))
                ->where("$grupo_emp", 'exists', true)->get();
        } else {
            $docs = Doc::where('dt_emis', '>=', new UTCDateTime(Carbon::now($this->timezone)->startOfDay()))
                ->where('dt_emis', '<=', new UTCDateTime(Carbon::now($this->timezone)->endOfDay()))
                ->where("$grupo_emp", 'exists', true)->get();
        }

        return $docs;
    }
    public function getIntegracoes($grupo_emp)
    {
        $integracoes = Integracao::where('ativo', true)
            ->whereNotIn('cron', ['NT', 'nt', ''])
            ->where('grupo_emp', "$grupo_emp")->get();
        return $integracoes;
    }
    public function getTotalComprovados($grupo_emp,$dataInicio, $dataFim)
    {
        if (isset($dataInicio) && isset($dataFim)) {
            $totalComprovadas = Doc::where('dt_emis', '>=', new UTCDateTime(Carbon::parse($dataInicio, $this->timezone)->startOfDay()))
                ->where('dt_emis', '<=',  new UTCDateTime(Carbon::parse($dataFim, $this->timezone)->endOfDay()))
                ->where("$grupo_emp", 'exists', true)
                ->whereIn("$grupo_emp.status", ["COMPROVADO", "PROTOCOLADO", "VALIDADO"])
                ->where('historico.cam_imagem', 'exists', true)->get();
        } else {
            $totalComprovadas = Doc::where('dt_emis', '>=', new UTCDateTime(Carbon::now($this->timezone)->startOfDay()))
                ->where('dt_emis', '<=', new UTCDateTime(Carbon::now($this->timezone)->endOfDay()))
                ->where("$grupo_emp", 'exists', true)
                ->whereIn("$grupo_emp.status", ["COMPROVADO", "PROTOCOLADO", "VALIDADO"])
                ->where('historico.cam_imagem', 'exists', true)->get();
        }
        return $totalComprovadas;
    }
    public function getUsers($grupo_emp, $tipoUser)
    {
        $usuarios = User::where("grupos.$grupo_emp", 'exists', true)
            ->where("grupos.$grupo_emp.ativo", true)
            ->where("grupos.$grupo_emp.grupo_user", "$tipoUser")->get();
        return $usuarios;
    }
    public function getDocsRomaneio($grupo_emp, $dataInicio, $dataFim)
    {
        if (isset($dataInicio) && isset($dataFim)) {
            $docsRomaneados = Doc::where('dt_emis', '>=', new UTCDateTime(Carbon::parse($dataInicio, $this->timezone)->startOfDay()))
                ->where('dt_emis', '<=',  new UTCDateTime(Carbon::parse($dataFim, $this->timezone)->endOfDay()))
                ->where("$grupo_emp", 'exists', true)
                ->where("$grupo_emp.romaneio", 'exists', true)
                ->get();
        } else {
            $docsRomaneados = Doc::where('dt_emis', '>=', new UTCDateTime(Carbon::now($this->timezone)->startOfDay()))
                ->where('dt_emis', '<=', new UTCDateTime(Carbon::now($this->timezone)->endOfDay()))
                ->where("$grupo_emp", 'exists', true)
                ->where("$grupo_emp.romaneio", 'exists', true)
                ->get();
        }
        return $docsRomaneados;
    }
}
