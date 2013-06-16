<?php
echo implode('', array(
	$this->Html->tag('h3', __d('shop', 'Products Ordered')),
	$this->Html->tag('p', __d('shop', 'Number of products ordered per day')),
	$this->Html->tag('div', '', array(
		'class' => 'calendar',
		'data-url' => '/admin/shop/shop_orders/report_data/orders.json',
		'data-start' => date('Y') - 1,
		'data-stop' => date('Y'),
		'data-field' => 'product_count',
	)),
	$this->Html->tag('h3', __d('shop', 'Order Value')),
	$this->Html->tag('p', __d('shop', 'The total value of orders per day')),
	$this->Html->tag('div', '', array(
		'class' => 'calendar',
		'data-url' => '/admin/shop/shop_orders/report_data/orders.json',
		'data-start' => date('Y') - 1,
		'data-stop' => date('Y'),
		'data-field' => 'value',
	)),
	$this->Html->tag('h3', __d('shop', 'Registered vs Guest')),
	$this->Html->tag('p', __d('shop', 'Orders made by registered users vs guests')),
	$this->Html->tag('div', '', array(
		'class' => 'calendar',
		'data-url' => '/admin/shop/shop_orders/report_data/orders.json',
		'data-start' => date('Y') - 1,
		'data-stop' => date('Y'),
		'data-field' => 'user_type',
	))
));