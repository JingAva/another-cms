# another-cms
This application is developed by using Laravel 6 and Vuejs (including Vuetify). 
## Development Process
### Download and install Laravel project with Vue
Front end scaffolding has been moved to Laravel UI
#### 1. `composer global require laravel/installer`
#### 2. `laravel new project-name`  (or `composer create-project --prefer-dist laravel/laravel project-name`)
#### 3. `composer require laravel/ui`
#### 4. `php artisan ui bootstrap` (or `php artisan ui vue`)
#### 5. `npm install & npm run dev`

### Use vue auth for user registration
#### 1. `php artisan ui vue --auth`
#### 2. `php artisan ui:auth`
#### 3. `php artisan migrate` (to create user table you need to have db configed and also create the database)
