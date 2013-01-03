<?php
echo $this->Shop->categoryBreadcrumbs($categoryPath, $shopProduct['ShopProduct']['name']);

echo $this->Form->create('ShopListProduct', array('action' => 'add'));
	echo $this->Form->hidden('ShopList.shop_product_id', array(
		'value' => $shopProduct['ShopProduct']['id']
	));

	echo $this->Html->tag('div', implode('', array(
		$this->Html->tag('h1', $shopProduct['ShopProduct']['name']),
		$this->element('Shop.product/images', array(
			'shopProduct' => $shopProduct
		)),
		$this->Html->tag('div', implode('', array(
			$this->element('Shop.product/specs', array('shopProduct' => $shopProduct)),
			$this->element('Shop.product/options', array('shopProduct' => $shopProduct)),
			$this->element('Shop.product/rating', array('shopProduct' => $shopProduct)),
			$this->element('Shop.product/share'),
			$this->element('Shop.product/add_to_cart', array('shopProduct' => $shopProduct)),
			$this->element('Shop.product/contact'),
		)), array('class' => 'span7'))
	)), array('class' => 'product-info'));

echo $this->element('Shop.product/variant_table', array(
	'shopProduct' => $shopProduct
));
echo $this->Form->end();

echo $this->element('Shop.product/description', array(
	'shopProduct' => $shopProduct
));
