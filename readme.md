
## DMS - Data Management System

This is a data management system built on Laravel. It should serve as a simple solution to WordPress based systems. Through this DMS' dashboard, an admin should be able to post relevant data about their company/business.  A user will only be able to edit their profile, for now. 


## Admin Features:
 - The Admin will be able to create Categories, Subcategories & Products. Posted data can be seen on the landing page and respective 'show' pages. (A show page is the page that opens when you select an item)

 * Categories (Main/Parent)
    - Each Category has a Name, Slug, Description, and SEO details.
    - It is the main category.
    - Create/post Categories
    - Edit Categories
    - List all categories

 * Subcategories (child of Categories)
    - Each Subcategory has: Name, Slug, Description and SEO details.
    - It serves as the child of Categories, and parent of Products.
    - Post/Create Subcategories (and indicate the Parent Category).
    - Edit Subcategories
    - List all subcategories

 * Products
    - Each product has: Name, Slug, Short Description, Description, Cover Image, Gallery, and SEO details. 
    - Create/Post products
    - Edit Products
    - View products


## Stack:
   - Laravel
   - mySQL


## Installation:

- Clone this repo using ```git pull https://github.com/JessyLedama/DataManagementSystem ``` or download the zip file.

- Rename ```.env.example ``` to  ``.env `` and adapt it to match your database, username and password. (By default the username is usually `root`, ad the password blank if you're using XAMPP server.)

- Update Composer: ``` composer update ```

- Run migrations: ``` php artisan migrate ```

- Run server: `` php artisan serve ``

- Open (in your browser) `` localhost:8000 ``

BOOM!