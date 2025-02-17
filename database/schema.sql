-- Cambios de Rafa

ALTER TABLE `eventos` ADD `tipo_creador` CHAR(1) NOT NULL DEFAULT 'O' AFTER `nombreEvento`;
ALTER TABLE `eventos` CHANGE `tipo_creador` `tipo_creador` CHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

-- 09/02/2025

CREATE TABLE `takeit`.`qr_codes` (`qrcodeID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT , `eventoID` BIGINT(20) UNSIGNED NOT NULL , `usuarioID` BIGINT(20) UNSIGNED NOT NULL , `rutaqr` TEXT NOT NULL , PRIMARY KEY (`qrcodeID`)) ENGINE = InnoDB;

ALTER TABLE `qr_codes` ADD CONSTRAINT `qr_ibfk_1` FOREIGN KEY (`eventoID`) REFERENCES `eventos`(`eventoID`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `qr_codes` ADD CONSTRAINT `qr_ibfk_2` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios`(`usuarioID`) ON DELETE RESTRICT ON UPDATE RESTRICT;


ALTER TABLE `eventos` ADD COLUMN `createby` INT(11) NOT NULL;


-- 10/02/2025 kevin
ALTER TABLE `qr_codes` ADD `estado` TINYINT(1) NOT NULL DEFAULT '1' AFTER `rutaqr`;