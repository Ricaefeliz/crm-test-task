crm test task
=================

Run app
------------
1) Fill database connection in file `app/config/config.prod.neon`

In the console run commands (from the root folder):
1) `composer install --no-dev`
2) `php www/index.php orm:schema-tool:create`
3) `php www/index.php card:generate` - generate cards

Go to a browser and fill an url address:
- /registration - registration form
- /customer/search - searching in customers
- /customer/report - basic report

Steps to create the test task
------------
1) think about business logic
1) think about a database model
2) implement it
3) create the form
4) create presenters
5) test the app