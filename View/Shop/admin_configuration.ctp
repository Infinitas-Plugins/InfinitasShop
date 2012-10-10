<?php
	$links = array(
		'products' => array(
			array(
				'name' => __d('shop', 'Types'),
				'description' => __d('shop', 'Manage product types'),
				'icon' => '/shop/img/icon/product_types/icon.png',
				'dashboard' => array('controller' => 'shop_product_types', 'action' => 'index')
			),
		)
	);
?>
<div class="dashboard grid_8">
	<h1><?php echo __d('shop', 'Shop Config'); ?></h1>
	<?php echo $this->Design->arrayToList(current($this->Menu->builDashboardLinks($links['products'], 'shop_config_products')), 'icons'); ?>
	<p class="info"><?php echo Configure::read('Shop.info.config_products'); ?></p>
</div>