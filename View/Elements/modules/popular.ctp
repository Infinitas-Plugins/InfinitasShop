<?php
if(empty($shopPopularProducts)) {
	return;
}

foreach($shopPopularProducts as &$product) {
	$product = $this->element('Shop.product_item', array(
		'shopProduct' => $product
	));
}
array_unshift($shopPopularProducts, $this->Html->tag('h4', __d('shop', 'Popular Products')));
echo $this->Html->tag('div', implode('', $shopPopularProducts), array('class' => 'well'));