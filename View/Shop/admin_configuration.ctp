<?php
$links = array(
	'products' => array(
		array(
			'name' => __d('shop', 'Types'),
			'description' => __d('shop', 'Manage product types'),
			'icon' => '/shop/img/icons/product_types.png',
			'dashboard' => array('controller' => 'shop_product_types', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Options'),
			'description' => __d('shop', 'Manage product options'),
			'icon' => '/shop/img/icons/options.png',
			'dashboard' => array('controller' => 'shop_options', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Attributes'),
			'description' => __d('shop', 'Manage store attributes'),
			'icon' => '/shop/img/icons/attributes.png',
			'dashboard' => array('controller' => 'shop_attributes', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Currencies'),
			'description' => __d('shop', 'Manage store currencies'),
			'icon' => '/shop/img/icons/currency.png',
			'dashboard' => array('controller' => 'shop_currencies', 'action' => 'index')
		),
	),
	'assets' => array(
		array(
			'name' => __d('shop', 'Images'),
			'description' => __d('shop', 'Manage store images'),
			'icon' => '/shop/img/icons/images.png',
			'dashboard' => array('controller' => 'shop_images', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Downloads'),
			'description' => __d('shop', 'Manage store downloads'),
			'icon' => '/shop/img/icons/downloads.png',
			'dashboard' => array('controller' => 'shop_downloads', 'action' => 'index')
		),
	),
	'configuration' => array(
		array(
			'name' => __d('shop', 'Branches'),
			'description' => __d('shop', 'Manage store branches'),
			'icon' => '/shop/img/icons/branches.png',
			'dashboard' => array('controller' => 'shop_branches', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Suppliers'),
			'description' => __d('shop', 'Manage store suppliers'),
			'icon' => '/shop/img/icons/suppliers.png',
			'dashboard' => array('controller' => 'shop_suppliers', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Brands'),
			'description' => __d('shop', 'Manage product brands'),
			'icon' => '/shop/img/icons/manufacturers.png',
			'dashboard' => array('controller' => 'shop_brands', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Payments'),
			'description' => __d('shop', 'Manage store payments'),
			'icon' => '/shop/img/icons/payment.png',
			'dashboard' => array('controller' => 'shop_payment_methods', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Shipping'),
			'description' => __d('shop', 'Manage store shipping'),
			'icon' => '/shop/img/icons/shipping.png',
			'dashboard' => array('controller' => 'shop_shipping_methods', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Status'),
			'description' => __d('shop', 'Manage order statuses'),
			'icon' => '/shop/img/icons/order_status.png',
			'dashboard' => array('controller' => 'shop_order_statuses', 'action' => 'index')
		)
	)
);

foreach($links as $name => &$link) {
	$link = $this->Design->arrayToList(current((array)$this->Menu->builDashboardLinks($link, 'shop_dashboard_' . $name)), array(
		'ul' => 'icons'
	));
}

echo $this->Design->dashboard($links['products'], __d('shop', 'Configuration'), array(
	'class' => 'dashboard span6',
));

echo $this->Design->dashboard($links['assets'], __d('shop', 'Assets'), array(
	'class' => 'dashboard span6',
));

echo $this->Design->dashboard($links['configuration'], __d('shop', 'Content'), array(
	'class' => 'dashboard span6',
));
echo $this->ModuleLoader->loadDirect('Contents.dashboard_links');