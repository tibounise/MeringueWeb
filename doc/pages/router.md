# Router

Routing URLs can be usefull when building REST applications, and can also improve your SEO.

*This router is compatible with Flight PHP routes.*

## Routing your first URL

You have to define the URL pattern we want to match, and a callback :

```php
Meringue::route('/myTestURL',function() {
	// Code executed when /myTestURL is reached
});
```

You can also directly call existing functions :

```php
Meringue::route('/myTestUrl','myFunctionName');
```

and classes :

```php
Meringue::route('/myTestUrl',array('myClassName','myClassMethod'));
```

## Making your patterns more accurate

### Method routing

You can specify which HTTP method you want to match :

```php
Meringue::route('POST /myTestUrl','myFunctionName');
```

You can also map multiple HTTP methods, using the **pipe** separator :

```php
Meringue::route('POST|GET|DELETE /myTestUrl','myFunctionName');
```

### Regular expressions

You can use regular expressions in your routes :

```php
Meringue::route('/myTestUrl/[a-zA-Z]+','myFunctionName');
// This will map /myTestUrl/helloWORLD but not /myTestUrl/1234
```

### Collecting parameters from the URL

You can name the parameters, and have them sent back to the callback :

```php
Meringue::route('/myTestUrl/@parameter',function($parameter) {
	echo "Got : $parameter";
});
```

You can even specify regex for these parameters :

```php
Meringue::route('/myTestUrl/@parameter:[0-9]+',function($parameter) {
	// This will match /myTestUrl/1234 but not /myTestUrl/abcd
});
```

### Optional parameters

You can set some parameters as optional using **brackets** :

```php
Meringue::route('/myTestUrl(/@parameter:[0-9]+)',function($parameter) {
	// Will match /myTestUrl and /myTestUrl/1234
});
```

## Separate your routes from your code

You can load routes from a JSON file :

```php
Meringue::routeFromJson('myJSONfile.json');
```

To do so, create a JSON file looking like this :

```json
[{
	"schema":"/myFirstRoute",
	"callback":"firstTestCallback"
},{
	"schema":"/mySecondRoute",
	"callback":"secondTestCallback"
}]
```

Finally, if you have a folder filled with those kind of json files, there is a function to include all of them :

```php
Meringue::routeFromFolder('myRouteFolder/');
```