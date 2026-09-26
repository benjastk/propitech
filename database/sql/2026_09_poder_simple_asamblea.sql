-- Poder simple para asamblea de copropietarios (representante: Gustavo
-- Cisternas Perez, en representación de Inversiones y Servicios
-- Profesionales B&C Spa) + firma del propietario vía URL externa.
-- Script manual: revisar y ejecutar directamente en MySQL (no es una
-- migración de Laravel; este proyecto no gestiona el schema de esta BD con
-- `php artisan migrate`).

START TRANSACTION;

-- Firma (imagen base64 capturada desde el canvas de la vista externa) y
-- fecha de firma del poder simple de asamblea, por mandato de
-- administración. NULL = aún no firmado por el propietario.
ALTER TABLE mandatos_propiedad
    ADD COLUMN firmaPoderSimpleAsamblea LONGTEXT NULL AFTER tokenMandato,
    ADD COLUMN fechaFirmaPoderSimpleAsamblea DATETIME NULL AFTER firmaPoderSimpleAsamblea;

-- Nota: `tokenMandato` ya existe en la tabla y se usa como identificador de
-- la URL externa de firma (/firma-poder-simple/{tokenMandato}). Los
-- mandatos creados antes de que ese campo se empezara a generar quedan con
-- valor NULL; el controlador lo autogenera y persiste la primera vez que se
-- necesita (al listar mandatos por propiedad), no requiere backfill manual.

COMMIT;
