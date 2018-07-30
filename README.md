# voucherPool-Application
This is a pool to automatically generate voucher codes and assign to an email

# INSTALLATION STEPS

    1. Clone this repository
    2. cd into the application
    3. create a .env file in the root of the application if it does not exists or simply copy contents from the .env.example into the .enve         file.
    4. open .env file and add database configurations in it by filling the DB_DATABASE, DB_USERNAME AND DB_PASSWORD
    5. run "composer update" from the root directory.
    6. run "php artisan key:generate" from the root directory.
    7. run "php artisan migrate" to run migrations or simply upload the .sql database into your server
    8. run "php artisan db:seed". this will seed the users table and the offer table.
    9. run "php artisan serve --port 4040". This will start the server on port 4040
    
 # TO TEST THE APIS. PLEASE GO TO THE LINK BELOW TO SEE THE DOCUMENTATION
 https://documenter.getpostman.com/view/2640876/RWMLKmUk
 Please make sure the application is running on port 4040 or any other port. then the api url should be like localhost:4040/api
 If you are using the demo link found below, please replace the api url from 
 localhost:4040/api/   to    http://voucher.cointradeindex.com/api/
 
 # DEMO LINK
 http://voucher.cointradeindex.com/
 
 # THANK YOU VERY MUCH
 @FAMUREWA TAIWO


