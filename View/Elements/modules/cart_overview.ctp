<?php
$link = $this->Html->link(__dn('shop', '%d item - %s', '%d items - %s', 0, 0, 0), array(
	'plugin' => 'shop',
	'controller' => 'shop_list_products',
	'action' => 'index'
), array(
	'class' => 'cart-total',
	'data-title' => __d('shop', 'Cart contents') . $this->Form->button('&times;', array(
		'escape' => false,
		'class' => 'cart-total-close'
	))
));

echo $this->Html->tag('p', $link, array('class' => 'navbar-text pull-right'));