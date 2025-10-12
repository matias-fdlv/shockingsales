ShockingSales
En este repositorio se subiran los avances del proyecto del semestre 4 de la tecnicatura de redes y software por parte de SSTeam.
Equipo Formado por:
-Martán Leites
-Matías Franca De Lima
-Miguel Malavé
-Santiago Cabrera
-Nicolás Núñez


Guia de despliegue:
Requisitos previos para usar el programa:
docker instalado
docker compose instalado
sistema operativo linux

1) Clonar repositorio
2) Entrar a la carpeta del repositorio y establecer todos los archivos con permisos totales usando "chmod -R 777 ."
3) Hacerle build y up usando "docker compose up -d --build"
4) Entrar al bash de php usando "docker exec -it apache_php bash" y migrar usando "php artisan migrate"
5) Entrar a "localhost:8080" en el navegador de preferencia. 

CHANGELOG
---

[0.1.0] - 2025-08-20
Añadido
-Migraciones a la BD desde laravel
-Contenedores Docker pefectamente funcionando, con contenedor de PHP, BD y PHPMYadmin

---

[1.0.0] - 2025-08-30
Añadido
-Se agrega LogIn y SignIn
-Se agrega CRUD básico

---

[1.1.0] - 2025-09-16
Añadido
-Vistas de usuarios y admin separadas

---

[1.2.0] - 2025-09-23
Cambios
-Mejor estructuración del registro de usuarios, uso de guards para sesiones, uso del patrón de diseño Service Layout

---

[1.3.0] - 2025-09-24
Cambios
-Actualización en tablas de la BD y modelos de laravel relacionados a estas

---

[1.4.0] - 2025-09-30
Añadido
-Se agrega seeder para Administrador

---

[2.0.0] - 2025-10-12
Añadido
-Busqueda a traves de la barra de busqueda usando la Fake Store API, esta solo permite busqueda por categorías y en ingles.
-Seeder para las APIs de cada tienda


Modificado
-docker-compose.yml ahora incluye un nuevo contenedor MYSQL usado para la replicacion

Corrección de bugs
-Se arregla un bug que mataba a los contenedores de BD y PHP segundos despues de iniciarlos por culpa de datos que no concordaban entre versiones de la imágen docker MySQL que usabamos antes y la que usamos ahora.

---