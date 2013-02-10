<?php
$details = __dn('shop', '%d item - %s', '%d items - %s',
	$shopListOverview['shop_list_product_count'],
	$shopListOverview['shop_list_product_count'],
	$this->Shop->price(array(
		'selling' => $shopListOverview['value']
	), false)
);
$button = htmlspecialchars($this->Form->button('&times;', array(
		'escape' => false,
		'class' => 'cart-total-close'
	)));
$link = $this->Html->link($details, array(
	'plugin' => 'shop',
	'controller' => 'shop_list_products',
	'action' => 'index'
), array(
	'class' => 'cart-total',
	'escape' => false,
	'data-title' => __d('shop', 'Cart contents') . $button
));

echo $this->Html->tag('p', $link, array('class' => 'navbar-text pull-right'));