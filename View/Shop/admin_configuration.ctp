<?php
	$links = array(
		'products' => array(
			array(
				'name' => __d('shop', 'Types'),
				'description' => __d('shop', 'Manage product types'),
				'icon' => '/shop/img/icon/product_types.png',
				'dashboard' => array('controller' => 'shop_product_types', 'action' => 'index')
			),
			array(
				'name' => __d('shop', 'Options'),
				'description' => __d('shop', 'Manage product options'),
				'icon' => '/shop/img/icon/options.png',
				'dashboard' => array('controller' => 'shop_options', 'action' => 'index')
			),
			array(
				'name' => __d('shop', 'Attributes'),
				'description' => __d('shop', 'Manage store attributes'),
				'icon' => '/shop/img/icons/attributes.png',
				'dashboard' => array('controller' => 'shop_attributes', 'action' => 'index')
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
		)
	);
?>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Shop Config'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['products'], 'shop_config_products')), 'icons'); ?>
	<p class="info"><?php echo Configure::read('Shop.info.config_products'); ?></p>
</div>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Shop Assets'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['assets'], 'shop_config_assets')), 'icons'); ?>
	<p class="info"><?php echo Configure::read('Shop.info.config_products'); ?></p>
</div>