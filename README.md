# E-Commerce_API

Ecommerce API with Laravel including authentication using JWT.

## Getting Started

- Use JWT AUTH to handle login, register, logout, user profile and refresh tokens.
- Create Admin Middleware.
- Handle authorization user's token.
- Create Location Crud for user can change his order's location.
- Create Categories, Brands and products Crud.
- Create Order Crud and handle his relationships with user, location and order_items tables. 
- Handle store function for insert data in 3 table (orders, order_items and products to update amount of product after order and check if amount of products is enough or not).
- Finally use route groups and postman platform for test them.

### Tools

- Laravel 10.x.
- JWT.

### Installing

A step by step series of examples that tell you how to get a development
environment running

clone Repository in your local pc

    git clone https://github.com/Breksam/Ecommerce-API.git

run on your cmd or terminal

    composer install

copy .env.example file to .env on the root folder

    copy .env.example .env

then open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.

open terminal in the project then:
run

    php artisan key:generate
run

    php artisan migrate
run

    php artisan serve

## Running the tests

Now you can test Routes at postman Platform.

### Sample Tests

Reqister route

    http://127.0.0.1:8000/api/register

Login route: don't forget copy authorization token

    http://127.0.0.1:8000/api/login

Show all orders

    http://127.0.0.1:8000/api/order/index

etc...

## Authors

  - **Breksam Hassan Elsokkary** - (https://github.com/Breksam)


