## About News App

Run the following command to run the app

- configure the .env file. set database and API keys
- composer install
- php artisan migrate
- php artisan serve

## Structure

This app uses Factory, adapter design patters.
The News classes use Factory design patterns ,they are implemented to run in a service called NewsService

This app uses SOLID principle.
Many parts implement Interface Segregation Principle.
The FilterBuilder class is Single Responsibility and Open-Closed Principle.

2 Tests are created to check the models, ofcourse there should be a lot more tests but I did not have enough time as in a real project:

- php artisan test

## Frontend

frontend developer can use a postman collection saved in the file "/news.postman_collection".

These filters can be applied:

- author
- headline
- category
- source
- date

To search based on user preferences you can use:

- query
- page
- array of providers: [bbc,theguardian,nytimes]
- array of categories
- array of authors

