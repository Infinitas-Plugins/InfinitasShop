<?php
if(false && !$requreSetup) { ?>
	<div class="dashboard grid_16">
		<h1><?php echo __d('shop', 'Please setup the Shop before use'); ?></h1>
		<p class="info">
			<?php
				echo sprintf(
					__d('shop', 'Add some %s before you start selling'),
					$this->Html->link(
						__d('contents', 'layouts'),
						array(
							'plugin' => 'contents',
							'controller' => 'global_layouts',
							'action' => 'add'
						)
					)
				);
			?>
		</p>
	</div> <?php
	return;
}

$links = array(
	'main' => array(
		array(
			'name' => __d('shop', 'Clients'),
			'description' => __d('shop', 'Manage clients'),
			'icon' => '/users/img/icon.png',
			'dashboard' => array('controller' => 'shop_products', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Categories'),
			'description' => __d('shop', 'Manage store categories'),
			'icon' => '/contents/img/categories.png',
			'dashboard' => array('controller' => 'shop_categories', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Config'),
			'description' => __d('shop', 'Manage store configuration'),
			'icon' => '/configs/img/icon.png',
			'dashboard' => array('controller' => 'shop', 'action' => 'configuration')
		),
	),
	'products' => array(
		array(
			'name' => __d('shop', 'Products'),
			'description' => __d('shop', 'Manage store products'),
			'icon' => '/shop/img/icons/products.png',
			'dashboard' => array('controller' => 'shop_products', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Specials'),
			'description' => __d('shop', 'Manage store specials'),
			'icon' => '/shop/img/icons/specials.png',
			'dashboard' => array('controller' => 'shop_specials', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Featured'),
			'description' => __d('shop', 'Manage store products'),
			'icon' => '/shop/img/icons/featured.png',
			'dashboard' => array('controller' => 'shop_spotlights', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Stock'),
			'description' => __d('shop', 'Manage store stock'),
			'icon' => '/shop/img/icons/stock.png',
			'dashboard' => array('controller' => 'shop_branch_stocks', 'action' => 'index')
		),
	),
	'orders' => array(
		array(
			'name' => __d('shop', 'Orders'),
			'description' => __d('shop', 'Manage store orders'),
			'icon' => '/shop/img/icons/orders.png',
			'dashboard' => array('controller' => 'shop_orders', 'action' => 'index')
		),
		array(
			'name' => __d('shop', 'Carts'),
			'description' => __d('shop', 'Manage store carts'),
			'icon' => '/shop/img/icons/cart.png',
			'dashboard' => array('controller' => 'shop_lists', 'action' => 'index')
		),
	)
);

foreach($links as $name => &$link) {
	$link = $this->Design->arrayToList(current((array)$this->Menu->builDashboardLinks($link, 'shop_main_dashboard_' . $name)), array(
		'ul' => 'icons'
	));
}

echo $this->Design->dashboard($links['products'], __d('shop', 'Products'), array(
	'class' => 'dashboard span6',
	'info' => Configure::read('Shop.info.products')
));

echo $this->Design->dashboard($links['orders'], __d('shop', 'Orders'), array(
	'class' => 'dashboard span6',
	'info' => Configure::read('Shop.info.orders')
));

echo $this->Design->dashboard($links['main'], __d('shop', 'Configuration'), array(
	'class' => 'dashboard span6',
	'info' => Configure::read('Shop.info.configuration')
));

echo $this->Html->tag('div', '', array('class' => 'clearfix'));
echo $this->ModuleLoader->loadDirect('ViewCounter.popular_items', array(
	'model' => 'Shop.ShopProduct'
));