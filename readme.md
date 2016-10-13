
## Laravel Guest Book
*Version Beta 1 - 2016.10.13

This module allows the guest book is easy and convenient to make a new message in the guest book and view them. It is also possible to attach an image or text files.
The CAPTCHA module is enabled on the basis of the google, simple text editor (tineMCE), boot files (bootstrap fileinput) and the table (dataTables).

## System Requirements

The Laravel framework has a few system requirements.
However, if you are not using Homestead, you will need to make sure your server meets the following requirements:

PHP >= 5.6.4
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
Tokenizer PHP Extension
XML PHP Extension

## Installation

Please check the system requirements before installing project

1. You may install by cloning from github
  * Github: `git clone https://github.com/Lintume/guest_book`
2. Enter your database details into `app/config/database.php`.
3. Run the command
`composer install`
4. For creating tables in data base run the command
`php artisan migrate`
5. Finally, setup an [Apache VirtualHost](http://httpd.apache.org/docs/current/vhosts/examples.html) to point to the "public" folder.
  * For development, you can simply run `php artisan serve`



