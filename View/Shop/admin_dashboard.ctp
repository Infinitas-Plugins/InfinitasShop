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
				'name' => __d('shop', 'Branches'),
				'description' => __d('shop', 'Manage your branches'),
				'icon' => '/shop/img/icons/branches.png',
				'dashboard' => array('controller' => 'shop_branches', 'action' => 'index')
			),
			array(
				'name' => __d('shop', 'Products'),
				'description' => __d('shop', 'Manage your products'),
				'icon' => '/shop/img/icons/products.png',
				'dashboard' => array('controller' => 'shop_products', 'action' => 'index')
			),
			array(
				'name' => __d('shop', 'Categories'),
				'description' => __d('shop', 'Manage product categories'),
				'icon' => '/contents/img/categories.png',
				'dashboard' => array('controller' => 'shop_categories', 'action' => 'index')
			),
			array(
				'name' => __d('shop', 'Suppliers'),
				'description' => __d('shop', 'Manage suppliers'),
				'icon' => '/shop/img/icons/suppliers.png',
				'dashboard' => array('controller' => 'shop_suppliers', 'action' => 'index')
			),
			array(
				'name' => __d('shop', 'Units'),
				'description' => __d('shop', 'Manage product units'),
				'icon' => '/shop/img/icons/units.png',
				'dashboard' => array('controller' => 'shop_units', 'action' => 'index')
			),
		),
		'manage' => array(
			array(
				'name' => __d('shop', 'Specials'),
				'description' => __d('shop', 'Manage product specials'),
				'icon' => '/shop/img/icons/specials.png',
				'dashboard' => array('controller' => 'shop_specials', 'action' => 'index')
			),
			array(
				'name' => __d('shop', 'Featured'),
				'description' => __d('shop', 'Manage spotlight products'),
				'icon' => '/shop/img/icons/featured.png',
				'dashboard' => array('controller' => 'shop_spotlights', 'action' => 'index')
			),
			array(
				'name' => __d('shop', 'Stock'),
				'description' => __d('shop', 'Manage product stock'),
				'icon' => '/shop/img/icons/stock.png',
				'dashboard' => array('controller' => 'shop_stocks', 'action' => 'index')
			),
			array(
				'name' => __d('shop', 'Cart'),
				'description' => __d('shop', 'View user carts'),
				'icon' => '/shop/img/icons/cart.png',
				'dashboard' => array('controller' => 'shop_carts', 'action' => 'index')
			),
		)
	);
?>
<div class="dashboard grid_16">
	<h1><?php echo __d('shop', 'Shop Config'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['main'], 'shop_main')), 'icons'); ?>
	<p class="info"><?php echo Configure::read('Shop.info.config'); ?></p>
</div>
<div class="dashboard grid_16">
	<h1><?php echo __d('shop', 'Product management'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['manage'], 'shop_manage')), 'icons'); ?>
	<p class="info"><?php echo Configure::read('Shop.info.manage'); ?></p>
</div>
<?php
	echo $this->ModuleLoader->loadDirect('Contents.dashboard_links');

	echo $this->ModuleLoader->loadDirect('ViewCounter.popular_items',
		array(
			'model' => 'Shop.ShopProduct'
		)
	);