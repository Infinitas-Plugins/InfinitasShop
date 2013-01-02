<?php
$link = $this->Html->link($shopProduct['ShopProduct']['name'], array(
	'plugin' => 'shop',
	'controller' => 'shop_products',
	'action' => 'view',
	'category' => $shopProduct['ShopCategory'][0]['slug'],
	'slug' => $shopProduct['ShopProduct']['slug']
)) . $this->Shop->price(array('selling' => $shopProduct['ShopProductVariantMaster']['ShopProductVariantPrice']['selling']));

echo $this->Html->tag('div', implode('', array(
	$this->Html->tag('h5', $link),
	$this->Html->tag('div', $this->Html->image($shopProduct['ShopImage']['image_medium']), array(

	))
)), array('class' => 'product-item'));