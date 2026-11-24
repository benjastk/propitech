-- =====================================================================
-- Quitar el registro de Portal Inmobiliario a las propiedades ARRENDADAS
-- (idEstado = 43). Solo toca BD: NO cierra nada en el portal.
--
-- Columnas que se limpian (igual que deleteProperties()):
--   itemIDPortal                -> ''
--   urlPortalInmobiliario       -> ''
--   eliminadoPortalInmobiliario -> 0
--
-- Ejecutar paso a paso, revisando el resultado de cada SELECT.
-- =====================================================================


-- ---------------------------------------------------------------------
-- PASO 0: confirmar que el 43 es ARRENDADA en esta BD
-- ---------------------------------------------------------------------
SELECT idEstado, nombreEstado FROM estados WHERE idEstado = 43;


-- ---------------------------------------------------------------------
-- PASO 1: vista previa de lo que se va a limpiar
-- ---------------------------------------------------------------------
SELECT p.id, p.nombrePropiedad, p.direccion, p.numero,
       p.itemIDPortal, p.urlPortalInmobiliario, p.eliminadoPortalInmobiliario
FROM propiedades p
WHERE p.idEstado = 43
  AND p.itemIDPortal IS NOT NULL
  AND p.itemIDPortal <> ''
ORDER BY p.id;

SELECT COUNT(*) AS total_a_limpiar
FROM propiedades
WHERE idEstado = 43
  AND itemIDPortal IS NOT NULL
  AND itemIDPortal <> '';


-- ---------------------------------------------------------------------
-- PASO 2: respaldo (permite revertir con el PASO 5)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS bkp_20261123_portal_arrendadas AS
SELECT id, idEstado, itemIDPortal, urlPortalInmobiliario, eliminadoPortalInmobiliario, NOW() AS fecha_respaldo
FROM propiedades
WHERE idEstado = 43
  AND itemIDPortal IS NOT NULL
  AND itemIDPortal <> '';

-- Debe coincidir con total_a_limpiar del PASO 1
SELECT COUNT(*) AS respaldadas FROM bkp_20261123_portal_arrendadas;


-- ---------------------------------------------------------------------
-- PASO 3: limpieza (solo las que están en el respaldo)
-- ---------------------------------------------------------------------
START TRANSACTION;

UPDATE propiedades p
JOIN bkp_20261123_portal_arrendadas b ON b.id = p.id
SET p.itemIDPortal = '',
    p.urlPortalInmobiliario = '',
    p.eliminadoPortalInmobiliario = 0
WHERE p.idEstado = 43;

-- Filas afectadas deben coincidir con el PASO 1. Si coincide: COMMIT; si no: ROLLBACK;
SELECT ROW_COUNT() AS filas_actualizadas;

COMMIT;
-- ROLLBACK;


-- ---------------------------------------------------------------------
-- PASO 4: verificación (debe devolver 0)
-- ---------------------------------------------------------------------
SELECT COUNT(*) AS arrendadas_con_portal
FROM propiedades
WHERE idEstado = 43
  AND itemIDPortal IS NOT NULL
  AND itemIDPortal <> '';


-- ---------------------------------------------------------------------
-- PASO 5 (solo si hay que revertir)
-- ---------------------------------------------------------------------
-- UPDATE propiedades p
-- JOIN bkp_20261123_portal_arrendadas b ON b.id = p.id
-- SET p.itemIDPortal = b.itemIDPortal,
--     p.urlPortalInmobiliario = b.urlPortalInmobiliario,
--     p.eliminadoPortalInmobiliario = b.eliminadoPortalInmobiliario;

-- Cuando ya no se necesite el respaldo:
-- DROP TABLE bkp_20261123_portal_arrendadas;
