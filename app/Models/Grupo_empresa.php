<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Grupo_empresa extends Model
{
    protected $collection = 'grupo_empresas';
    protected $connection = 'mongodb';
   
    public function getObrigatoriosGrupoEmpresa()
    {
        return $this->obrigatoriosGrupoEmpresa;
    }

    protected $fillable = [
        "TESTE1611",
        "FURIA",
        "FAZE",
        "TESTE 1811",
        "LIQUID",
        "G2",
        "TESTECNPJ",
        "TESTE2211",
        "INFOTRANS",
        "SHARKS",
        "HULCK",

        "TESTE2",
        "TESTE3",
        "TTESTEE",
        "VITALITY",
        "ASTRALIS",
        "NAVI",
        "TETOOO",
        "TESTE",
        "TESTE2",
        "TESTE3",
        "TTESTEE",
        "TRANSMED",
        "FHSO",
        "AGILE",
        "CASAALADIM",
        "VAPTVUPT",
        "IZITRANSP",
        "VAPUTVUPT",
        "FENIX",
        "FONSECA",
        "WANDERLEY",
        "AACR",
        "TNORTE",
        "MEDLOG",
        "AACARVALHO",
        "JSP",
        "ALMEIDA",
        "WF",
        "R2B",
        "ITZ",
        "NAZARIA",
        "INFODEC",
        "TOTAL",
        "LOGAKI",
        "SANTACLARA",
        "PONTUAL",
        "MM",
        "PG",
        "JOBSON",
        "PONTUALCARGA",
        "M&M",
        "JOSEAUGUSTO",
        "FM",
        "RC",
        "TRANSLIDER",
        "TRANSSOARES",
        "AR4D",
        "OFFICE",
        "PACOTE",
        "EXPRESSO",
        "TRANSELLO",
        "TEGMA",
        "CEPALAB",
        "TRANSDONATTO",
        "TESTSE",
        "GSFARMA",
        "RODOFAR",
        "AZAPFYESAS",
        "REDEMINEIRA",
        "grupo_emp",
        "nome_grupo",
        "hash",
        "tipo_emp",
        "bases",
        "cnpjs",
        "razao_social",
        "docs",                
        'usa_cerca',          
        'usa_rotas',            
        'ocorrencias_emp',
        'gerais',
        'logo',
        'seguro',
        'parametros_sac'

    ];

 
    protected $obrigatoriosGrupoEmpresa = [
        'nome_grupo',
        'dados_grupo',
        'tipo_grupo',
        'rota',
        'pesquisar',
        'frete',
        'devolucao',
        'fiscal',
        'dashboard',
        'cadastros',
        'romaneios',
        'protocolos',
        'aplicativo',
        'auditoria',
        'rastreamento',
        'prazo'
    ];
}
