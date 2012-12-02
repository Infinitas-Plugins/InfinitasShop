<?php
	$config = array_merge(array(
		'type' => 'new'
	), $config);
	$ShopProduct = ClassRegistry::init('Shop.ShopProduct');
	if (!in_array($config['type'], array_keys($ShopProduct->findMethods))) {
		throw new InvalidArgumentException('Selected carousel type is not valid');
	}
	$products = $ShopProduct->find($config['type'], array(
		'limit' => 10
	));

	if (empty($products)) {
		return;
	}

	$active = 'active';
	foreach ($products as &$product) {
		$product = $this->Html->tag('div', implode('', array(
			$this->Html->image($product['ShopImage']['image_full'], array(
				'alt' => $product['ShopProduct']['name'],
				'title' => $product['ShopProduct']['name']
			)),
			$this->Html->tag('div', implode('', array(
				$this->Html->tag('h4', $this->Html->link($product['ShopProduct']['name'], array(
					'plugin' => 'shop',
					'controller' => 'shop_products',
					'action' => 'view',
					'category' => $product['ShopCategory'][0]['slug'],
					'slug' => $product['ShopProduct']['slug']
				))),
				$this->Html->tag('p', $this->Text->truncate(strip_tags($product['ShopProduct']['description']), 300))
			)), array('class' => 'carousel-caption'))
		)), array('class' => array('item', $active)));
		$active = null;
	}

	$id = $config['type'] . '-carousel';
	echo $this->Html->tag('div', implode('', array(
		$this->Html->tag('div', implode('', $products), array('class' => 'carousel-inner')),
		$this->Html->link('&lsaquo;', '#' . $id, array(
			'escape' => false,
			'class' => 'carousel-control left',
			'data-slide' => 'prev'
		)),
		$this->Html->link('&rsaquo;', '#' . $id, array(
			'escape' => false,
			'class' => 'carousel-control right',
			'data-slide' => 'next'
		))
	)), array('id' => $id, 'class' => 'carousel slide'));