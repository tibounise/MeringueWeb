<?php

class DocGenerator {
	private $sections;
	private $items = array();
	private $mustacheEngine;
	private $path;
	private $template;

	public function __construct($sections,$path = '',$template = 'main.html') {
		$this->sections = $sections;

		foreach ($sections as $section) {
			if ($section['type'] == 'section') {
				$this->items = array_merge($this->items,$section['items']);
			} elseif ($section['type'] == 'item' || $section['type'] == 'ghost') {
				$this->items[] = $section;
			}
		}

		$this->mustacheEngine = new Mustache_Engine();
		$this->template = file_get_contents('templates/'.$template);

		if ($path != '') {
			$this->path = $path.'/';
		}
	}

	private function buildNavbar($current = null) {
		$navbar = '';

		foreach ($this->sections as $section) {
			if ($section['type'] == 'section') {
				$navbar .= '<li class="uk-nav-header">'.$section['title'].'</li>';

				foreach ($section['items'] as $item) {
					if ($item['name'] == $current) {
						$navbar .= '<li class="uk-active"><a href="'.$item['name'].'.html">'.$item['title'].'</a></li>';
					} else {
						$navbar .= '<li><a href="'.$item['name'].'.html">'.$item['title'].'</a></li>';
					}
				}
			} else if ($section['type'] == 'item') {
				if ($section['name'] == $current) {
					$navbar .= '<li class="uk-active"><a href="'.$section['name'].'.html">'.$section['title'].'</a></li>';
				} else {
					$navbar .= '<li><a href="'.$section['name'].'.html">'.$section['title'].'</a></li>';
				}
			}
		}

		return $navbar;
	}

	private function renderPage($name) {
		return $this->mustacheEngine->render(
			$this->template,[
				'menu' => $this->buildNavbar($name),
				'content' => MarkdownExtended(file_get_contents("pages/$name.md"))
			]
		);
	}

	public function build() {
		foreach ($this->items as $item) {
			echo 'Exported "'.$item['name']."\"\n";

			file_put_contents(
				$this->path.$item['name'].'.html',
				$this->renderPage($item['name'])
			);
		}
	}
}

?>