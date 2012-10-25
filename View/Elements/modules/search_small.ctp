<?php
$value = null;
if(!empty($this->request->params['pass'])) {
	$value = current($this->request->params['pass']);
}

echo $this->Form->create('ShopProduct', array('url' => array(
	'plugin' => 'shop',
	'controller' => 'shop_products',
	'action' => 'search'
), 'class' => 'search search-small'));
	echo $this->Form->input('search', array(
		'placeholder' => __d('shop', 'Search'),
		'div' => false,
		'label' => false,
		'value' => $value
	));
echo $this->Form->end();
