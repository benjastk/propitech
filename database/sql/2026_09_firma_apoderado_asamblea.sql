-- Firma de Gustavo Cisternas (apoderado) como parámetro general, reutilizada
-- en todos los poderes simples de asamblea generados por mandato.
-- Script manual: revisar y ejecutar directamente en MySQL (no es una
-- migración de Laravel; este proyecto no gestiona el schema de esta BD con
-- `php artisan migrate`).

START TRANSACTION;

-- Amplía textoValorParametro a LONGTEXT para poder guardar ahí una imagen
-- en base64 (varios KB). No afecta a los parámetros existentes, que son
-- valores cortos y se preservan igual.
ALTER TABLE parametros_generales
    MODIFY textoValorParametro LONGTEXT NULL;

-- Fila del parámetro que guarda la firma del apoderado. Se administra desde
-- /parametros/firma-apoderado-asamblea (vista dedicada con canvas de firma),
-- no desde el formulario genérico de "Editar" de parámetros.
INSERT INTO parametros_generales (parametroGeneral, valorParametro, textoValorParametro, notas)
SELECT 'FIRMA APODERADO ASAMBLEA', NULL, NULL, 'Firma de Gustavo Cisternas usada en el poder simple de asamblea'
WHERE NOT EXISTS (
    SELECT 1 FROM parametros_generales WHERE parametroGeneral = 'FIRMA APODERADO ASAMBLEA'
);

COMMIT;
