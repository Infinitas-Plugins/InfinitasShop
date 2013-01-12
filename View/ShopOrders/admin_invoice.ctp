<?php
foreach ($shopOrders as &$shopOrder) {
	$shopOrder = $this->element('Shop.order/invoice', array(
		'shopOrder' => $shopOrder
	));
}

echo $this->Html->tag('div', implode('', $shopOrders), array(
	'class' => 'invoices'
));