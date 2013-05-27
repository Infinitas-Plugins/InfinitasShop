<?php
if (!empty($shopAddresses)) {
	$rows = array($this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
		$this->Html->tag('th', __d('shop', 'Name')),
		$this->Html->tag('th', __d('shop', 'Address')),
		$this->Html->tag('th', __d('shop', 'Region'), array(
			'style' => 'width: 20px'
		)),
		$this->Html->tag('th', __d('shop', 'Country'), array(
			'style' => 'width: 25px'
		)),
		__d('infinitas', 'Actions')
	)))));

	$currentListId = $this->Session->read('Shop.current_list');
	foreach ($shopAddresses as $shopAddress) {
		$rows[] = $this->Html->tag('tr', implode('', array(
			$this->Html->tag('td', h($shopAddress['ShopAddress']['name'])),
			$this->Html->tag('td', h(implode(', ', array($shopAddress['ShopAddress']['address_1'], $shopAddress['ShopAddress']['address_2'], $shopAddress['ShopAddress']['post_code'])))),
			$this->Html->tag('td', $shopAddress['ShopAddress']['region']),
			$this->Html->tag('td', $shopAddress['ShopAddress']['country']),
			$this->Html->tag('td', implode('', array(
				$this->Html->link($this->Design->icon('edit'), array(
					'plugin' => 'shop',
					'controller' => 'shop_addresses',
					'action' => 'edit',
					$shopAddress['ShopAddress']['id']
				), array('escape' => false, 'title' => __d('shop', 'Edit'))),
				$this->Html->link($this->Design->icon('delete'), array(
					'plugin' => 'shop',
					'controller' => 'shop_addresses',
					'action' => 'delete',
					$shopAddress['ShopAddress']['id']
				), array('escape' => false))
			))),
		)), array('title' => __d('shop', 'Last updated %s', CakeTime::timeAgoInWords($shopAddress['ShopAddress']['modified']))));
	}
	echo $this->Html->tag('table', implode('', $rows), array(
		'class' => 'table'
	));
}

echo $this->Form->create('ShopAddress', array(
	'url' => array(
		'plugin' => 'shop',
		'controller' => 'shop_addresses',
		'action' => 'add',
	),
	'inputDefaults' => array(
		'div' => false,
		'label' => false
	)
));
	echo $this->Form->input('name', array(
		'placeholder' => __d('shop', 'eg: Home or Work')
	));
	echo $this->Form->input('address_1', array(
		'placeholder' => __d('shop', 'Address line 1')
	));
	echo $this->Form->input('address_2', array(
		'placeholder' => __d('shop', 'Address line 2')
	));
	echo $this->element('GeoLocation.region_select', array(
		'model' => 'ShopAddress'
	));
	echo $this->Form->input('post_code', array(
		'placeholder' => __d('shop', 'Post / Zip code')
	));
	echo $this->Form->input('billing', array(
		'label' => __d('shop', 'This is for billing only'),
		'type' => 'checkbox',
		'div' => true
	));
	echo $this->Form->submit(__d('shop', 'Save'), array(
		'div' => false,
		'class' => 'pull-right'
	));
echo $this->Form->end();


