# Installation

---

- [Step One: XAMPP](#section-1)
- [Step Two: Composer](#section-2)
- [Step Three: NPM](#section-3)

<a name="section-1"></a>
## Step One: XAMPP 
Install XAMPP onto your system, 
- (Download Link) : https://www.apachefriends.org/download.html
- (Alternate Download Link) : https://www.apachefriends.org/index.html
    - These links have installers for Windows, MacOS and Linux

<a name="section-2"></a>
##Step Two: Composer
Install Composer onto your system
Composer is a package manager for PHP 
- (Download link + Tutorial) : https://getcomposer.org/download/
    - Links has information on how to install for Windows, MacOS and Linux -

- Once downloaded run command  `composer -V` to ensure it is installed correctly

<a name="section-3"></a>
##Step Three: NPM 
- Ensure that NPM is installed on the system

##Step Four: Install Dependencies 
- Run command `php artisan install` to install Laravel dependencies
- Run command  `npm install && npm run dev` to install JS dependencies

##Step Five: Create and Connect Database
### Create Database
A database can be created using two methods 
#### Method 1 
> Ensure you have the MySQL path in your variables
- Open a command line interface and enter command  `mysql -u root`
- Once logged in use `create database app;` to create the database

#### Method 2 
- Start `XAMPP`
- Start `MySQL` and `Apache` servers
- Open `phpMyAdmin` through XAMPP
- Create a new database called `app`

### Connect to Database
- Open the `.env` file 
    - If there is no `.env` file then rename the '.env.example' to '.env' and use  that
- Find the `DB_DATABASE=` line. 
- Change this to `DB_DATABASE=app`
- Run the command `php artisan serve` command. It should automatically connect to the database

## Step 6: Migrate and Seed Database
### Migrate 
- Use the command `php artisan migrate` to migrate the database

- Find the file `SeatReservationSystem/database/AdminSeeder.php`
- This file will create the administrator account 
- Change the email from `PleaseChangeThis@gmail.com` to the email address of the chosen administrator 
- Please change the password from `PleaseChange` to what you would like. 

> {danger} If in production change this password once database is seeded 


- Run the command  `php artisan db:seed` 

