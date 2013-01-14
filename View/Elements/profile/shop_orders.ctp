<?php
if (empty($shopOrders)) {
	return;
}

$rows = array($this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
	$this->Html->tag('th', '#'),
	$this->Html->tag('th', __d('shop', 'Total'), array(
		'style' => 'width: 25px'
	)),
	$this->Html->tag('th', __d('shop', 'Status'), array(
		'style' => 'width: 75px'
	)),
	$this->Html->tag('th', __d('shop', 'Actions'), array(
		'style' => 'width: 20px'
	))
)))));

foreach ($shopOrders as $shopOrder) {
	$shopOrder['ShopOrder']['invoice_number'] = $this->Html->link('#' . $shopOrder['ShopOrder']['invoice_number'], array(
		'plugin' => 'shop',
		'controller' => 'shop_orders',
		'action' => 'view',
		$shopOrder['ShopOrder']['id']
	));
	$rows[] = $this->Html->tag('tr', implode('', array(
		$this->Html->tag('td', $shopOrder['ShopOrder']['invoice_number']),
		$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['total'])),
		$this->Html->tag('td', $this->Design->label($shopOrder['ShopOrderStatus']['name'])),
		$this->Html->tag('td', implode('', array(
			$this->Html->link($this->Design->icon('search'), array(
				'plugin' => 'shop',
				'controller' => 'shop_orders',
				'action' => 'view',
				$shopOrder['ShopOrder']['id']
			), array('escape' => false, 'title' => __d('shop', 'View'))),
			$this->Html->link($this->Design->icon('retweet'), array(
				'plugin' => 'shop',
				'controller' => 'shop_orders',
				'action' => 'reorder',
				$shopOrder['ShopOrder']['id']
			), array('escape' => false, 'title' => __d('shop', 'Reorder')))
		))),
	)), array('title' => __d('shop', 'Last updated %s', CakeTime::timeAgoInWords($shopOrder['ShopOrder']['modified']))));
}
echo $this->Html->tag('table', implode('', $rows), array(
	'class' => 'table'
));
echo $this->Html->link(__d('shop', 'All orders'), array(
	'plugin' => 'shop',
	'controller' => 'shop_orders',
	'action' => 'index'
), array('class' => 'btn pull-right'));
