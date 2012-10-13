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
?>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Products'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['products'], 'shop_products')), 'icons'); ?>
</div>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Orders'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['orders'], 'shop_orders')), 'icons'); ?>
</div>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Configuration'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['main'], 'shop_main')), 'icons'); ?>
</div>
<?php

	echo $this->ModuleLoader->loadDirect('ViewCounter.popular_items',
		array(
			'model' => 'Shop.ShopProduct'
		)
	);