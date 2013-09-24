# Cryptography

## Hashing passwords

```php
Meringue::hash('myPassword','mySalt');
```

## Generating passwords salts

```php
Meringue::generateSalt();
```

## Generating tokens

```php
Meringue::generateToken();
```

## Using other algorithms

You'll have to replace `callback.saltGenerator`, `callback.tokenGenerator` and `callback.hashGenerator` parameters with a suitable callback :

```php
Meringue::set('callback.tokenGenerator',['myCryptoClass','myTokenGenerationMethod']);
```

## Other included algorithms

Meringue offers multiple pre-made algorithms in `meringue\security\Crypto` class.

There is an **OpenSSL** salt generator called `OpenSSLSaltGenerator`.

There is also the `pbkdf2HashGenerator`, which uses a **pbkdf2** algorithm to hash passwords.

Please notice that **OpenSSL** might not be bundled with your PHP installation, and **pbkdf2** is only implemented on PHP 5.5 or newer.

## Good practices

If a hacker has access to all your passwords hashes, having differents salts on each users might slow him down if he wants to recover as many passwords as possible.