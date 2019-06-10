# ToDo List App

The following functionality is implemented:

- Register User
- Delete User Account
- Todo Lists
  - Have more than 1 Todo List by user
  - Create
  - Delete
- Tasks
  - Create
  - Delete
  - Edit
  - Set as "Done"
  - Change order

## Setup

The app requires a DB to be functional, edit the file `.env` to setup the DB connection settings
The app has DB migration scripts, once the DB has been created and the connection has been configured you can create the DB structure using laravel's migrate functionality (`php artisan migrate`).

The app can be tested locally using laravel server: `php artisan serve`

## Frameworks/libraries used

The app was developed using PHP 7 and Laravel 5.3; it makes extensive use of javascript to manipulate the DOM and load and save data using ajax calls.

- Bootstrap
- jQuery
- Using "Material Kit" Bootstrap 4 template for the UI (https://www.creative-tim.com/product/material-kit)
- 

## Known issues

- Responsive site is not fully developed
- Some visual glitches (like not positioning focus on elements when created)
- No special keyboard keys listening for events (like using `ESC` and `ENTER` keys when editing)
- Not sure all possible scenarios have been tested
- Some exception handling is missing
- No UT has been implemented
- When saving a new list, the page gets reloaded
- No initial data setup has been done
- No password recovery has been implemented