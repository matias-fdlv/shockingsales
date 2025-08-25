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
