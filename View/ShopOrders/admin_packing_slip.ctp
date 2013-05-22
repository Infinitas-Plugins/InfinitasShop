<?php
$content_heading = array();
foreach ($shopOrders as &$shopOrder) {
	$content_heading[] = $this->Html->tag('h4', $this->Html->link(
		$shopOrder['ShopOrder']['invoice_number'],
		$this->here . '#' . $shopOrder['ShopOrder']['invoice_number']
	));
	$shopOrder = $this->element('Shop.order/packing_slip', array(
		'shopOrder' => $shopOrder
	));
}

$this->set('content_heading', $this->Html->tag('div', implode('', array(
	$this->Html->tag('h3', __d('shop', 'Pakcing slips')),
	implode('', $content_heading)
))));

echo $this->Html->tag('div', implode('', $shopOrders), array(
	'class' => 'invoices'
));