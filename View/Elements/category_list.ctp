<?php
if (empty($shopCategories)) {
	return;
}

foreach ($shopCategories as &$shopCategory) {
	$url = array(
		'plugin' => 'shop',
		'controller' => 'shop_products',
		'action' => 'index',
		'category' => $shopCategory['ShopCategory']['slug']
	);

	$shopCategory = $this->Html->tag('div', implode('', array(
		$this->Html->link($this->Html->image($shopCategory['ShopImage']['image_medium']), $url, array('escape' => false)),
		$this->Html->tag('h4', $this->Html->link($shopCategory['ShopCategory']['name'], $url)),
	)), array('class' => 'thumbnail'));
}
echo $this->Design->arrayToList($shopCategories, array('ul' => 'thumbnails', 'li' => 'span2 category'));