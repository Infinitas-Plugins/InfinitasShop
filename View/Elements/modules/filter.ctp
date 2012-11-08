<?php
echo $this->Form->create('ShopProduct', array(
	'url' => array(
		'plugin' => 'shop',
		'controller' => 'shop_products',
		'action' => 'search',
	),
	'inputDefaults' => array(
		'label' => false,
		'div' => false
	)
));

	$options = array();
	foreach($shopFilterOptions['ShopOption'] as $option) {
		$options[] = $this->Form->input($option['id'], array(
			'type' => 'checkbox',
			'label' => $option['name'],
			'div' => true
		));
	}

	echo $this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', __d('shop', 'Product filter')),
		$this->Html->tag('div', '', array('class' => 'range')),
		$this->Form->input('price_min', array(
			'style' => 'display:none;',
			'value' => 10
		)),
		$this->Form->input('price_max', array(
			'style' => 'display:none;',
			'value' => 150
		)),
		$this->Html->tag('h5', __d('shop', 'Price')),
		$this->Html->tag('div', '', array('class' => 'price-slider')),
		$this->Form->input('special', array(
			'type' => 'checkbox',
			'label' => __d('shop', 'On sale'),
			'div' => true
		)),
		$this->Html->tag('h4', __d('shop', 'Options')),
		implode('', $options)
	)), array('class' => 'well filter', 'style' => 'width: 100%'));
echo $this->Form->end();