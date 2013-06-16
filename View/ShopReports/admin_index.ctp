<?php

$links = array(
	'sales' => array(
		array(
			'name' => __d('shop', 'Sales'),
			'description' => __d('shop', 'View Sales reports'),
			'icon' => 'money',
			'dashboard' => array('action' => 'sales')
		),
	),
	'cart' => array(
		array(
			'name' => __d('shop', 'Cart data'),
			'description' => __d('shop', 'View shopping cart abandons and conversion data'),
			'icon' => 'shopping-cart',
			'dashboard' => array('action' => 'cart')
		),
	),
	'usage' => array(
		array(
			'name' => __d('shop', 'Customers'),
			'description' => __d('shop', 'View customer logs'),
			'icon' => 'user',
			'dashboard' => array('action' => 'usage')
		),
	)
);

foreach ($links as $name => &$link) {
	$link = $this->Design->arrayToList(current((array)$this->Menu->builDashboardLinks($link, 'shop_main_dashboard_' . $name)), array(
		'ul' => 'icons'
	));
}

echo $this->Design->dashboard($links['sales'], __d('shop', 'Sales and Income'), array(
	'class' => 'dashboard span6',
	'info' => __d('shop', 'View historic sales and income information for the store')
));

echo $this->Design->dashboard($links['cart'], __d('shop', 'Cart data'), array(
	'class' => 'dashboard span6',
	'info' => __d('shop', 'View historic cart data, including conversions and abandons')
));

echo $this->Design->dashboard($links['usage'], __d('shop', 'Store usage'), array(
	'class' => 'dashboard span6',
	'info' => __d('shop', 'View historic store usage (views, logins, registrations etc)')
));