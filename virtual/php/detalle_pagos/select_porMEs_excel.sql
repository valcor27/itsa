SELECT 
    dep.nombreUnidad, 
    p.partida, 
    p.capitulo, 
    UPPER(CASE MONTH(p.fecha_pago) 
        WHEN 1 THEN 'ENERO' 
        WHEN 2 THEN 'FEBRERO' 
        WHEN 3 THEN 'MARZO' 
        WHEN 4 THEN 'ABRIL' 
        WHEN 5 THEN 'MAYO' 
        WHEN 6 THEN 'JUNIO' 
        WHEN 7 THEN 'JULIO' 
        WHEN 8 THEN 'AGOSTO' 
        WHEN 9 THEN 'SEPTIEMBRE' 
        WHEN 10 THEN 'OCTUBRE' 
        WHEN 11 THEN 'NOVIEMBRE' 
        WHEN 12 THEN 'DICIEMBRE' 
    END) AS mes, 
    SUM(dp.monto_detalle_pago) AS suma_total 
FROM detalle_pagos AS dp 
INNER JOIN pagos AS p 
ON p.id_pago = dp.pagos_id_pago 
INNER JOIN estructuraorganica AS dep 
ON dp.unidad_clave_unidad = dep.claveUnidad 
WHERE 
    dp.unidad_clave_unidad IN (11201, 11202, 11203, 11204, 11205, 11206) 
AND p.capitulo IN (2000, 3000) 
GROUP BY dep.nombreUnidad, p.partida, p.capitulo, MONTH(p.fecha_pago) 
ORDER BY dep.nombreUnidad, p.partida, p.capitulo, MONTH(p.fecha_pago) ASC;