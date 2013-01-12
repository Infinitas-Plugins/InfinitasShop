<?php
$rows = array();
$rows[] = $this->Html->tag('div', implode('', array(
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('h6', __d('shop', 'Billing address')),
		$this->Shop->address($shopOrder['ShopBillingAddress'], $shopOrder['User']),
	)), array('class' => 'span4')),
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('h6', __d('shop', 'Shipping address')),
		$this->Shop->address($shopOrder['ShopShippingAddress'], $shopOrder['User']),
	)), array('class' => 'span3')),
	$this->Html->tag('div', $this->Html->tag('dl', implode('', array(
		$this->Html->tag('dt', __d('shop', 'From')),
		$this->Html->tag('dd', Configure::read('Website.name')),
		$this->Html->tag('dt', __d('shop', 'www')),
		$this->Html->tag('dd', trim(str_replace(array('https://', 'http://'), '', InfinitasRouter::url('/')), '/')),
		$this->Html->tag('dt', __d('shop', 'Date')),
		$this->Html->tag('dd', date('d/m/Y', strtotime($shopOrder['ShopOrder']['created']))),
		$this->Html->tag('dt', __d('shop', 'Invoice #')),
		$this->Html->tag('dd', $shopOrder['ShopOrder']['invoice_number']),
		$this->Html->tag('dt', __d('shop', 'Status')),
		$this->Html->tag('dd', $shopOrder['ShopOrderStatus']['name'])
	)), array('class' => 'dl-horizontal')), array('class' => 'span5')),
)), array('class' => 'row'));

$trs = array();
$total = $taxTotal = 0;
foreach ($shopOrder['ShopOrderProduct'] as $product) {
	$subTotal = $product['ShopOrderProductPrice']['selling'] * $product['ShopOrderProduct']['quantity'];
	$total += $subTotal;
	$taxSubTotal = $subTotal * 0;
	$taxTotal += $taxSubTotal;
	$trs[] = $this->Html->tag('tr', implode('', array(
		$this->Html->tag('td', $product['ShopOrderProduct']['quantity']),
		$this->Html->tag('td', $product['ShopOrderProduct']['product_code']),
		$this->Html->tag('td', $product['ShopOrderProduct']['name']),
		$this->Html->tag('td', $this->Shop->currency($product['ShopOrderProductPrice']['selling'])),
		$this->Html->tag('td', $this->Shop->currency($taxSubTotal)),
		$this->Html->tag('td', $this->Shop->currency($subTotal)),
	)));
}

$trs[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4)),
	$this->Html->tag('th', __d('shop', 'Shipping')),
	$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['shipping']))
)));

$trs[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4, 'style' => 'border-top: none;')),
	$this->Html->tag('th', __d('shop', 'Handling')),
	$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['handling']))
)));

$trs[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4, 'style' => 'border-top: none;')),
	$this->Html->tag('th', __d('shop', 'Insurance')),
	$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['insurance']))
)));

$trs[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4, 'style' => 'border-top: none;')),
	$this->Html->tag('th', __d('shop', 'Discount')),
	$this->Html->tag('th', $this->Shop->currency(0))
)));

$trs[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4, 'style' => 'border-top: none;')),
	$this->Html->tag('th', __d('shop', 'Tax')),
	$this->Html->tag('th', $this->Shop->currency($shopOrder['ShopOrder']['tax']))
)));

$trs[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4, 'style' => 'border-top: none;')),
	$this->Html->tag('th', __d('shop', 'Total')),
	$this->Html->tag('th', $this->Shop->currency($shopOrder['ShopOrder']['total']))
)));

$rows[] = $this->Html->tag('table', implode('', array(
	$this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
		$this->Html->tag('th', __d('shop', 'Quantity'), array('class' => 'small')),
		$this->Html->tag('th', __d('shop', 'Code')),
		$this->Html->tag('th', __d('shop', 'Product')),
		$this->Html->tag('th', __d('shop', 'Each')),
		$this->Html->tag('th', __d('shop', 'Tax')),
		$this->Html->tag('th', __d('shop', 'Sub-total')),
	)))),
	$this->Html->tag('tbody', implode('', $trs)),
)), array('class' => 'table'));

array_unshift($rows, implode('', array(
	$this->Html->tag('h2', __d('shop', 'Invoice'))
)));
echo $this->Html->tag('div', implode('', $rows), array(
	'class' => 'invoice'
));