<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\reporte;

use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function reportes($IDorganizador){
        try {
            $totalReportes = Reporte::join('eventos', 'reportes.eventoID', '=', 'eventos.eventoID')
                ->where('eventos.createby', $IDorganizador)
                ->count(); 

            return ResponseHelper::success('Reportestotales', $totalReportes, 200);
        } catch (\Exception $e) {
            return ResponseHelper::error('Error al obtener reportes', 500, $e->getMessage());
        }
    }

    public function reportesEventos($IDorganizador){
        try {
            $reportesEventos = Reporte::select('reportes.*', 'eventos.nombreEvento', 'usuarios.nombreUsuario')
                ->join('eventos', 'reportes.eventoID', '=', 'eventos.eventoID')
                ->join('usuarios', 'reportes.usuarioID', '=', 'usuarios.usuarioID')
                ->where('eventos.createby', $IDorganizador)
                ->get(); 

            return ResponseHelper::success('Reportestotales', $reportesEventos, 200);
        } catch (\Exception $e) {
            return ResponseHelper::error('Error al obtener reportes', 500, $e->getMessage());
        }
    }

    public function updatereportesstatus ($ReportesID){
        try {
            $reportes = Reporte::where('reporteID', $ReportesID)
                ->update(['activoReporte' => 0]);

            return ResponseHelper::success('Reportes actualizados', $reportes, 200);
        } catch (\Exception $e) {
            return ResponseHelper::error('Error al actualizar reportes', 500, $e->getMessage());
        }
    }

    public function crearYInsertarReportes()
    {
        // Crear la tabla reportes si no existe
        DB::statement("
            CREATE TABLE IF NOT EXISTS `reportes` (
                `reporteID` INT(11) NOT NULL AUTO_INCREMENT,
                `eventoID` BIGINT(20) UNSIGNED NOT NULL,
                `Tipo` VARCHAR(255) NOT NULL,
                `usuarioID` BIGINT(20) UNSIGNED NOT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `descripcion` VARCHAR(255) NULL,
                `detalle` TEXT NULL,
                `activoReporte` TINYINT(1) NOT NULL DEFAULT 1,
                PRIMARY KEY (`reporteID`),
                KEY `fk_usuariosID` (`usuarioID`),
                KEY `fk_eventos` (`eventoID`),
                CONSTRAINT `fk_eventos` FOREIGN KEY (`eventoID`) REFERENCES `eventos` (`eventoID`),
                CONSTRAINT `fk_usuariosID` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios` (`usuarioID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ");

        // Insertar datos en la tabla reportes
        DB::statement("
            INSERT INTO `reportes` (`reporteID`, `eventoID`, `Tipo`, `usuarioID`, `created_at`, `descripcion`, `detalle`, `activoReporte`) VALUES
            (1, 1, 'Seguridad', 5, '2025-03-09 08:08:33', 'Pepe se durmió', 'Pepe se durmio en las oficinas', 1),
            (2, 2, 'Logística', 8, '2025-03-09 08:08:33', 'Amo a rafa','Rafa esta mut guapo' , 1),
            (3, 3, 'Emergencia', 12, '2025-03-09 08:08:33', 'Falta completar', 'Bolio es gei', 1)
            ON DUPLICATE KEY UPDATE
            `Tipo` = VALUES(`Tipo`),
            `usuarioID` = VALUES(`usuarioID`),
            `created_at` = VALUES(`created_at`),
            `descripcion` = VALUES(`descripcion`),
            `detalle` = VALUES(`detalle`),
            `activoReporte` = VALUES(`activoReporte`);
        ");

        return response()->json(['message' => 'Tabla reportes creada e información insertada correctamente']);
    }

}
