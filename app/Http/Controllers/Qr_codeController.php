<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qr_code;
use App\Helpers\ResponseHelper;


class Qr_codeController extends Controller
{
    public function getQrCode($eventoID, $usuarioID)
    {
        $qrCode = Qr_code::where('usuarioID', $usuarioID)
                        ->where('eventoID', $eventoID)
                        ->select('rutaqr')
                        ->first();
        if ($qrCode) {
            return ResponseHelper::success('Qr encontrado', $qrCode, 200);
        } else {
            return ResponseHelper::error('Qr no encontrado', [], 401);
        }
    }

    public function finalizarQR($usuarioID, $eventoID)
    {
        $qrCode = Qr_code::where('usuarioID', $usuarioID)
                        ->where('eventoID', $eventoID)
                        ->where('estado', 1)
                        ->first();
    
        if ($qrCode) {
            $qrCode->estado = 0;
            $qrCode->save();
    
            return ResponseHelper::success('Usuario registrado correctamente', $qrCode, 200);
        } 
    
        return ResponseHelper::error('Ticket  no encontrado', [], 200);
    }
    
}