-- Cambios de Rafa

ALTER TABLE `eventos` ADD `tipo_creador` CHAR(1) NOT NULL DEFAULT 'O' AFTER `nombreEvento`;
ALTER TABLE `eventos` CHANGE `tipo_creador` `tipo_creador` CHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

-- fin de cambios de Rafa