# Configuration

## Setting up your HTTP server

If you're using Apache, insert this in your `.htaccess` :

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

If you're using Nginx, insert this in your server declaration :

```
server {
    location / {
        try_files $uri $uri/ /index.php;
    }
}
```

## Including Meringue in your code

To include Meringue in your code, require `meringue/Meringue.php` if possible at the beginning of your script.

Then, at the end of your script, start the Meringue router :

```php
Meringue::start();
```