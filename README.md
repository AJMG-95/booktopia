 
#[![Booktopia-1-removebg-preview.png](https://i.postimg.cc/7h9f6Gtx/Booktopia-1-removebg-preview.png)](https://postimg.cc/vx1Q2Bdj)



##Tabla de Contenido
***
- [Descripción](#descripción)
- [Funcionalidades Principales](#funcionalidades-principales)
- [Objetivos Generales](#objetivos-generales)
- [Tecnologías Utilizadas](#tecnologías-utilizadas)
- [Elemento de Innovación](#elemento-de-innovación)
- [Despliege de la Aplicación](#despliege-de-la-aplicación)
  - [1. Instalación de PHP](#1-instalación-de-php)
  - [2. Instalación de Composer](#2-instalación-de-composer)
  - [3. Instalación de PosygreSQL](#3-instalación-de-posygresql)
  - [4. Instalacion de la aplicacion Booktopia](#4-instalacion-de-la-aplicacion-booktopia)
  - [6. Configuración del archivo .env](#6-configuración-del-archivo-env)
  - [7. Configuracion de la base de datos](#7-configuracion-de-la-base-de-datos)
  - [8. Últimos pasos](#8-últimos-pasos)



## Descripción
***
Es una plataforma web que permite a los usuarios buscar y comprar libros de manera fácil, rápida y segura. Además funciones extra como realizar comentarios sobre y guardar notas privadas, así como un foro en el que expresar tu opinión.


## Funcionalidades Principales
***
-   **Busqueda de libros:** Los usuraios podrán buscar diferentes libros según sus preferencias.
-   **Agregar a la lista de deseo:** los usuarios pueden agregrar libros a su lista de deseos.
-   **Agregar a la lista de favoritos:** los usuarios pueden agregrar sus libros adquiridos a su lista de favoritos.
-   **Ver detalles del libro:** los usuarios pueden ver información completa sobre un libro, incluyendo reseñas sobre el mismo.
-   **Reaizar calificaciones:** Los usuarios pueden valorar los libros que compran, y estas calificaciones se mostrarán en la página principal del libro.
-   **Añadir valoracones:** Los usuarios podrán hacer comentarios sobre un libro para poder compartir su opinión con otros lectores.
-   **Añadir comentarios:** el sitio web ofrecerá un foro para que los usuarios puedan expresar sus opiniones.
-   **Notas:** los usuarios tendrán acceso a una sección donde podrán anotar de forma privada impresones sobre los libros que están leyendo o han leído.
-   **Funcionalidades Administrtivas:** Los administradores tendrán acceso a funciones para agregar o eliminar libros, generos y autores así como eliminar, bloquear o editar los datos de un usuario. Además podrán eliminar los comentarios en el foro y los comentarios sobre un libro siempre que lo crea oportuno.



## Objetivos Generales
***
El objetivo principal del proyecto es crear una plataforma en línea que permita a los usuarios encontrar y comprar libros de una forma sencilla y practica, así como epresar sus opiniones sobre los mismo.


## Tecnologías Utilizadas
***
Para desarrollar este proyecto se utilizaron las siguientes tecnologías:

-   HTML.
-   CSS (Incluyendo el uso de Bootstrap)
-   JavaScript (Incluyendo el uso de Alpine.js)
-   Laravel 10
-   postgreSQL



## Elemento de Innovación
***
- **Suscripcion:** Los  usuarios tendran la posibilidad de subscribirse para tener acceso a descuentos explusivos.

## Despliege de la Aplicación
***
### 1. Instalación de PHP
```
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt install php8.2 -y
sudo  apt-get install -y php8.2-cli  php8.2-common php8.2-fpm php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath php8.2-pgsql
sudo update-alternatives --config php

```
### 2. Instalación de Composer
```
apt install git curl php-cli unzip
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
HASH=`curl -sS https://composer.github.io/installer.sig`
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
```

### 3. Instalación de PosygreSQL
```
sudo apt-get update
sudo apt install postgresql
sudo service postgresql start
```

### 4. Instalacion de la aplicacion Booktopia
```
 git clone https://github.com/AJMG-95/booktopia.git
 cd booktopia
 npm install
 npm i bootstrap@5.3.2
 npm i bootstrap-icons
 npm install font-awesome
 npm install alpinejs
 composer require twbs/bootstrap-icons
 composer require stripe/stripe-php
```  
### 6. Configuración del archivo .env
```
sudo nano .env
```
Copiar a la configuración que se encuentra en el archvio .env.example al nuevo archivo .env que se ha creado.

### 7. Configuracion de la base de datos
**La contraseña siempre será booktopia**
```
sudo -u postgre psql
\c templaye1
CREATE EXTENSION pgcrypto;
\q
sudo -u postgres createdb booktopia
sudo -u postgres createuser -P booktopia
```
### 8. Últimos pasos
```
chmod -R 777 storage/*
php artisan cache:clear
```

**Crear migracones**
```
php artisan migrate
```
Ojo puede que las migrciones no se creen en el orden correcto lo que podría dar errores ya que una migración intetaría hacer referencia a otra que aún no se ha generado. 
Para solicionar esto solo se necesita extraer (ctrl+x, ctrl+v) los archivos conflictivos desde la carpeta migrations a un directorio externo a la app y luego volver a introducir esos archivos en el directorio migrations de la app.

**Ejecutar seeders**
```
php artisan db:seed --class=LanguagesTableSeeder &&
php artisan db:seed --class=RolesTableSeeder &&
php artisan db:seed --class=CountriesTableSeeder &&
php artisan db:seed --class=UsersTableSeeder
```


**Crear enlace simbolico para el almacenamiento**
```
php artisan storage:link
```

#[![Booktopia-1-removebg-preview.png](https://i.postimg.cc/7h9f6Gtx/Booktopia-1-removebg-preview.png)](https://postimg.cc/vx1Q2Bdj)
