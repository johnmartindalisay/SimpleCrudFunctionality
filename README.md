# Simple Crud Functionality
  
### This Application has (3) Module :

	1. Registration
	2. login
	3. Customer Overview 


* Run in your localhost/(this project name).

### Database 

Run 
	 
	php artisan migrate  

This will automatically create table in your database once you already connect this application in your database.


 Drop or rollback table in database run 

    php artisan migrate:rollback

  *Note: if there is something wrong in rollback, use composer to fix 
 		run : composer require doctrine/dbal - this will install package and then rollback again this will work.