# Storage

Meringue features a storage system, which can be used to store your applications' configuration. It is also used to store Meringue's parameters.

It works as a key &harr; value system. You can set a key :

```php
Meringue::set('myKey','myValue');
```

and further in your application you can read your variable :

```php
Meringue::get('myKey');
```

Finally, you can also check if a specified key has already been set :

```php
Meringue::exists('myKey');
```