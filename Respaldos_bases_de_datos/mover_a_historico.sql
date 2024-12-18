DELIMITER //

CREATE PROCEDURE mover_a_historico()
BEGIN
    -- Insertar los registros de documentos en el histórico
    INSERT INTO historico_documentos (
        id_documento, anio_historico, folio, dep_origen, fecha_creacion, tipo_doc, ff, partida_cd, partida_fed, partida_est, partida_ip, partida_pa, asunto, observacion, nombre_documento, estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento, fecha_registro_historico, accion
    )
    SELECT 
        id_documento, 
        YEAR(fecha_creacion) AS anio_historico, 
        folio, 
        dep_origen, 
        fecha_creacion, 
        tipo_doc, 
        ff, 
        partida_cd, 
        partida_fed, 
        partida_est, 
        partida_ip, 
        partida_pa, 
        asunto, 
        observacion, 
        nombre_documento, 
        estatus, 
        fecha_movimiento, 
        ultimo_movimiento, 
        usuario_movimiento,
        CURRENT_DATE AS fecha_registro_historico, 
        'INSERT' AS accion -- Agregado valor 'INSERT' entre comillas
    FROM documentos
    WHERE YEAR(fecha_creacion) <= 2023;

    -- Eliminar los registros de la tabla documentos
    DELETE FROM documentos
    WHERE YEAR(fecha_creacion) <= 2023;
END //

DELIMITER ;

-- Llamar al procedimiento
CALL mover_a_historico();
