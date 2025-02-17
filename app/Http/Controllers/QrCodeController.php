<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrCode;

class QrCodeController extends Controller
{
    public function getQrCode($usuarioID, $eventoID)
    {
        $qrCode = QrCode::where('usuarioID', $usuarioID)
                        ->where('eventoID', $eventoID)
                        ->first();

        if ($qrCode) {
            return response()->json($qrCode, 200);
        } else {
            return response()->json(['message' => 'QR Code not found'], 404);
        }
    }
}