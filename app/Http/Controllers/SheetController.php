<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleSheetsService;


class SheetController extends Controller
{   
    private $googleSheetsService;

    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    public function ApiSheets(Request $request)
    {
        $getData = $this->googleSheetsService->getData();
        $retorno = [
            "status" => true,
            "Empresas atualizadas" => $getData
        ];
        return $retorno;
    }    
}
