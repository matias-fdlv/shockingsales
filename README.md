ShockingSales<br>
En este repositorio se subiran los avances del proyecto del semestre 4 de la tecnicatura de redes y software por parte de SSTeam.<br><br>
Equipo Formado por:<br>
-Martán Leites<br>
-Matías Franca De Lima<br>
-Miguel Malavé<br>
-Santiago Cabrera<br>
-Nicolás Núñez<br>


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

[0.1.0] - 2025-08-20<br>
Añadido<br>
-Migraciones a la BD desde laravel<br>
-Contenedores Docker pefectamente funcionando, con contenedor de PHP, BD y PHPMYadmin

---

[1.0.0] - 2025-08-30<br>
Añadido<br>
-Se agrega LogIn y SignIn<br>
-Se agrega CRUD básico

---

[1.1.0] - 2025-09-16<br>
Añadido<br>
-Vistas de usuarios y admin separadas

---

[1.2.0] - 2025-09-23<br>
Cambios<br>
-Mejor estructuración del registro de usuarios, uso de guards para sesiones, uso del patrón de diseño Service Layout

---

[1.3.0] - 2025-09-24<br>
Cambios<br>
-Actualización en tablas de la BD y modelos de laravel relacionados a estas

---

[1.4.0] - 2025-09-30<br>
Añadido<br>
-Se agrega seeder para Administrador

---

[2.0.0] - 2025-10-12<br>
Añadido<br>
-Busqueda a traves de la barra de busqueda usando la Fake Store API, esta solo permite busqueda por categorías y en ingles.<br>
-Seeder para las APIs de cada tienda

Modificado<br>
-docker-compose.yml ahora incluye un nuevo contenedor MYSQL usado para la replicacion

Corrección de bugs<br>
-Se arregla un bug que mataba a los contenedores de BD y PHP segundos despues de iniciarlos por culpa de datos que no concordaban entre versiones de la imágen docker MySQL que usabamos antes y la que usamos ahora.

---