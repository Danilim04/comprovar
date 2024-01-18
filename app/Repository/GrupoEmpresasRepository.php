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
        $grupoEmpresas = Grupo_empresa::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$project' => [
                        'grupo_emp' => '$grupo_emp',
                        'tipo_emp' => '$tipo_emp',
                        'bases' => [
                            '$cond' => [
                                'if' => ['$ifNull' => ['$bases.MATRIZ', false]],
                                'then' => '$bases.MATRIZ',
                                'else' => ['$objectToArray' => '$bases'],
                            ]
                        ],
                        'cnpjs' => '$cnpjs',
                        'dataComeco' => [
                            '$dateToString' => [
                                'format' => '%Y-%m-%d',
                                'date' => '$created_at',
                                'timezone' => 'UTC',
                            ],
                        ],
                    ],
                ],
            ]);
        });

        $resultadosDoProjeto = $grupoEmpresas->toArray();
        return $resultadosDoProjeto;
    }
    public function getTotalDocs($grupo_emp, $dataInicio, $dataFim)
    {
        if (isset($dataInicio) && isset($dataFim)) {
            $docs = Doc::raw(function ($collection) use ($dataInicio, $dataFim, $grupo_emp) {
                return $collection->aggregate([
                    [
                        '$match' => [
                            'dt_emis' => [
                                '$gte' => new UTCDateTime(Carbon::parse($dataInicio, $this->timezone)->startOfDay()),
                                '$lte' => new UTCDateTime(Carbon::parse($dataFim, $this->timezone)->endOfDay()),
                            ],
                            $grupo_emp => ['$exists' => true],
                        ],
                    ],
                    [
                        '$count' => 'total_documents',
                    ],
                ]);
            });
            $totalDocuments = $docs->first()->total_documents ?? 0;
        } else {
            $docs = Doc::raw(function ($collection) use ($dataInicio, $dataFim, $grupo_emp) {
                return $collection->aggregate([
                    [
                        '$match' => [
                            'dt_emis' => [
                                '$gte' => new UTCDateTime(Carbon::now($this->timezone)->startOfDay()),
                                '$lte' => new UTCDateTime(Carbon::now($this->timezone)->endOfDay()),
                            ],
                            $grupo_emp => ['$exists' => true],
                        ],
                    ],
                    [
                        '$count' => 'total_documents',
                    ],
                ]);
            });
            $totalDocuments = $docs->first()->total_documents ?? 0;
        }
        return $totalDocuments;
    }
    public function getIntegracoes($grupo_emp)
    {
        $integracoes = Integracao::raw(function ($collection) use ($grupo_emp) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'ativo' => true,
                        'grupo_emp' => $grupo_emp,
                        'cron' => ['$nin' => ["NT", "nt"]]
                    ]
                ],
                [
                    '$count' => 'total_integra'
                ]
            ]);
        });;
        $totalIntegra = $integracoes->first()->total_integra ?? 0;
        return $totalIntegra;
    }
    public function getTotalComprovados($grupo_emp, $dataInicio, $dataFim)
    {
        if (isset($dataInicio) && isset($dataFim)) {
            $docs = Doc::raw(function ($collection) use ($dataInicio, $dataFim, $grupo_emp) {
                return $collection->aggregate([
                    [
                        '$match' => [
                            'dt_emis' => [
                                '$gte' => new UTCDateTime(Carbon::parse($dataInicio, $this->timezone)->startOfDay()),
                                '$lte' => new UTCDateTime(Carbon::parse($dataFim, $this->timezone)->endOfDay()),
                            ],
                            $grupo_emp => ['$exists' => true],
                            "$grupo_emp.status" => [
                                '$in' => ["COMPROVADO", "PROTOCOLADO", "VALIDADO"]
                            ],
                            'historico.cam_imagem' => ['$exists' => true]
                        ],
                    ],
                    [
                        '$count' => 'total_documents',
                    ],
                ]);
            });
            $totalDocuments = $docs->first()->total_documents ?? 0;
        } else {
            $docs = Doc::raw(function ($collection) use ($dataInicio, $dataFim, $grupo_emp) {
                return $collection->aggregate([
                    [
                        '$match' => [
                            'dt_emis' => [
                                '$gte' => new UTCDateTime(Carbon::now($this->timezone)->startOfDay()),
                                '$lte' => new UTCDateTime(Carbon::now($this->timezone)->endOfDay()),
                            ],
                            $grupo_emp => ['$exists' => true],
                            "$grupo_emp.status" => [
                                '$in' => ["COMPROVADO", "PROTOCOLADO", "VALIDADO"]
                            ],
                            'historico.cam_imagem' => ['$exists' => true]
                        ],
                    ],
                    [
                        '$count' => 'total_documents',
                    ],
                ]);
            });
            $totalDocuments = $docs->first()->total_documents ?? 0;
        }
        return $totalDocuments;
    }
    public function getUsers($grupo_emp, $tipoUser)
    {
        $usuarios = User::raw(function ($collection) use ($grupo_emp, $tipoUser) {
            return $collection->aggregate([
                [
                    '$match' => [
                        "grupos.$grupo_emp" => ['$exists' => true],
                        "grupos.$grupo_emp.ativo" => true,
                        "grupos.$grupo_emp.grupo_user" => $tipoUser
                    ],
                ],
                [
                    '$project' => [
                        'grupo_user' => '$grupos.' . $grupo_emp . '.grupo_user'
                    ],
                ],
                [
                    '$count' => 'grupo_user',
                ],
            ]);
        });

        $totalUser = $usuarios->first()->grupo_user ?? 0;
        return $totalUser;
    }
    public function getDocsRomaneio($grupo_emp, $dataInicio, $dataFim)
    {
        $grupo_empCorrigido = "$" . $grupo_emp;
        if (isset($dataInicio) && isset($dataFim)) {
            $docs = Doc::raw(function ($collection) use ($dataInicio, $dataFim, $grupo_emp, $grupo_empCorrigido) {
                return $collection->aggregate([
                    [
                        '$match' => [
                            'dt_emis' => [
                                '$gte' => new UTCDateTime(Carbon::parse($dataInicio, $this->timezone)->startOfDay()),
                                '$lte' => new UTCDateTime(Carbon::parse($dataFim, $this->timezone)->endOfDay()),
                            ],
                            $grupo_emp => ['$exists' => true],
                            "$grupo_emp.romaneio" => ['$exists' => true],
                        ],
                    ],
                    [
                        '$group' => [
                            '_id' => "$grupo_empCorrigido.romaneio.cpf_motorista",
                            'count' => ['$sum' => 1],
                        ],
                    ],
                    [
                        '$count' => 'motoristas'
                    ]
                ]);
            });

            $docsRomaneados = $docs->first()->motoristas ?? 0;
        } else {
            $docs = Doc::raw(function ($collection) use ($dataInicio, $dataFim, $grupo_emp, $grupo_empCorrigido) {
                return $collection->aggregate([
                    [
                        '$match' => [
                            'dt_emis' => [
                                '$gte' => new UTCDateTime(Carbon::now($this->timezone)->startOfDay()),
                                '$lte' => new UTCDateTime(Carbon::now($this->timezone)->endOfDay()),
                            ],
                            $grupo_emp => ['$exists' => true],
                            "$grupo_emp.romaneio" => ['$exists' => true],
                        ],
                    ],
                    [
                        '$group' => [
                            '_id' => "$grupo_empCorrigido.romaneio.cpf_motorista",
                            'count' => ['$sum' => 1],
                        ],
                    ],
                    [
                        '$count' => 'motoristas'
                    ]
                ]);
            });

            $docsRomaneados = $docs->first()->motoristas ?? 0;
        }
        return $docsRomaneados;
    }
}
