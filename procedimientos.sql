-- PROCEDIMIENTO CREACION DE ADMINS
DELIMITER //
create procedure altaAdmin(
IN p_Nombre VARCHAR(255),
IN p_Mail VARCHAR(255),
IN p_Password VARCHAR(255)
)
BEGIN
	DECLARE L_ID INT;
    
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
        SELECT 'Ocurrio un error, transaccion revertida' AS message;
	END;
    
	START TRANSACTION;

	INSERT INTO personas (Estado, Nombre, Mail, password)
	VALUES ('Activo', p_Nombre, p_Mail, p_Password);

	SET L_ID = LAST_INSERT_ID();

	INSERT INTO administradors (IDPersona)
	VALUES (L_ID);
	COMMIT;
SELECT L_ID AS IDPersona;
END //
DELIMITER ;

-- PROCEDIMIENTO CREACION DE USUARIOS
DELIMITER //
create procedure altaUsuario(
IN p_Nombre VARCHAR(255),
IN p_Mail VARCHAR(255),
IN p_Password VARCHAR(255)
)
BEGIN
	DECLARE L_ID INT;
    
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;
        SELECT 'Ocurrio un error, transaccion revertida' AS message;
	END;
	START TRANSACTION;

	INSERT INTO personas (Estado, Nombre, Mail, Password)
	VALUES ('Activo', p_Nombre, p_Mail, p_Password);

	
	SET L_ID = LAST_INSERT_ID();

	INSERT INTO usuarios (IDPersona)
	VALUES (L_ID);
	COMMIT;

SELECT L_ID AS IDPersona;

END //
DELIMITER ;