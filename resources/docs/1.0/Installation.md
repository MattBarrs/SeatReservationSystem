# Installation

---

- [Step 1: XAMPP](#section-1)
- [Step 2: Composer](#section-2)
- [Step 3: NPM](#section-3)
- [Step 4: Clone Git Repo](#section-4)
- [Step 5: Install Dependencies](#section-5)
- [Step 6: Create and Connect Database](#section-6)
- [Step 7: Migrate and Seed Database](#section-7)
- [Step 8: Run](#section-8)

<a name="section-1"></a>
## Step 1: XAMPP 
Install XAMPP onto your system, 
- (Download Link) : https://www.apachefriends.org/download.html
- (Alternate Download Link) : https://www.apachefriends.org/index.html
    - These links have installers for Windows, MacOS and Linux

<a name="section-2"></a>
##Step 2: Composer
Install Composer onto your system
Composer is a package manager for PHP 
- (Download link + Tutorial) : https://getcomposer.org/download/
    - Links has information on how to install for Windows, MacOS and Linux -

- Once downloaded run command  `composer -V` to ensure it is installed correctly

<a name="section-3"></a>
##Step 3: NPM 
- Ensure that NPM is installed on the system

<a name="section-4"></a>
##Step 4: Clone Git Repo
- Open a command line interface 
- Navigate to the directory you would like the application to be 
- Use the command `git clone https://github.com/compSci-sc17mtab/SeatReservationSystem.git`
    - Git URL: https://github.com/compSci-sc17mtab/SeatReservationSystem.git

<a name="section-5"></a>
##Step 5: Install Dependencies 
- Run command `php artisan install` to install Laravel dependencies
- Run command  `npm install && npm run dev` to install JS dependencies

<a name="section-6"></a>
##Step 6: Create and Connect Database
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

<a name="section-7"></a>
## Step 7: Migrate and Seed Database
> {danger}  If you have just run `php artisan serve` ensure that this is stopped before proceeding!

### Migrate 
- Use the command `php artisan migrate` to migrate the database

- Find the file `SeatReservationSystem/database/AdminSeeder.php`
- This file will create the administrator account 
- Change the email from `PleaseChangeThis@gmail.com` to the email address of the chosen administrator 
- Please change the password from `PleaseChange` to what you would like. 

> {danger} If in production change this password once database is seeded 


- The database can populate the database with example data to help with testing, if you would like this, tun the command  `php artisan db:seed`
- If you do not want these examples use the command `php artisan db:seed --class=AdminSeed` to only seed the admin account.  

- The example data creates:
    - Example Institute called `Example Institute`
    - Example Room called `Example Room`
    - Multiple bookings on `25/07/2021` at `7:00` 


<a name="section-8"></a>
## Step 8: Run 
- Ensure that XAMPP is runnning
- Start the `MySQL` & `Apache` servers
- Within the command line run the command `php artisan serve`
