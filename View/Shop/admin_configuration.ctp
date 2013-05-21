<?php
$links = array(
	'products' => array(
		array(
			'name' => __d('shop', 'Types'),
			'description' => __d('shop', 'Manage product types'),
			'icon' => 'indent-left',
			'dashboard' => array('controller' => 'shop_product_types', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Options'),
			'description' => __d('shop', 'Manage product options'),
			'icon' => 'list-alt',
			'dashboard' => array('controller' => 'shop_options', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Attributes'),
			'description' => __d('shop', 'Manage store attributes'),
			'icon' => 'check',
			'dashboard' => array('controller' => 'shop_attribute_groups', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Currencies'),
			'description' => __d('shop', 'Manage store currencies'),
			'icon' => 'money',
			'dashboard' => array('controller' => 'shop_currencies', 'action' => 'index')
		),
	),
	'assets' => array(
		array(
			'name' => __d('shop', 'Images'),
			'description' => __d('shop', 'Manage store images'),
			'icon' => 'picture',
			'dashboard' => array('controller' => 'shop_images', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Downloads'),
			'description' => __d('shop', 'Manage store downloads'),
			'icon' => 'download-alt',
			'dashboard' => array('controller' => 'shop_downloads', 'action' => 'index')
		),
	),
	'configuration' => array(
		array(
			'name' => __d('shop', 'Branches'),
			'description' => __d('shop', 'Manage store branches'),
			'icon' => 'briefcase',
			'dashboard' => array('controller' => 'shop_branches', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Suppliers'),
			'description' => __d('shop', 'Manage store suppliers'),
			'icon' => 'globe',
			'dashboard' => array('controller' => 'shop_suppliers', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Brands'),
			'description' => __d('shop', 'Manage product brands'),
			'icon' => 'th',
			'dashboard' => array('controller' => 'shop_brands', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Payments'),
			'description' => __d('shop', 'Manage store payments'),
			'icon' => 'credit-card',
			'dashboard' => array('controller' => 'shop_payment_methods', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Shipping'),
			'description' => __d('shop', 'Manage store shipping'),
			'icon' => 'truck',
			'dashboard' => array('controller' => 'shop_shipping_methods', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Status'),
			'description' => __d('shop', 'Manage order statuses'),
			'icon' => 'time',
			'dashboard' => array('controller' => 'shop_order_statuses', 'action' => 'index')
		)
	)
);

foreach ($links as $name => &$link) {
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