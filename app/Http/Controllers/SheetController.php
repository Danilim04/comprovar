<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheetsService;
use MongoDB\BSON\UTCDateTime;


class SheetController extends Controller
{   
    private $googleSheetsService;

    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    public function ApiSheets(Request $request)
    {
        $dados = $request->all();
        $getData = $this->googleSheetsService->validarRequest($dados);
        $retorno = [
            "status" => true,
            "Empresas atualizadas" => $getData
        ];
        return $retorno;
    }    
}
