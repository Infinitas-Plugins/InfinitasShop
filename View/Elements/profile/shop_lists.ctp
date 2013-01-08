<?php
if (empty($shopLists)) {
	return;
}
$rows = array($this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
	$this->Html->tag('th', __d('shop', 'Name')),
	$this->Html->tag('th', __d('shop', 'Items'), array(
		'style' => 'width: 25px'
	)),
	$this->Html->tag('th', __d('shop', 'Value'), array(
		'style' => 'width: 75px'
	)),
	$this->Html->tag('th', __d('shop', 'Actions'), array(
		'style' => 'width: 20px'
	))
)))));

$currentListId = $this->Session->read('Shop.current_list');
foreach ($shopLists as $shopList) {
	if ($currentListId == $shopList['ShopList']['id']) {
		$shopList['ShopList']['name'] = $this->Design->label($shopList['ShopList']['name']);
	} else {
		$shopList['ShopList']['name'] = $this->Html->link($shopList['ShopList']['name'], array(
			'plugin' => 'shop',
			'controller' => 'shop_lists',
			'action' => 'change_list',
			$shopList['ShopList']['id']
		));
	}
	$rows[] = $this->Html->tag('tr', implode('', array(
		$this->Html->tag('td', $shopList['ShopList']['name']),
		$this->Html->tag('td', $this->Design->count($shopList['ShopList']['shop_list_product_count'])),
		$this->Html->tag('td', $this->Shop->currency($shopList['ShopList']['value'])),
		$this->Html->tag('td', implode('', array(
			$this->Html->link($this->Design->icon('search'), array(
				'plugin' => 'shop',
				'controller' => 'shop_lists',
				'action' => 'change_list',
				$shopList['ShopList']['id']
			), array('escape' => false, 'title' => __d('shop', 'View'))),
			$this->Html->link($this->Design->icon('delete'), array(
				'plugin' => 'shop',
				'controller' => 'shop_lists',
				'action' => 'delete',
				$shopList['ShopList']['id']
			), array('escape' => false))
		))),
	)), array('title' => __d('shop', 'Last updated %s', CakeTime::timeAgoInWords($shopList['ShopList']['modified']))));
}
echo $this->Html->tag('table', implode('', $rows), array(
	'class' => 'table'
));

echo $this->Form->create('ShopList', array(
	'url' => array(
		'plugin' => 'shop',
		'controller' => 'shop_lists',
		'action' => 'add',
	),
	'inputDefaults' => array(
		'div' => false,
		'label' => false
	)
));
	echo $this->Form->input('name', array(
		'placeholder' => __d('shop', 'Create a new list')
	));
	echo $this->Form->submit(__d('shop', 'Save'), array(
		'div' => false,
		'class' => 'pull-right'
	));
echo $this->Form->end();


