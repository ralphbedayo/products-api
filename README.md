# iThinkWeb Backend developer coding test

## Task
You're tasked to create a simple REST web service application for an e-commerce app using Laravel.

You need to develop APIs for creating and viewing a single product. There should also be an API for viewing a list of the products.

A product needs to have the following information:

- Product name
- Product description
- Product price
- Created at
- Updated at

## Requirements
- The product name should have a maximum of 255 characters, and the product price should be numeric that accepts up to two decimal places.
- The created at and updated at fields should be in timestamp format.
- The view products list API needs to be paginated.
- You are required to use MySQL for the database storage in this test.
- You are free to use any library or component just as long as it can be installed using Composer.
- Don't forget to provide instructions on how to set the application up.

## Optional (for bonus points)
- Cache the view single product API. You are free to use any cache driver
- Create automated tests for the APIs
- Say for example, we need a feature where we can display featured products. How would you go about implementing this feature? (You don't need to write code for this, just describe how would you implement it)


## Installation
- Add the to your chosen apache/php web server (in my case, I used Laragon), add 'products-api.test' to hosts file and setup the MySQL/MariaDB modules as necessary.
    - Or, you can simply download the attached Laragon zip file on the email, extract the zip, and execute the laragon.exe from the extracted folder
    - Then, press the `Start All` button and let it set-up the project for you. 
- Since the vendor packages comes with the repository, you don't have to execute `composer install`

## Usage
- If you have a [Postman](https://www.postman.com/downloads/) app, you can use the `Products API (iThinkWeb Exam).postman_collection.json` collection file to automatically import all the API routes. Otherwise, these are the API routes:
    - GET http://products-api.test/products - To get the paginated list of all products.
    - GET http://products-api.test/products/{id} - To get the data of a single product by its ID.
    - POST http://products-api.test/products - To create a new product with (name, description, price) as its parameters
    - PUT http://products-api.test/products/{id} - To update a product with (name, description, price) as its parameters
    - DELETE http://products-api.test/products/{id} - To delete a product identified by its ID.
- You can also populate the database or `product` table by executing the command on terminal/CLI: `php artisan migrate:fresh --seed`
- On executing PHPUnit Feature or Unit test, you can execute on the CLI: `composer test:feature` or `composer test:unit`
