# Sistema de Gestión de Asistencias SENA

Este proyecto es un sistema web desarrollado para gestionar las asistencias de los aprendices del SENA. Está construido utilizando **HTML**, **Tailwind CSS**, **PHP**, **MySQL**, y sigue el paradigma de **Programación Orientada a Objetos (POO)** con el patrón de diseño **Singleton**.

---

## Requerimientos del Sistema

- **PHP 7.4 o superior**
- **MySQL 5.7 o superior**
- **Servidor web (Apache, Nginx, etc.)**

---

## Instalación

1. Clona el repositorio.
2. Crea la base de datos `sena_asistencias` e importa el archivo SQL.
3. Configura las credenciales de la base de datos en `includes/Database.php`.
4. Accede al sistema desde `login.php`.

---

## Uso

- **Super Administrador**: Gestiona regionales, centros y coordinadores.
- **Coordinador**: Crea programas, ambientes, fichas, instructores y vigilar reporte de inasistencia de aprendices.
- **Instructor**: Toma lista de asistencia y verifica reportes.

---

## Usuarios creador predeterminados
- **Super Administrador**: Usuario: Juan Pablo,  Contraseña: 12345
- **Coordinador**: Usuario: Angie Dahiana Rios, Contraseña: 98765
- **Instructor**: Usuario: Jhon Alexander Pineda, Contraseña: 12345

--- 

## Pasos a seguir
- **Para ejecutar**: ingresar en el navegador: http://localhost/gestorAsistencias/login.php
- **Login**: Para agregar a otro coordinador o super-admin deben de ingresar con el super-admin ya existente o eliminarlo y crear uno nuevo desde register por que como el sistema ya reconoce que hay uno creado no dejara registrar a nadie mas manualmente.
- **Al ingresar**: Dependiendo como entres ya podras ver las funciones que tenga cada uno y podras ejecutar y probar las que quieras.