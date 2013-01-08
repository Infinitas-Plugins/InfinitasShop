<?php
$rows = array();
$rows[] = implode('', array(
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', __d('shop', 'Order')),
		$this->Html->tag('dl', implode('', array(
			$this->Html->tag('dt', __d('shop', 'Invoice number')),
			$this->Html->tag('dd', $this->Design->label('#' . $shopOrder['ShopOrder']['invoice_number'])),
			$this->Html->tag('dt', __d('shop', 'Value')),
			$this->Html->tag('dd', $this->Shop->adminCurrency($shopOrder['ShopOrder']['total'])),
			$this->Html->tag('dt', __d('shop', 'Items')),
			$this->Html->tag('dd', $this->Design->count($shopOrder['ShopOrder']['shop_order_product_count'])),
		)), array('class' => 'dl-horizontal'))
	)), array('class' => 'span6')),
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', __d('shop', 'Customer')),
		$this->Html->tag('dl', implode('', array(
			$this->Html->tag('dt', __d('shop', 'Customer')),
			$this->Html->tag('dd', $this->Html->link($shopOrder['User']['full_name'], array(
				'plugin' => 'users',
				'controller' => 'users',
				'action' => 'view',
				$shopOrder['User']['id']
			))),
			$this->Html->tag('dt', __d('shop', 'Prefered name')),
			$this->Html->tag('dd', $shopOrder['User']['prefered_name']),
			$this->Html->tag('dt', __d('shop', 'Username')),
			$this->Html->tag('dd', $shopOrder['User']['username']),
			$this->Html->tag('dt', __d('users', 'Email')),
			$this->Html->tag('dd', $this->Text->autoLinkEmails($shopOrder['User']['email'])),
		)), array('class' => 'dl-horizontal'))
	)), array('class' => 'span6')),
));
$rows[] = implode('', array(
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', __d('shop', 'History')),
		$this->Html->tag('dl', implode('', array(
			$this->Html->tag('dt', __d('shop', 'Previous orders')),
			$this->Html->tag('dd', $this->Design->count($shopOrder['ShopOrder']['previous_orders_count'])),
			$this->Html->tag('dt', __d('shop', 'Previous order value')),
			$this->Html->tag('dd', $this->Shop->adminCurrency($shopOrder['ShopOrder']['previous_orders_value'])),
			$this->Html->tag('dt', __d('shop', 'Product views')),
			$this->Html->tag('dd', $this->Design->count(0)),
		)), array('class' => 'dl-horizontal')),
	)), array('class' => 'span6')),
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', __d('shop', 'Technical')),
		$this->Html->tag('dl', implode('', array(
			$this->Html->tag('dt', __d('users', 'Browser')),
			$this->Html->tag('dd', $shopOrder['User']['browser']),
			$this->Html->tag('dt', __d('users', 'Operating System')),
			$this->Html->tag('dd', $shopOrder['User']['operating_system']),
			$this->Html->tag('dt', __d('users', 'Active Carts')),
			$this->Html->tag('dd', 1),
			$this->Html->tag('dt', __d('users', 'IP address')),
			$this->Html->tag('dd', $shopOrder['ShopOrder']['ip_address'] ?: '-'),
			$this->Html->tag('dt', __d('users', 'Last login')),
			$this->Html->tag('dd', CakeTime::timeAgoInWords($shopOrder['User']['last_login'])),
			$this->Html->tag('dt', __d('users', 'Last activity')),
			$this->Html->tag('dd', CakeTime::timeAgoInWords($shopOrder['User']['last_click'])),
		)), array('class' => 'dl-horizontal')),
	)), array('class' => 'span6')),
));
foreach ($rows as $row) {
	echo $this->Html->tag('div', $row, array('class' => 'row'));
}