<?php
if(empty($shopNewProducts)) {
	return;
}

foreach($shopNewProducts as &$product) {
	$product = $this->element('Shop.product_item', array(
		'shopProduct' => $product
	));
}
array_unshift($shopNewProducts, $this->Html->tag('h4', __d('shop', 'Latest Products')));
echo $this->Html->tag('div', implode('', $shopNewProducts), array('class' => 'well'));