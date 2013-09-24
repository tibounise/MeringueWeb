#!/usr/bin/php -q
<?php

function clean() {
	$files = scandir('.');

	foreach ($files as $file) {
		if (substr(strrchr($file, '.'), 1) == 'html') {
			unlink($file);
		}
	}
}

function build() {
	require_once 'vendor/mustache/Autoloader.php';
	require_once 'vendor/markdown_extended.php';
	require_once 'vendor/DocGenerator.php';

	Mustache_Autoloader::register();
	
	$dg = new DocGenerator(json_decode(file_get_contents('pageIndex.json'),true));
	$dg->build();
}

function usage() {
	echo "Usage : mkdoc.php build | clean\n";
}

function deploy($path) {
	if (!is_dir($path)) mkdir($path);

	require_once 'vendor/mustache/Autoloader.php';
	require_once 'vendor/markdown_extended.php';
	require_once 'vendor/DocGenerator.php';
	require_once __DIR__.'/vendor/minify/min/lib/JSMin.php';
	require_once __DIR__.'/vendor/minify/min/lib/CSSMin.php';

	Mustache_Autoloader::register();
	
	$dg = new DocGenerator(json_decode(file_get_contents('pageIndex.json'),true),$path,'prod.html');
	$dg->build();

	$jsFiles = scandir('js');
	$js = '';

	foreach ($jsFiles as $file) {
		if (substr(strrchr($file, '.'), 1) == 'js') {
			$js .= "\n".file_get_contents("js/$file");
		}
	}

	$js = JSMin::minify($js);

	file_put_contents("$path/meringue.js",$js);

	$cssFiles = scandir('css');
	$css = '';

	foreach ($cssFiles as $file) {
		if (substr(strrchr($file, '.'), 1) == 'css') {
			$css .= "\n".file_get_contents("css/$file");
		}
	}

	$cssmin = new CSSMin;
	$css = $cssmin->run($css);

	if (!is_dir("$path/css")) mkdir("$path/css");

	file_put_contents("$path/css/meringue.css",$css);

	if (!is_dir("$path/img")) mkdir("$path/img");

	$imgFolder = scandir(__DIR__.'/img');

	foreach ($imgFolder as $img) {
		if (is_file(__DIR__."/img/$img")) copy(__DIR__."/img/$img","$path/img/$img");
	}

	if (!is_dir("$path/fonts")) mkdir("$path/fonts");

	$fontsFolder = scandir(__DIR__.'/fonts');

	foreach ($fontsFolder as $font) {
		if (is_file(__DIR__."/fonts/$font")) copy(__DIR__."/fonts/$font","$path/fonts/$font");
	}

	if (!is_dir("$path/pdf")) mkdir("$path/pdf");

	$files = scandir($path);

	foreach ($files as $file) {
		if (substr(strrchr($file, '.'), 1) == 'html') {
			file_put_contents(
				"$path/$file",
				compress(file_get_contents("$path/$file"))
			);
			system("phantomjs mkpdf.js $path/$file $path/pdf/".substr($file,0,-5).".pdf");
		}
	}

}

function compress($content) {
	require_once __DIR__.'/vendor/minify/min/lib/Minify/HTML.php';
	require_once __DIR__.'/vendor/minify/min/lib/Minify/CSS.php';
	require_once __DIR__.'/vendor/minify/min/lib/JSMin.php';

	return Minify_HTML::minify($content, [
		'cssMinifier' => ['Minify_CSS','minify'],
		'jsMinifier' => ['JSMin','minify']
	]);
}

if ($_SERVER['argc'] == 2) {
	switch ($_SERVER['argv'][1]) {
		case 'clean':
			clean();
			break;

		case 'build':
			build();
			break;
		
		default:
			usage();
			break;
	}
} elseif ($_SERVER['argc'] == 3 &&
		  $_SERVER['argv'][1] == 'deploy') {
	deploy($_SERVER['argv'][2]);
} else {
	usage();
}

?>