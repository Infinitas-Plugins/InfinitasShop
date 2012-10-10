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
				'icon' => '/shop/img/icons/configuration.png',
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
				'name' => __d('shop', 'Options'),
				'description' => __d('shop', 'Manage store options'),
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
				'name' => __d('shop', 'Images'),
				'description' => __d('shop', 'Manage store images'),
				'icon' => '/shop/img/icons/images.png',
				'dashboard' => array('controller' => 'shop_images', 'action' => 'index')
			),
		),
		'stock' => array(
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
				'name' => __d('shop', 'Stock'),
				'description' => __d('shop', 'Manage store stock'),
				'icon' => '/shop/img/icons/stock.png',
				'dashboard' => array('controller' => 'shop_branch_stocks', 'action' => 'index')
			),
		),
		'orders' => array(
			array(
				'name' => __d('shop', 'Payments'),
				'description' => __d('shop', 'Manage store payments'),
				'icon' => '/shop/img/icons/payments.png',
				'dashboard' => array('controller' => 'shop_payment_methods', 'action' => 'index')
			),
			array(
				'name' => __d('shop', 'Shipping'),
				'description' => __d('shop', 'Manage store shipping'),
				'icon' => '/shop/img/icons/payments.png',
				'dashboard' => array('controller' => 'shop_shipping_methods', 'action' => 'index')
			),
			array(
				'name' => __d('shop', 'Carts'),
				'description' => __d('shop', 'Manage store carts'),
				'icon' => '/shop/img/icons/cart.png',
				'dashboard' => array('controller' => 'shop_lists', 'action' => 'index')
			),
		),
		'promotion' => array(
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
		)
	);
?>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Shop Config'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['main'], 'shop_main')), 'icons'); ?>
	<p class="info"><?php echo Configure::read('Shop.info.config'); ?></p>
</div>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Shop Products'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['products'], 'shop_products')), 'icons'); ?>
	<p class="info"><?php echo Configure::read('Shop.info.config'); ?></p>
</div>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Shop Orders'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['orders'], 'shop_orders')), 'icons'); ?>
	<p class="info"><?php echo Configure::read('Shop.info.config'); ?></p>
</div>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Shop Stock'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['stock'], 'shop_stock')), 'icons'); ?>
	<p class="info"><?php echo Configure::read('Shop.info.config'); ?></p>
</div>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Promotions'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['promotion'], 'shop_promotion')), 'icons'); ?>
	<p class="info"><?php echo Configure::read('Shop.info.manage'); ?></p>
</div>
<?php
	echo $this->ModuleLoader->loadDirect('Contents.dashboard_links');

	echo $this->ModuleLoader->loadDirect('ViewCounter.popular_items',
		array(
			'model' => 'Shop.ShopProduct'
		)
	);