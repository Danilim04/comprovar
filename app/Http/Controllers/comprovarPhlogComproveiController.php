<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use MongoDB\BSON\UTCDateTime;
use App\Models\Doc;
use GuzzleHttp\Client;
use stdClass;
use Exception;
use App\Models\Controle;


class comprovarPhlogComproveiController extends Controller
{
    private $timezone = 'America/Sao_Paulo';
    public function comprovarPhlogComprovei(Request $request)
    {
        $chavesComprovadas = [];
        $chavesNaoEncontradas = [];
        $chavesSemDados = [];
        $client = new Client();
        $dataInicio = $request->has('dataInicio') ? new UTCDateTime(Carbon::parse($request->input('dataInicio'))->startOfDay()) : new UTCDateTime(Carbon::now($this->timezone)->startOfDay());
        $dataFim = $request->has('dataFim') ? new UTCDateTime(Carbon::parse($request->input('dataFim'))->endOfDay()) : new UTCDateTime(Carbon::now($this->timezone)->endOfDay());
        $chave = $request->has('chave') ? $request->input('chave') : null;
        $usuario = "phlogqa";
        $senha = "YbDRTFDFfVGvP0FUgHy6Zy3SqYwYTxES";
        $grupo_emp = "PHLOG";
        $requestComprovar = [];
        $usuarioAzapfy = "integracaocomprovei@Phlog.com.br";
        $senhaAzapfy = "12227730000109";
        try {
            $control['hash'] = "comprovarWbspPhlogComprovei";
            $control['origem'] = ['funcao' => 'ComprovarPhlogComprovei'];
            $controle = Controle::firstOrCreate(['hash' => 'comprovarWbspPhlogComprovei'], $control);
            if (!$controle->wasRecentlyCreated) {
                if (Carbon::parse($controle['created_at']) <= now()->subHours(2)) {
                    return  $htmlError = '
                            <!DOCTYPE html>
                            <html lang="pt-BR">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Erro de Processamento</title>
                                <style>
                                    body {
                                        margin: 0;
                                        padding: 0;
                                        font-family: Arial, sans-serif;
                                        background-color: #FF6400;
                                    }
                            
                                    .error-box {
                                        background-color: #fff; /* Fundo cinza claro */
                                        padding: 20px;
                                        border-radius: 10px;
                                        text-align: center;
                                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                        margin: 50px auto;
                                        max-width: 600px;
                                    }
                            
                                    h2 {
                                        margin-top: 0;
                                    }
                            
                                    a {
                                        color: 
                                        text-decoration: none;
                                    }
                            
                                    a:hover {
                                        text-decoration: underline;
                                    }
                                </style>
                            </head>
                            <body>
                                <div class="error-box">
                                    <h2>Erro de Processamento</h2>
                                    <p>Infelizmente, parece que ocorreu um erro durante o processamento. Não se preocupe! Vou te ajudar a resolver isso.</p>
                                    <p>Por favor, entre em contato com o suporte através do seguinte link: <a href="https://suporte.azapfy.com.br">suporte.azapfy.com.br</a> e nos forneça o erro abaixo. Estamos aqui para ajudar!</p>
                                    <p><strong>Detalhes do Erro:</strong>A integração esta rodando a mais de 2 horas</p>
                                </div>
                            </body>
                            </html>';
                } else {
                    if (isset($controle->hash)) {
                        $controle->delete();
                    }
                    return  $htmlError = '
                            <!DOCTYPE html>
                            <html lang="pt-BR">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Erro de Processamento</title>
                                <style>
                                    body {
                                        margin: 0;
                                        padding: 0;
                                        font-family: Arial, sans-serif;
                                        background-color: #FF6400;
                                    }
                            
                                    .error-box {
                                        background-color: #fff; /* Fundo cinza claro */
                                        padding: 20px;
                                        border-radius: 10px;
                                        text-align: center;
                                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                        margin: 50px auto;
                                        max-width: 600px;
                                    }
                            
                                    h2 {
                                        margin-top: 0;
                                    }
                            
                                    a {
                                        color: 
                                        text-decoration: none;
                                    }
                            
                                    a:hover {
                                        text-decoration: underline;
                                    }
                                </style>
                            </head>
                            <body>
                                <div class="error-box">
                                    <h2>Erro de Processamento</h2>
                                    <p>Infelizmente, parece que ocorreu um erro durante o processamento. Não se preocupe! Vou te ajudar a resolver isso.</p>
                                    <p>Por favor, entre em contato com o suporte através do seguinte link: <a href="https://suporte.azapfy.com.br">suporte.azapfy.com.br</a> e nos forneça o erro abaixo. Estamos aqui para ajudar!</p>
                                    <p><strong>Detalhes do Erro:</strong>A integracao esta rodando nesse exato momento</p>
                                </div>
                            </body>
                            </html>';;
                }
            }
        } catch (Exception $e) {
            if (isset($controle->hash)) {
                $controle->delete();
            }
            $htmlError = '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Erro de Processamento</title>
                    <style>
                        body {
                            margin: 0;
                            padding: 0;
                            font-family: Arial, sans-serif;
                            background-color: #FF6400;
                        }
                
                        .error-box {
                            background-color: #fff; /* Fundo cinza claro */
                            padding: 20px;
                            border-radius: 10px;
                            text-align: center;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            margin: 50px auto;
                            max-width: 600px;
                        }
                
                        h2 {
                            margin-top: 0;
                        }
                
                        a {
                            color: 
                            text-decoration: none;
                        }
                
                        a:hover {
                            text-decoration: underline;
                        }
                    </style>
                </head>
                <body>
                    <div class="error-box">
                        <h2>Erro de Processamento</h2>
                        <p>Infelizmente, parece que ocorreu um erro durante o processamento. Não se preocupe! Vou te ajudar a resolver isso.</p>
                        <p>Por favor, entre em contato com o suporte através do seguinte link: <a href="https://suporte.azapfy.com.br">suporte.azapfy.com.br</a> e nos forneça o erro abaixo. Estamos aqui para ajudar!</p>
                        <p><strong>Detalhes do Erro:</strong> ' . $e->getMessage() . '</p>
                    </div>
                </body>
                </html>';
            return $htmlError;
        }
        if ($request->has('dataInicio')) {
            $diferencaEmDias = (Carbon::parse($request->input('dataInicio'))->startOfDay())->diffInDays(Carbon::parse($request->input('dataFim'))->endOfDay());
            if ($diferencaEmDias > 30) {
                $controle->delete();
                return  $htmlError = '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Erro de Processamento</title>
                    <style>
                        body {
                            margin: 0;
                            padding: 0;
                            font-family: Arial, sans-serif;
                            background-color: #FF6400;
                        }
                
                        .error-box {
                            background-color: #fff; /* Fundo cinza claro */
                            padding: 20px;
                            border-radius: 10px;
                            text-align: center;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            margin: 50px auto;
                            max-width: 600px;
                        }
                
                        h2 {
                            margin-top: 0;
                        }
                
                        a {
                            color: 
                            text-decoration: none;
                        }
                
                        a:hover {
                            text-decoration: underline;
                        }
                    </style>
                </head>
                <body>
                    <div class="error-box">
                        <h2>Erro de Processamento</h2>
                        <p><strong>Detalhes do Erro:</strong>O periodo que esta sendo passado e maior que 30 dias</p>
                    </div>
                </body>
                </html>';
            }
        }
        if (!$chave) {
            try {
                $chaves = Doc::raw(function ($collection) use ($grupo_emp, $dataInicio, $dataFim) {
                    return $collection->aggregate([
                        [
                            '$match' => [
                                'created_at' => [
                                    '$gte' => $dataInicio,
                                    '$lte' => $dataFim
                                ],
                                $grupo_emp => ['$exists' => false],
                                "$grupo_emp.status" => [
                                    '$in' => ["NAO RETORNE NADA"]
                                ]
                            ]
                        ],
                        [
                            '$limit' => 1
                        ],
                        [
                            '$project' => [
                                'chave' => '$chave',
                                'tipo_doc' => '$tipo_doc'
                            ]
                        ]

                    ]);
                });
                $chaves = $chaves->toArray();
                if (empty($chaves)) {
                    $controle->delete();
                    return '<!DOCTYPE html>
                    <html lang="pt-BR">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Sucesso!</title>
                        <style>
                            body {
                                margin: 0;
                                padding: 0;
                                font-family: Arial, sans-serif;
                                background-color: #7FFF00; /* Altere a cor de fundo conforme necessário */
                            }
                    
                            .success-box {
                                background-color: #fff; /* Fundo cinza claro */
                                padding: 20px;
                                border-radius: 10px;
                                text-align: center;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                margin: 50px auto;
                                max-width: 600px;
                            }
                    
                            h2 {
                                margin-top: 0;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="success-box">
                            <h2>Não existe notas para comprovar!!</h2>
                        </div>
                    </body>
                    </html>
                    ';
                }
                foreach ($chaves as $chave) {
                    if ($chave['tipo_doc'] !== "NOTA") {
                        continue;
                    }
                    $chaveNota = $chave['chave'];
                    $url = 'https://api.comprovei.com.br/api/1.1/documents/getStatus?key=' . $chaveNota;
                    $options['auth'] = [$usuario, $senha];
                    $request = $client->request('GET', $url, $options);
                    $result = json_decode($request->getBody()->getContents());
                    if (!isset($result->response_data[0])) {
                        $chavesNaoEncontradas[] = $chaveNota;
                        continue;
                    } else {
                        $data = $result->response_data[0]->Documento;
                        if ($data->Foto !== '' && $data->CodOcorrencia == "00" && $data->DataHora !== '') {
                            $dataHoraCarbon = Carbon::createFromFormat('d/m/Y H:i:s', $data->DataHora);
                            $dataEntrega = $dataHoraCarbon->format('Y-m-d H:i:s');
                            $Latitude = $data->Latitude !== '' ? $data->Latitude : "000";
                            $Longitude = $data->Longitude !== '' ? $data->Longitude : "000";
                            $imagem = base64_encode(file_get_contents($data->Foto));
                            $requestComprovar = [
                                "chave" => $chaveNota,
                                "ocorrencia" => "1",
                                "dataEntrega" => $dataEntrega,
                                "dataOcorrencia" => $dataEntrega,
                                "imagem" => $imagem,
                                "cnpj" => "12227730000109",
                                "lat" => $Latitude,
                                "lng" => $Longitude
                            ];
                            $chavesComprovadas[] = $chaveNota;
                        } else {
                            $chavesSemDados[] = $chaveNota;
                        }
                    }
                }
            } catch (Exception $e) {
                if (isset($controle->hash)) {
                    $controle->delete();
                }
                $htmlError = '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Erro de Processamento</title>
                    <style>
                        body {
                            margin: 0;
                            padding: 0;
                            font-family: Arial, sans-serif;
                            background-color: #FF6400;
                        }
                
                        .error-box {
                            background-color: #fff; /* Fundo cinza claro */
                            padding: 20px;
                            border-radius: 10px;
                            text-align: center;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            margin: 50px auto;
                            max-width: 600px;
                        }
                
                        h2 {
                            margin-top: 0;
                        }
                
                        a {
                            color: 
                            text-decoration: none;
                        }
                
                        a:hover {
                            text-decoration: underline;
                        }
                    </style>
                </head>
                <body>
                    <div class="error-box">
                        <h2>Erro de Processamento</h2>
                        <p>Infelizmente, parece que ocorreu um erro durante o processamento. Não se preocupe! Vou te ajudar a resolver isso.</p>
                        <p>Por favor, entre em contato com o suporte através do seguinte link: <a href="https://suporte.azapfy.com.br">suporte.azapfy.com.br</a> e nos forneça o erro abaixo. Estamos aqui para ajudar!</p>
                        <p><strong>Detalhes do Erro:</strong> ' . $e->getMessage() . '</p>
                    </div>
                </body>
                </html>';
                return $htmlError;
            }
            try {
                $options['auth'] = [$usuarioAzapfy, $senhaAzapfy];
                $options['form_params'] = $requestComprovar;
                $request = $client->request('POST', 'homologacao3.azapfy.com.br/api/integracao/comprovar', $options);
                $result = json_decode($request->getBody()->getContents());
                $chavesComprovadasValidacao = empty($chavesComprovadas) ? "0" : count($chavesComprovadas);
                $chavesSemdadosValidacao = empty($chavesSemDados) ? "0" : count($chavesSemDados);
                $chavesNaoencontradasValidacao = empty($chavesNaoEncontradas) ? "0" : count($chavesNaoEncontradas);
                $retorno = '<!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Sucesso!</title>
                    <style>
                        body {
                            margin: 0;
                            padding: 0;
                            font-family: Arial, sans-serif;
                            background-color: #7FFF00; /* Altere a cor de fundo conforme necessário */
                        }
                
                        .success-box {
                            background-color: #fff; /* Fundo cinza claro */
                            padding: 20px;
                            border-radius: 10px;
                            text-align: center;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            margin: 50px auto;
                            max-width: 600px;
                        }
                
                        h2 {
                            margin-top: 0;
                        }
                
                        p {
                            margin-bottom: 10px;
                        }
                
                        a {
                            color: #007bff; /* Cor do link */
                            text-decoration: none;
                        }
                
                        a:hover {
                            text-decoration: underline;
                        }
                    </style>
                </head>
                <body>
                    <div class="success-box">
                        <h2>Sucesso!</h2>
                        <p>Todas as notas foram processadas com sucesso.</p>
                        <p>Resumo:</p>
                        <p><strong>Numero de Notas Comprovadas:</strong> ' . $chavesComprovadasValidacao . '</p>
                        <p><strong>Numero de notas Sem dados:</strong> ' . $chavesSemdadosValidacao . '</p>
                        <p><strong>Numero de notas que não foram encontradas:</strong> ' . $chavesNaoencontradasValidacao . '</p>
                        <p>Para mais informações, entre em contato com o suporte através do seguinte link: <a href="https://suporte.azapfy.com.br">suporte.azapfy.com.br</a>.</p>
                    </div>
                </body>
                </html>
                ';
                $controle->delete();
                return $retorno;
            } catch (Exception $e) {
                if (isset($controle->hash)) {
                    $controle->delete();
                }
                $htmlError = '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Erro de Processamento</title>
                    <style>
                        body {
                            margin: 0;
                            padding: 0;
                            font-family: Arial, sans-serif;
                            background-color: #FF6400;
                        }
                
                        .error-box {
                            background-color: #fff; /* Fundo cinza claro */
                            padding: 20px;
                            border-radius: 10px;
                            text-align: center;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            margin: 50px auto;
                            max-width: 600px;
                        }
                
                        h2 {
                            margin-top: 0;
                        }
                
                        a {
                            color: 
                            text-decoration: none;
                        }
                
                        a:hover {
                            text-decoration: underline;
                        }
                    </style>
                </head>
                <body>
                    <div class="error-box">
                        <h2>Erro de Processamento</h2>
                        <p>Infelizmente, parece que ocorreu um erro durante o processamento. Não se preocupe! Vou te ajudar a resolver isso.</p>
                        <p>Por favor, entre em contato com o suporte através do seguinte link: <a href="https://suporte.azapfy.com.br">suporte.azapfy.com.br</a> e nos forneça o erro abaixo. Estamos aqui para ajudar!</p>
                        <p><strong>Detalhes do Erro:</strong> ' . $e->getMessage() . '</p>
                    </div>
                </body>
                </html>';
                return $htmlError;
            }
        } else {
            try {
                $url = 'https://api.comprovei.com.br/api/1.1/documents/getStatus?key=' . $chave;
                $options['auth'] = [$usuario, $senha];
                $request = $client->request('GET', $url, $options);
                $result = json_decode($request->getBody()->getContents());
                if (!isset($result->response_data[0])) {
                    $chavesNaoEncontradas[] = $chave;
                    $controle->delete();
                    return [
                        "status" => false,
                        "mensagem" => "nota não encontrada"
                    ];
                } else {
                    $data = $result->response_data[0]->Documento;
                    if ($data->Foto !== '' && $data->CodOcorrencia == "00" && $data->DataHora !== '') {
                        $dataHoraCarbon = Carbon::createFromFormat('d/m/Y H:i:s', $data->DataHora);
                        $dataEntrega = $dataHoraCarbon->format('Y-m-d H:i:s');
                        $Latitude = $data->Latitude !== '' ? $data->Latitude : "000";
                        $Longitude = $data->Longitude !== '' ? $data->Longitude : "000";
                        $imagem = base64_encode(file_get_contents($data->Foto));
                        $requestComprovar = [
                            "chave" => $chave,
                            "ocorrencia" => "1",
                            "dataEntrega" => $dataEntrega,
                            "dataOcorrencia" => $dataEntrega,
                            "imagem" => $imagem,
                            "cnpj" => "12227730000109",
                            "lat" => $Latitude,
                            "lng" => $Longitude
                        ];
                        $chavesComprovadas[] = $chave;
                    } else {

                        $controle->delete();

                        return '<!DOCTYPE html>
                        <html lang="pt-BR">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Sucesso!</title>
                            <style>
                                body {
                                    margin: 0;
                                    padding: 0;
                                    font-family: Arial, sans-serif;
                                    background-color: #7FFF00; /* Altere a cor de fundo conforme necessário */
                                }
                        
                                .success-box {
                                    background-color: #fff; /* Fundo cinza claro */
                                    padding: 20px;
                                    border-radius: 10px;
                                    text-align: center;
                                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                    margin: 50px auto;
                                    max-width: 600px;
                                }
                        
                                h2 {
                                    margin-top: 0;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="success-box">
                                <h2>A nota não possui comprovação!</h2>
                            </div>
                        </body>
                        </html>
                        ';
                    }
                }
            } catch (Exception $e) {
                if (isset($controle->hash)) {
                    $controle->delete();
                }
                $htmlError = '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Erro de Processamento</title>
                    <style>
                        body {
                            margin: 0;
                            padding: 0;
                            font-family: Arial, sans-serif;
                            background-color: #FF6400;
                        }
                
                        .error-box {
                            background-color: #fff; /* Fundo cinza claro */
                            padding: 20px;
                            border-radius: 10px;
                            text-align: center;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            margin: 50px auto;
                            max-width: 600px;
                        }
                
                        h2 {
                            margin-top: 0;
                        }
                
                        a {
                            color: 
                            text-decoration: none;
                        }
                
                        a:hover {
                            text-decoration: underline;
                        }
                    </style>
                </head>
                <body>
                    <div class="error-box">
                        <h2>Erro de Processamento</h2>
                        <p>Infelizmente, parece que ocorreu um erro durante o processamento. Não se preocupe! Vou te ajudar a resolver isso.</p>
                        <p>Por favor, entre em contato com o suporte através do seguinte link: <a href="https://suporte.azapfy.com.br">suporte.azapfy.com.br</a> e nos forneça o erro abaixo. Estamos aqui para ajudar!</p>
                        <p><strong>Detalhes do Erro:</strong> ' . $e->getMessage() . '</p>
                    </div>
                </body>
                </html>';
                return $htmlError;
            }

            try {
                $options['auth'] = [$usuarioAzapfy, $senhaAzapfy];
                $options['form_params'] = $requestComprovar;
                $request = $client->request('POST', 'homologacao3.azapfy.com.br/api/integracao/comprovar', $options);
                $result = json_decode($request->getBody()->getContents());
                $controle->delete();
                return '<!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Sucesso!</title>
                    <style>
                        body {
                            margin: 0;
                            padding: 0;
                            font-family: Arial, sans-serif;
                            background-color: #7FFF00; /* Altere a cor de fundo conforme necessário */
                        }
                
                        .success-box {
                            background-color: #fff; /* Fundo cinza claro */
                            padding: 20px;
                            border-radius: 10px;
                            text-align: center;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            margin: 50px auto;
                            max-width: 600px;
                        }
                
                        h2 {
                            margin-top: 0;
                        }
                    </style>
                </head>
                <body>
                    <div class="success-box">
                        <h2>A nota foi Comprovada com sucesso!</h2>
                    </div>
                </body>
                </html>
                ';
            } catch (Exception $e) {
                if (isset($controle->hash)) {
                    $controle->delete();
                }
                $htmlError = '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Erro de Processamento</title>
                    <style>
                        body {
                            margin: 0;
                            padding: 0;
                            font-family: Arial, sans-serif;
                            background-color: #FF6400;
                        }
                
                        .error-box {
                            background-color: #fff; /* Fundo cinza claro */
                            padding: 20px;
                            border-radius: 10px;
                            text-align: center;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            margin: 50px auto;
                            max-width: 600px;
                        }
                
                        h2 {
                            margin-top: 0;
                        }
                
                        a {
                            color: 
                            text-decoration: none;
                        }
                
                        a:hover {
                            text-decoration: underline;
                        }
                    </style>
                </head>
                <body>
                    <div class="error-box">
                        <h2>Erro de Processamento</h2>
                        <p>Infelizmente, parece que ocorreu um erro durante o processamento. Não se preocupe! Vou te ajudar a resolver isso.</p>
                        <p>Por favor, entre em contato com o suporte através do seguinte link: <a href="https://suporte.azapfy.com.br">suporte.azapfy.com.br</a> e nos forneça o erro abaixo. Estamos aqui para ajudar!</p>
                        <p><strong>Detalhes do Erro:</strong> ' . $e->getMessage() . '</p>
                    </div>
                </body>
                </html>';
                return $htmlError;
            }
        }
    }
}
