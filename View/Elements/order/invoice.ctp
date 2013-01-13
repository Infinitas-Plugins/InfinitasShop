<?php
$rows = array();
$rows[] = $this->Html->tag('div', implode('', array(
	$this->Html->tag('div', implode('', array(
		$this->Shop->address(array(
			'address_1' => '',
			'address_2' => ''
		), array('full_name' => Configure::read('Website.name'))),
	)), array('class' => 'span6')),
	$this->Html->tag('div', $this->Html->tag('dl', implode('', array(
		$this->Html->tag('dt', __d('shop', 'Date')),
		$this->Html->tag('dd', date('d/m/Y', strtotime($shopOrder['ShopOrder']['created']))),
		$this->Html->tag('dt', __d('shop', 'Invoice #')),
		$this->Html->tag('dd', $shopOrder['ShopOrder']['invoice_number']),
		$this->Html->tag('dt', __d('shop', 'Status')),
		$this->Html->tag('dd', $shopOrder['ShopOrderStatus']['name']),
		$this->Html->tag('dt', __d('shop', 'www')),
		$this->Html->tag('dd', trim(str_replace(array('https://', 'http://'), '', InfinitasRouter::url('/')), '/')),
	)), array('class' => 'dl-horizontal')), array('class' => 'span6')),
)), array('class' => 'row-fluid'));

$rows[] = $this->Html->tag('div', implode('', array(
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('h6', __d('shop', 'Bill To:')),
		$this->Shop->address($shopOrder['ShopBillingAddress'], $shopOrder['User']),
	)), array('class' => 'span6')),
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('h6', __d('shop', 'Ship To:')),
		$this->Shop->address($shopOrder['ShopShippingAddress'], $shopOrder['User']),
	)), array('class' => 'span6')),
)), array('class' => 'row-fluid'));

$rows[] = $this->Html->tag('div', implode('', array(
	$this->Html->tag('table', implode('', array(
		$this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
			$this->Html->tag('th', __d('shop', 'Account')),
			$this->Html->tag('th', __d('shop', 'Rep')),
			$this->Html->tag('th', __d('shop', 'Order number')),
			$this->Html->tag('th', __d('shop', 'Est. Date')),
			$this->Html->tag('th', __d('shop', 'Ref')),
			$this->Html->tag('th', __d('shop', 'Delivery')),
			$this->Html->tag('th', __d('shop', 'Invoice Date')),
			$this->Html->tag('th', __d('shop', 'Invoice No.')),
			$this->Html->tag('th', __d('shop', 'Page')),
		)))),
		$this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
			$this->Html->tag('td', __d('shop', 'Account')),
			$this->Html->tag('td', __d('shop', 'Rep')),
			$this->Html->tag('td', $shopOrder['ShopOrder']['invoice_number']),
			$this->Html->tag('td', date('d-m-Y', strtotime($shopOrder['ShopOrder']['created']))),
			$this->Html->tag('td', '&nbsp;'),
			$this->Html->tag('td', '&nbsp;'),
			$this->Html->tag('td', date('d-m-Y', strtotime($shopOrder['ShopOrder']['created']))),
			$this->Html->tag('td', $shopOrder['ShopOrder']['invoice_number']),
			$this->Html->tag('td', sprintf('%s of %s', 1, 1)),
		)))),
	)), array('class' => 'table table-condensed'))
)), array('class' => 'row-fluid'));

$trs = array();
$total = $taxTotal = 0;
foreach ($shopOrder['ShopOrderProduct'] as $k => $product) {
	$subTotal = $product['ShopOrderProductPrice']['selling'] * $product['ShopOrderProduct']['quantity'];
	$total += $subTotal;
	$taxTotal += $subTotal * 0;
	$trs[] = $this->Html->tag('tr', implode('', array(
		$this->Html->tag('td', $k + 1),
		$this->Html->tag('td', $product['ShopOrderProduct']['product_code']),
		$this->Html->tag('td', $product['ShopOrderProduct']['name']),
		$this->Html->tag('td', $product['ShopOrderProduct']['quantity']),
		$this->Html->tag('td', $this->Shop->currency($product['ShopOrderProductPrice']['selling'])),
		$this->Html->tag('td', $this->Shop->currency($subTotal)),
	)));
}

$rows[] = $this->Html->tag('table', implode('', array(
	$this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
		$this->Html->tag('th', __d('shop', '#'), array('class' => 'tiny')),
		$this->Html->tag('th', __d('shop', 'Code'), array('class' => 'medium')),
		$this->Html->tag('th', __d('shop', 'Product')),
		$this->Html->tag('th', __d('shop', 'Quantity'), array('class' => 'small')),
		$this->Html->tag('th', __d('shop', 'Each'), array('class' => 'small')),
		$this->Html->tag('th', __d('shop', 'Sub-total'), array('class' => 'small')),
	)))),
	$this->Html->tag('tbody', implode('', $trs)),
)), array('class' => 'table table-condensed'));

$rows[] = $this->Html->tag('div', implode('', array(
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('table', implode('', array(
			$this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
				$this->Html->tag('th', __d('shop', 'Shipping')),
				$this->Html->tag('th', __d('shop', 'Payment')),
				$this->Html->tag('th', __d('shop', 'Transaction #')),
			)))),
			$this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
				$this->Html->tag('td', $shopOrder['ShopShippingMethod']['name'] ?: '-'),
				$this->Html->tag('td', $shopOrder['ShopPaymentMethod']['name'] ?: '-'),
				$this->Html->tag('td', $shopOrder['InfinitasPaymentLog']['transaction_id'] ?: '-'),
			)))),
		)), array('class' => 'table table-condensed'))
	)), array('class' => 'span6')),
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('table', implode('', array(
			$this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
				$this->Html->tag('th', __d('shop', 'Goods')),
				$this->Html->tag('th', __d('shop', 'Tax Rate')),
				$this->Html->tag('th', __d('shop', 'Tax')),
			)))),
			$this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
				$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['total'])),
				$this->Html->tag('td', CakeNumber::toPercentage(Configure::read('Shop.vat_rate'))),
				$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['tax']))
			)))),
		)), array('class' => 'table table-condensed'))
	)), array('class' => 'span6')),
)), array('class' => 'row-fluid'));

$rows[] = $this->Html->tag('div', implode('', array(
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('table', implode('', array(
			$this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
				$this->Html->tag('th', __d('shop', 'Shipping')),
				$this->Html->tag('th', __d('shop', 'Handling')),
				$this->Html->tag('th', __d('shop', 'Insurance')),
				$this->Html->tag('th', __d('shop', 'Tax')),
				$this->Html->tag('th', __d('shop', 'Total')),
			)))),
			$this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
				$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['shipping'])),
				$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['handling'])),
				$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['insurance'])),
				$this->Html->tag('td', $this->Shop->currency(0)),
				$this->Html->tag('td', $this->Shop->currency(array_sum(array(
					$shopOrder['ShopOrder']['shipping'],
					$shopOrder['ShopOrder']['handling'],
					$shopOrder['ShopOrder']['insurance']
				)))),
			)))),
		)), array('class' => 'table table-condensed'))
	)), array('class' => 'span12')),
)), array('class' => 'row-fluid'));

array_unshift($rows, implode('', array(
	$this->Html->tag('h2', __d('shop', 'Invoice'), array(
		'id' => $shopOrder['ShopOrder']['invoice_number']
	))
)));
echo $this->Html->tag('div', implode('', $rows), array(
	'class' => 'invoice'
));