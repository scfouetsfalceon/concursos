ALTER TABLE jovenes ADD COLUMN historico VARCHAR(4) NULL DEFAULT NULL  AFTER estado ;
ALTER TABLE tipo ADD COLUMN sexo INT(1) NOT NULL  AFTER nombre ;
UPDATE tipo SET sexo='1' WHERE id='1';
UPDATE tipo SET sexo='2' WHERE id='2';
UPDATE tipo SET sexo='1' WHERE id='3';
UPDATE tipo SET sexo='2' WHERE id='4';
UPDATE tipo SET sexo='1' WHERE id='5';
UPDATE tipo SET sexo='2' WHERE id='6';
