# Create modules

## Modules in Meringue architecture

Meringe architecture can be schematised like this :

![Meringue architecture diagramm](img/meringue_architecture.png)

On top of everything, there's the kernel, then the modules. To link the modules to the kernel, we use traits, which calls the module class.

## Creating an example module

For our example, I will code a module that will allow us to send HTTP GET requests using cURL.

### Creating the class

The following code should be placed in `meringue/network/Query.php` :

```php
namespace meringue\network;

class Query {
    public static function doGET($url) {
        $curlHandler = curl_init();
        curl_setopt($curlHandler,CURLOPT_URL,'http://example.com');
        curl_setopt($curlHandler,CURLOPT_RETURNTRANSFER,1);

        $result = curl_exec($curlHandler);

        if (curl_errno($curlHandler)) {
            throw new Exception('Error while doing the cURL request.');
        } else {
            return $result;
        }
    }
}
```

Please notice that our `doGET` method is static.

### Binding to the kernel using a trait

The following code should be placed in `meringue/core/QueryModule.php` :

```php
namespace meringue\core;

trait QueryModule {
    public static function doGET($url) {
        return \meringue\network\Query::doGET($url);
    }
}
```

Now, if I import my module into Meringue, `Meringue:doGET()` will be linked to `\meringue\network\Query::doGET()`.

## Loading your module in Meringue

To import your module, add at the begining of the Meringue class (`meringue/Meringue.php`) :

```php
class Meringue {
	use \myNamespace\myModuleTrait;
```