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


    public function QrCanjes($eventoID)
    {
        $qrCode = Qr_code::where('eventoID', $eventoID)
                        ->where('estado', 1)
                        ->get();
        if ($qrCode) {
            return ResponseHelper::success('Qr encontrados', $qrCode, 200);
        } else {
            return ResponseHelper::error('Qr no encontrados', [], 401);
        }
    }

    public function contarQrEstadoCero($eventoID)
    {
        $count = Qr_code::where('eventoID', $eventoID)
                        ->where('estado', 0)
                        ->count();
        return ResponseHelper::success('Cantidad de Qr con estado 0', ['count' => $count], 200);
    }

    public function VerParticiparticipantes($eventoID)
    {
        $qrCode = Qr_code::where('eventoID', $eventoID)
                        ->join('usuarios', 'usuarios.usuarioID', '=', 'qr_codes.usuarioID')
                        ->select('usuarios.nombreUsuario', 'usuarios.usuario', 'usuarios.email')
                        ->where('estado', 0)
                        ->get();
        if ($qrCode) {
            return ResponseHelper::success('Qr encontrados', $qrCode, 200);
        } else {
            return ResponseHelper::error('Qr no encontrados', [], 401);
        }
    }
}