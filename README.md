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


- ## Get Started
    - [Overview](/{{route}}/{{version}}/overview)
    - [Installation](/{{route}}/{{version}}/Installation)
    - [Create Account](/{{route}}/{{version}}/add_account)
    - [Add a local admin](/{{route}}/{{version}}/add_localAdmin)
    - [Create Institution](/{{route}}/{{version}}/add_institution)
    - [Create a room](/{{route}}/{{version}}/add_room)
    - [Booking a seat](/{{route}}/{{version}}/add_booking)
    - [Track and Trace](/{{route}}/{{version}}/trackAndTrace)





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





# Create a Room

---

- [Prerequisite](#section-1)
- [Creating a Room](#section-2)
- [Selecting a Room to Edit](#section-3)
- [Step by Step Guide](#section-4)

<a name="section-1"></a>
## Prerequisite
- Ensure you are within the `Local Admins` team.
- This can be found by selecting the dropdown in the top right, the users teams will be displayed in the `Switch Teams` section.
- Ensure that you have the correct institution selected.
![image](../../img/image2.png)

<a name="section-2"></a>
## Creating a room
- Select the `Extra` drop down
- Within this select the `Create Room` option 
  

- Input the `Room Name`, `Opening Time` and the `Closing Time`
- Upload the rooms floor plan
> {danger} Ensure that the floor plan is correctly scaled or the social distancing safety feature will not work


<a name="section-3"></a>
##Select Room to Edit
![image](../../img/image3.png)
- Within the `Extra` dropdown select the `Edit Room` option.
- Select room that needs editing.


<a name="section-4"></a>
##Step by Step guide

###How to use the canvas
- 'ALT' + 'Left Click': Move view of canvas
- 'Mouse wheel': Changes level of zoom
- 'Alter Slider': Changes size of shapes
- 'Reset View': Resets the view of the canvas 
- 'Colour Options' : Various Colour Pallets to allow a user to change the seat colours

### Step 1
- The reference length is used to ensure that seats are socially distanced. 
- Find the length of a real world wall/room/area
- Align the reference on the canvas with the length by moving it around the canvas
    - The `Scale Reference` can be used to change the length of the line
    - The `Angle Reference` can be used to rotate the line 
- Then input the real world length (in metres) within the `Real-Life Length (metres)` input field
- Select `Set Reference` button.

### Step 2
- `Seating Area`, where the seats will be. 
- Each area is an enclosed space so will only check the social distancing for the seats within the area.
- `Exclusion Area`, where seats aren't allowed to be. 
- `Set Seat Area`, once the seating areas are where you want them be they need to be 'set' so that its easier to add the seats.
- `Unset seat area`, if there's a problem with the seating areas you can unset them and change them. 
- `Delete Area`, can delete a seating area or exclusion area if its not needed.

### Step 3
- Add the number of the seats required using the `Add More Seats` .
- Can resize the seats with the `Size of Seats` slider.
- `Delete seat`, can delete un-needed seats.

### Step 4
- Enter the distance that you would like the seats to be apart (minimum)
- When attempting to save the system will alert you to any errors, this includes:
    - Seats overlapping
    - Seat not in a seating area
    - Seating area overlap with an Exclusion area
    - Where seats are too close together
    
- If the reference length is not set a warning will appear informing the user of this. 



# Track & Trace

---
- [Input Data](#section-1)
- [View Results](#section-2)


<a name="section-1"></a>
## Input Data 

- Input the date
- Select the Institution
- Select the Room
- Input the start time of the booking
- Click `Submit`
![image](../../img/image7.jpg)

<a name="section-2"></a>

##View Results 
- The system will give you a list of emails to contact
- The system should also open your local email client and create a generic email informing the users of the incident
  ![image](../../img/image8.png)




