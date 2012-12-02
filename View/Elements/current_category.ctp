<?php
if (empty($currentCategory)) {
	return;
}

$content = array(
	$this->Html->tag('h1', $currentCategory['ShopCategory']['name']),
	$currentCategory['ShopCategory']['description']
);
if (!empty($parentCategory)) {
	$content[] = $this->Html->link($parentCategory['ShopCategory']['name'], array(
		'plugin' => 'shop',
		'controller' => 'shop_products',
		'action' => 'index',
		'category' => $parentCategory['ShopCategory']['slug']
	), array('class' => 'btn btn-primary btn-medium'));
}

echo $this->Html->tag('div', implode('', $content), array('class' => 'hero-unit'));