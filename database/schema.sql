-- Cambios de Rafa

ALTER TABLE `eventos` ADD `tipo_creador` CHAR(1) NOT NULL DEFAULT 'O' AFTER `nombreEvento`;
ALTER TABLE `eventos` CHANGE `tipo_creador` `tipo_creador` CHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

-- 09/02/2025

CREATE TABLE `takeit`.`qr_codes` (`qrcodeID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT , `eventoID` BIGINT(20) UNSIGNED NOT NULL , `usuarioID` BIGINT(20) UNSIGNED NOT NULL , `rutaqr` TEXT NOT NULL , PRIMARY KEY (`qrcodeID`)) ENGINE = InnoDB;

USE `takeit`;
ALTER TABLE `qr_codes` ADD CONSTRAINT `qr_ibfk_1` FOREIGN KEY (`eventoID`) REFERENCES `eventos`(`eventoID`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `qr_codes` ADD CONSTRAINT `qr_ibfk_2` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios`(`usuarioID`) ON DELETE RESTRICT ON UPDATE RESTRICT;


-- 09/02/2025 Pepe
ALTER TABLE `eventos` ADD COLUMN `createby` INT(11) NOT NULL;

-- 10/02/2025 kevin
ALTER TABLE `qr_codes` ADD `estado` TINYINT(1) NOT NULL DEFAULT '1' AFTER `rutaqr`;
    
    

    
-- 06/03/2025 Rafa -- Cambio en costo evento para poder meter json con los precios de cada tipo de entrada
ALTER TABLE `eventos` CHANGE `costoEvento` `costoEvento` JSON NULL DEFAULT NULL;
-- Ejemplo de como se guarda en la base de datos
-- "costoEvento": [
--     {
--         "nombre": "entrada_general",
--         "precio": 10
--     },
--     {
--             "nombre": "entrada_vip",
--             "precio": 20
--         },
--         {
--             "nombre": "entrada_palco",
--             "precio": 30
--         }
--     ]

update eventos set costoEvento = '[{"nombre": "entrada_general", "precio": 10}, {"nombre": "entrada_vip", "precio": 20}, {"nombre": "entrada_palco", "precio": 30}]';


-- 10/03/2025 PEPE --- nueva tabla de reportes 

-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `reporteID` int(11) NOT NULL,
  `eventoID` bigint(20) UNSIGNED NOT NULL,
  `Tipo` varchar(255) NOT NULL,
  `usuarioID` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion` int(11) NOT NULL,
  `detalle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`reporteID`),
  ADD KEY `fk_usuariosID` (`usuarioID`),
  ADD KEY `fk_eventos` (`eventoID`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `fk_eventos` FOREIGN KEY (`eventoID`) REFERENCES `eventos` (`eventoID`),
  ADD CONSTRAINT `fk_usuariosID` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios` (`usuarioID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
