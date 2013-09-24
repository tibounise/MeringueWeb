# Localization

Meringue's i18n module is based on its storage system. It helps you to build applications in multiple locales.

## Including i18n in your applications

For technical reasons, the i18n module isn't set in the global namespace. You can import the localization's namespace in each file where you'll be needing localization :

```php
use \meringue\locale;
```

There is another method to do this, although it is not recommended, which allows you to link the i18n class to the global namespace :

```php
class i18n extends \meringue\locale\i18n {}
```

## Feeding locales data

You can feed the i18n engine with an array :

```php
i18n::load([
	'myLocaleIdentifier':'localeValue'
]);
```

You can also load locales from a JSON file :

```php
i18n::loadJson('locales.json');
```

## Getting a localized string

You can access the localized string by referencing its identifier :

```php
i18n::get('myLocaleIdentifier');
```