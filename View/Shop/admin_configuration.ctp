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
			)
		)
	);
?>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Shop Config'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['products'], 'shop_config_products')), 'icons'); ?>
</div>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Shop Assets'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['assets'], 'shop_config_assets')), 'icons'); ?>
</div>
<div class="dashboard grid_16">
	<h1><?php echo __d('shop', 'Configuration'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['configuration'], 'shop_config_configuration')), 'icons'); ?>
</div>