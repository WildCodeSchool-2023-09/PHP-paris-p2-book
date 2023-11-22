## Description

This repository exposes all the code that our group wrote as part of a school project in which we used the MVC method. The goal was to develop a mobile application that allows users to add books, write reviews for these books, and perform searches.

## Steps

1. Clone the repo from Github.
2. Run `composer install`.
3. Create _config/db.php_ from _config/db.php.dist_ file and add your DB parameters. Don't delete the _.dist_ file, it must be kept.
The DB name is `mybookshelf`

```php

define('APP_DB_USER', 'your_db_user');
define('APP_DB_PASSWORD', 'your_db_password');
define('APP_DB_HOST', 'localhost');
define('APP_DB_NAME', 'mybookshelf');

```

4. Run `php migration.php` to import _database.sql_ in your SQL server.
5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.
6. Go to `localhost:8000` with your favorite browser. You are now on our Website : My Bookshelf !

## Your user journey

Since it is a website aimed at adding books, consulting them, and writing reviews, here is a user journey that will allow you to test all of this, but you are also free to conduct your own tests!

1. 
Firstly, you arrive on a homepage presenting the fundamental features that our site offers. You can navigate through the site using the navigation bar. Some features will be conditional on user login. You can use the following credentials to have full access to our site:
Username: guest
Password: guest

2. 
Now that you are logged in, you will arrive at a user homepage with the key information about your user profile.

3. 
Next, you can check the overall library by clicking on the first button in the navigation bar. Feel free to try a search. Also, if you want to make a search at any time, the middle button of the navbar if here for you !

4. 
If you see a book that interests you, you can click on it to get additional information about it.

5. 
Let's suppose you don't find the book you're trying to search for. This is entirely possible as our overall library grows with contributions from each user. In such a case, you can contribute to the improvement of this library by adding a book yourself!

6. 
If you have correctly filled out the form, you should have been directed to the page of the book you just added. Let's say you've read it, so go ahead and add a review!

7. 
Reviews are important for keeping track of your readings, making it easy to find various information about the book, and capturing your thoughts on it. Once again, if the form is filled out correctly, you have just added your first review! Congratulations!

8. 
Finally, you can click on the last button in the navigation bar, allowing you to access your profile. Many details will be available on this page later. For now, you can only consult all the reviews you've submitted.


NB.
The statistics button on the navigation bar leads to a 'coming soon' page as this feature is not yet developed.
