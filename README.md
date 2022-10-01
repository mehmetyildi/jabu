## About Project
    This project is about a imaginary wood distributing company that need CRUD functionality for suppliers and products. 
    This project consits of 2 parts:
        -   Monolith (App with UI)
        -   API
## How to run
    - Pull the project pro repository
    - run 'composer install'
    - create ".env" file in the project root  copying ".env.testing". 
    - run 'php artisan key:generate'
    - create database and adjust .env files DB credentials accordingly
    - run 'php artisan serve'
    - to seed database 'php artisan db:seed'
    - For UI, 'http://localhost:8000/' is the main page. Here you travel through pages using side-nav on the left
    - For API, please check 'http://localhost:8000/api/docs' for swagger documentation.
    - To test the application, please run 'php artisan test'


CHEERS!
