<?php
if(empty($shopRecentlyViewed)) {
	return;
}

foreach($shopRecentlyViewed as &$product) {
	$product = $this->element('Shop.product_item', array(
		'shopProduct' => $product
	));
}
array_unshift($shopRecentlyViewed, $this->Html->tag('h4', __d('shop', 'Recently Viewed')));
echo $this->Html->tag('div', implode('', $shopRecentlyViewed), array('class' => 'well'));