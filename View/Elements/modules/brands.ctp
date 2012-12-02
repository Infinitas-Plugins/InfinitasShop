<?php
if (empty($shopBrandsList)) {
	return;
}

$class = function($image) {
	list($width, $height) = getimagesize(APP . 'webroot' . $image);
	if ($height * 2 < $width) {
		return 'span2';
	}
	return 'span1';
};

foreach ($shopBrandsList as &$shopBrand) {
	$url = array(
		'plugin' => 'shop',
		'controller' => 'shop_brands',
		'action' => 'view',
		'slug' => $shopBrand['ShopBrand']['slug']
	);

	$shopBrand = $this->Html->tag('li', $this->Html->tag(
		'div',
		$this->Html->link($this->Html->image($shopBrand['ShopBrand']['image_medium'], array(
			'title' => $shopBrand['ShopBrand']['name']
		)), $url, array('escape' => false)),
		array('class' => 'thumbnail')
	), array('class' => array($class($shopBrand['ShopBrand']['image_medium']), 'brand')));
}
echo $this->Html->tag('ul', implode('', $shopBrandsList), array('class' => 'thumbnails'));
