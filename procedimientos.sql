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

-- ==== ACTIVAR USUARIO ====
DROP PROCEDURE IF EXISTS activarUsuario;
DELIMITER //

CREATE DEFINER=CURRENT_USER PROCEDURE activarUsuario(
    IN p_Mail VARCHAR(255)
)
BEGIN
    DECLARE huboCambio INT DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Ocurrió un error, transacción revertida' AS message;
    END;

    START TRANSACTION;

    UPDATE personas
    SET Estado = 'Activo'
    WHERE TRIM(Mail) COLLATE utf8mb4_0900_ai_ci
          = TRIM(p_Mail) COLLATE utf8mb4_0900_ai_ci
      AND Estado <> 'Activo';

    SET huboCambio = ROW_COUNT();

    IF huboCambio > 0 THEN
        COMMIT;
        SELECT 'Usuario activado exitosamente' AS message;
    ELSE
        ROLLBACK;
        SELECT 'Error: No se encontró ningún usuario con ese email o ya se encuentra activo' AS message;
    END IF;
END //
//
DELIMITER ;

-- ==== DESACTIVAR USUARIO ====
DROP PROCEDURE IF EXISTS desactivarUsuario;
DELIMITER //

CREATE DEFINER=CURRENT_USER PROCEDURE desactivarUsuario(
    IN p_Mail VARCHAR(255)
)
BEGIN
    DECLARE huboCambio INT DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Ocurrió un error, transacción revertida' AS message;
    END;

    START TRANSACTION;

    UPDATE personas
    SET Estado = 'Inactivo'
    WHERE TRIM(Mail) COLLATE utf8mb4_0900_ai_ci
          = TRIM(p_Mail) COLLATE utf8mb4_0900_ai_ci
      AND Estado <> 'Inactivo';   
      
    SET huboCambio = ROW_COUNT();

    IF huboCambio > 0 THEN
        COMMIT;
        SELECT 'Usuario desactivado exitosamente' AS message;
    ELSE
        ROLLBACK;
        SELECT 'Error: No se encontró ningún usuario con ese email o ya se encuentra desactivado' AS message;
    END IF;
END //
//
DELIMITER ;