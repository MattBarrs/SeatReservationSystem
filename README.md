<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/)**
- **[OP.GG](https://op.gg)**

## Contributing


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


# Create an Account

---


- [Register](#section-1)
- [Local Admins](#section-2)

<a name="section-1"></a>
## Register
- Click the ‘Register’ Button,
- Enter your details
- Press the ‘Register’ button once the details are entered.
- Ensure that the dashboard is displayed

![image](../../img/image1.png)

<a name="section-2"></a>
##Local Admins
- If they need to be made a  Local administrator pleases see "[Add a local admin](/{{route}}/{{version}}/add_localAdmin)" 



# Create a Booking

---
- [Prerequisite](#section-1)
- [Select the Room](#section-2)
- [Input Date/Time](#section-3)
- [Select Seat](#section-4)
  
<a name="section-1"></a>
## Prerequisite
- Ensure that you have the correct institution selected.
  ![image](../../img/image2.png)

<a name="section-2"></a>
## Select the Room
- Select the `Book a Seat` link in the top navigation bar
- If you do not have a room selected it will show a list of rooms below
  ![image](../../img/image5.jpg)

<a name="section-3"></a>
## Input Date/Time
![image](../../img/image4.png)

<a name="section-4"></a>
##Select Seat 
- The rooms floorplan will then be displayed
- The default colour are 
    - `Red` : `Not Available` 
    - `Green` : `Available`
- Colour scheme can be changed through `Colour Options`
- Select the seat to book
- A `Book Seat` should appear, select it 
- System will notify the user about the status: Successful/Error 
![image](../../img/image6.png)



# Create an Institution

---
- [Prerequisites](#section-1)
- [Creat an Institution](#section-2)


<a name="section-1"></a>
## Prerequisistes
- Ensure that user has been added to the  'Local Admins` team.
    - Within the top right dropdown select `Team Settings`
    - The users teams are listed within the `Switch Teams` section of the dropdown
    - See "[Add a local admin](/{{route}}/{{version}}/add_localAdmin)" for more details   

<a name="section-2"></a>
## Create an Institution
- Within `Extra` select the `Add Institution` option
- Input the name and the passcode
    - Passcode is used to access an institution to make a booking
![image](../../img/image9.jpg)


#Add Local Admin

---

- [Prerequisites](#section-1)
- [Adding Permissions](#section-2)

<a name="section-1"></a>
## Prerequisistes
- Ensure you are logged in as the main Administration account
- Within the top right dropdown select `Team Settings`

  
<a name="section-2"></a>
##Adding Permissions
- Ensure that the currently selected team under `Team Name` is `Local Admins`
- Under the `Add Team Member` section enter the local admins email address
- There are three options for their role, select the `Local Admin` role
> {danger} Ensure that you do not select `Administrator` or `Editor` this will give them the incorrect permission
> 
- Select the `Add` button to add them to the `Local Admins` team.


##Removing Permissions 
- Ensure that the currently selected team under `Team Name` is `Local Admins`
- Under the `Team Members` section find the user that needs their permissions removed
- Select `Remove` on the far right to remove, select `Remove` on the pop-up to confirm 






