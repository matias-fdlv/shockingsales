-- 1. Insertar Toys Store
INSERT INTO tiendas (Nombre, API, Estado, BaseURL, created_at, updated_at) 
VALUES ('Toys Store', 'toys_store', 1, 'http://api-web-toy/api', NOW(), NOW());

-- Obtener ID insertado
SET @toys_id = LAST_INSERT_ID();

-- Insertar credenciales para Toys Store (placeholder)
INSERT INTO credencialesTiendas (IDTienda, Tipo, Valor) 
VALUES (@toys_id, 'api_token', 'no_requerido');

-- 2. Insertar Tech Store  
INSERT INTO tiendas (Nombre, API, Estado, BaseURL, created_at, updated_at) 
VALUES ('Tech Store', 'tech_store', 1, 'http://api-web-tech/api', NOW(), NOW()); 

SET @tech_id = LAST_INSERT_ID();

INSERT INTO credencialesTiendas (IDTienda, Tipo, Valor) 
VALUES (@tech_id, 'api_token', 'no_requerido'); 