## Tasks Mangment System - Laravel & VueJs

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

## Privileges
- Admin
- User

## Modules

- **Users**
- **Departments**
- **Tasks**
- **Requests**
- **Comments**

## Run Project in local

* First Download [composer](https://getcomposer.org/download/)
* Open cmd at project root directory
* Run <code>composer install</code> to download vendor files
* Set Settings of .env file with:
<pre>
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=tasks
    DB_USERNAME=root
    DB_PASSWORD=
</pre>
* Create database with name **tasks**
* Run <code>php artisan migrate</code> to create tables
* Run <code>php artisan db:seed</code> to fill tables with fake rows
* Run <code>php artisan key:generate</code>
* Run <code>php artisan serve</code>
* go to 127.0.0.1:8000 

## License

All rights reserved @2021
