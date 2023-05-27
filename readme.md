## Laracart The Laravel Online Store
Laravel online store using laravel 5.6, Materialize-css 1.0.0rc-2, JQuery, Material icons, google fonts and etc. This application is using braintree for processing payments.

### Let's get this application running
- Make sure you have [xampp](https://www.apachefriends.org/index.html) installed which is a package for PHP, MySQL, and Apache. it's available for all platforms such as windows, mac, and linux.

- Clone this repo to your machine or just [download](https://github.com/SagarMaheshwary/laracart/archive/master.zip) the zip.

- Install [Composer](https://getcomposer.org) first, then run this command in your command-line (you should be inside your project directory).
```bash
    composer install
```

- Rename .env.example to .env and add you database, mail, and braintree credentials.

- Below command will run all the necessary commands to get this application up & running. You can explore the command in App/Console/Commands/LaracartInstall.php
```bash
    php artisan laracart:install
```

- you can create a virtual host or just run this command to run dev server
```bash
    php artisan serve
```

- if you don't know how to get the braintree api keys then watch this [video](https://www.youtube.com/watch?v=6NjTrtZ0Uhc&list=PLfdtiltiRHWH9JN1NBpJRFUhN96KBfPmd&index=3) from codecourse youtube channel.

- you can change the tax from config/cart.php file.

#### Admin Credentials
- Email :- admin@admin.com
- Password :- password
- admin can login with /admin/login route.

### Packages that are used by this application
- [LaravelShoppingCart](https://github.com/Crinsane/LaravelShoppingcart) which is a laravel package that gives you all the cart features.

- [Ckeditor](https://github.com/UniSharp/laravel-ckeditor) for text editor.

- [Laravel-report-generator](https://github.com/Jimmy-JS/laravel-report-generator) for generating reports in PDF, Excel, and CSV formats.

- [Laravel-email-confirm](https://github.com/beyondcode/laravel-confirm-email) for customer email confirmation.

### ScreenShot

![screen shot](https://github.com/SagarMaheshwary/laracart/blob/master/screenshots/laracart.png)

Thankyou.