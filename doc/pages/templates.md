# Templates

Meringue's template system uses views coded in PHP, and injects your data into it.

To display a view, call the `render` method :

```php
Meringue::render('myView.php',[
	'myFirstVariable' => 'John Doe'
]);
```

Here's the view we've just called :

```php
<!doctype html>
<html>
	<head>
		<title>Meringue demo</title>
	</head>
	<body>
		<p>My name is : <?= $myFirstVariable ?></p>
	</body>
</html>
```

The output should be :

	My name is : John Doe

You can set up a folder containing all your views, and registering it into Meringue :

```php
Meringue::set('meringue.render.path','/views');
```

Thus, you can call your views this way :

```php
Meringue::render('myTestView',[]);
```

You can replace the render engine by editing the render callback :

```php
Meringue::set('callback.render',['myRenderClass','myRenderMethod']);
```