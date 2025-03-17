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
- **Coordinador**: Crea programas, ambientes, fichas e instructores.
- **Instructor**: Toma lista de asistencia y verifica reportes.