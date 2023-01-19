
## Setting Up Locally

 - composer update
 - php artisan migrate --seed
 - php artisan serve

### Connect Image Storage links to public directory.
 - php artisan storage:link

### Creating boilerplate for a controller entity (This command will create a model, resource, controller and migration in one shot.)
 - php artisan make:model ControllerName -rcm
    - r = resource
    - c = controller
    - m = migration