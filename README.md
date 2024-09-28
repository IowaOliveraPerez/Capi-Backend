# Nombre del Proyecto

Proyecto de backend para el ejercicio CAPI

## Tabla de Contenidos

-   [Instalación](#instalación)
-   [Uso](#uso)
-   [Créditos](#créditos)

## Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/IowaOliveraPerez/Capi-Backend.git

```

2. Modificar el .env:
   Se debe generar el .env a partir del archivo de ejemplo que se encuentra en el repositorio.
   Luego se debe modificar la conexion de la base de datos para que apunte a una base de datos vacía que esté en su servidor.

3. Instalar las dependencias

```bash
cd Capi-Backend
composer install
php artisan key:generate
php artisan migrate:fresh --seed
```

Esto generará y poblará la base de datos con 5000 registros de contactos y al menos 5000 registros en las demás tablas.

## Uso

Para iniciar la aplicación, ejecuta el siguiente comando:

```bash
php artisan serve
```

El servidor se ejecutará en http://localhost:8000 y estará listo para recibir peticiones.

## Créditos

-   Desarrollador: [Iowa Alejandro Olivera Pérez](https://github.com/IowaOliveraPerez)
