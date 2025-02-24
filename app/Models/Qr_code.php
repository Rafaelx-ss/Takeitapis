<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qr_code extends Model
{
    protected $table = 'qr_codes';
    protected $primaryKey = 'qrcodeID';
    public $timestamps = false;

    protected $fillable = [
        'eventoID',
        'usuarioID',
        'rutaqr',
        'estado'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'eventoID');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarioID');
    }   
}


// CREATE TABLE `takeit`.`qr_codes` (`qrcodeID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT , `eventoID` BIGINT(20) UNSIGNED NOT NULL , `usuarioID` BIGINT(20) UNSIGNED NOT NULL , `rutaqr` TEXT NOT NULL , PRIMARY KEY (`qrcodeID`)) ENGINE = InnoDB;

// ALTER TABLE `qr_codes` ADD CONSTRAINT `qr_ibfk_1` FOREIGN KEY (`eventoID`) REFERENCES `eventos`(`eventoID`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `qr_codes` ADD CONSTRAINT `qr_ibfk_2` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios`(`usuarioID`) ON DELETE RESTRICT ON UPDATE RESTRICT;