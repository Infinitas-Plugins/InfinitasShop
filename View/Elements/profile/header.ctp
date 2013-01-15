<?php
$links = array(
	array(
		'text' => __d('shop', 'Profile'),
		'url' => array(
			'plugin' => 'users',
			'controller' => 'users',
			'action' => 'view'
		)
	),
	array(
		'text' => __d('shop', 'Orders'),
		'url' => array(
			'plugin' => 'shop',
			'controller' => 'shop_orders',
			'action' => 'index'
		)
	),
	array(
		'text' => __d('shop', 'Lists'),
		'url' => array(
			'plugin' => 'shop',
			'controller' => 'shop_lists',
			'action' => 'index'
		)
	),
	array(
		'text' => __d('shop', 'Addresses'),
		'url' => array(
			'plugin' => 'shop',
			'controller' => 'shop_addresses',
			'action' => 'index'
		)
	),
	array(
		'text' => __d('shop', 'Downloads'),
		'url' => array(
			'plugin' => 'shop',
			'controller' => 'shop_downloads',
			'action' => 'index'
		)
	),
	array(
		'text' => __d('shop', 'Returns'),
		'url' => array(
			'plugin' => 'shop',
			'controller' => 'shop_returns',
			'action' => 'index'
		)
	),
	array(
		'text' => __d('shop', 'Newsletter'),
		'url' => array(
			'plugin' => 'newsletter',
			'controller' => 'newsletters',
			'action' => 'subscriptions'
		)
	),
	array(
		'text' => __d('shop', 'Contact Us'),
		'url' => array(
			'plugin' => 'newsletter',
			'controller' => 'newsletters',
			'action' => 'contact'
		)
	)
);

$Html = $this->Html;
array_walk($links, function(&$link) use ($Html) {
	$options = array(
		'class' => InfinitasRouter::url($link['url'], false) == $Html->request->here ? 'active' : null
	);
	$link = $Html->link($link['text'], $link['url'], $options);
});
echo $this->Design->arrayToList($links, array(
	'ul' => 'nav nav-tabs'
));
