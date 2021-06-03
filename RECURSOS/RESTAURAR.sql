set sql_safe_updates=0;

#DELETE FROM tickets_sistemas_comentarios;
#DELETE FROM tickets_sistemas_fotos;
#DELETE FROM tickets_sistemas;
#ALTER TABLE tickets_sistemas AUTO_INCREMENT=1;
#ALTER TABLE tickets_sistemas_comentarios AUTO_INCREMENT=1;
#ALTER TABLE tickets_sistemas_fotos AUTO_INCREMENT=1;

#DELETE FROM tickets_autos_comentarios;
#DELETE FROM tickets_autos_fotos;
#DELETE FROM tickets_autos;
#ALTER TABLE tickets_autos AUTO_INCREMENT=1;
#ALTER TABLE tickets_autos_comentarios AUTO_INCREMENT=1;
#ALTER TABLE tickets_autos_fotos AUTO_INCREMENT=1;

#DELETE FROM tickets_edificio_comentarios;
#DELETE FROM tickets_edificio_fotos;
#DELETE FROM tickets_edificio;
#ALTER TABLE tickets_edificio AUTO_INCREMENT=1;
#ALTER TABLE tickets_edificio_comentarios AUTO_INCREMENT=1;
#ALTER TABLE tickets_edificio_fotos AUTO_INCREMENT=1;


DELETE FROM revisiones_hallazgos;
ALTER TABLE revisiones_hallazgos AUTO_INCREMENT=1;
DELETE FROM autos_revisiones;
ALTER TABLE autos_revisiones AUTO_INCREMENT=1;

DELETE from temp;
ALTER TABLE temp auto_increment=1;

DELETE FROM ordenes_compra_conceptos;
ALTER TABLE ordenes_compra_conceptos AUTO_INCREMENT=1;
DELETE FROM ordenes_compra;
ALTER TABLE ordenes_compra AUTO_INCREMENT=1;
