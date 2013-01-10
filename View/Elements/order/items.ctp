<?php
$header = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('th', __d('shop', 'Product')),
	$this->Html->tag('th', __d('shop', 'Code')),
	$this->Html->tag('th', __d('shop', 'Category')),
	$this->Html->tag('th', __d('shop', 'Type'), array('class' => 'medium')),
	$this->Html->tag('th', __d('shop', 'Brand'), array('class' => 'medium')),
	$this->Html->tag('th', __d('shop', 'Quantity'), array('class' => 'small')),
	$this->Html->tag('th', __d('shop', 'Each')),
	$this->Html->tag('th', __d('shop', 'Sub-total')),
)));

$rows = array();
$total = $cost = 0;
foreach ($shopOrder['ShopOrderProduct'] as $product) {
	if (!empty($product['ShopProduct']['id'])) {
		$product['ShopOrderProduct']['name'] = $this->Html->link($product['ShopOrderProduct']['name'], array(
			'controller' => 'shop_products',
			'action' => 'edit',
			$product['ShopProduct']['id']
		));
	}
	if (!empty($product['ShopBrand']['id'])) {
		$product['ShopOrderProduct']['brand'] = $this->Html->link($product['ShopBrand']['name'], array(
			'controller' => 'shop_brands',
			'action' => 'edit',
			$product['ShopBrand']['id']
		));
	}
	if (!empty($product['ShopProductType']['id'])) {
		$product['ShopProductType']['name'] = $this->Html->link($product['ShopProductType']['name'], array(
			'controller' => 'shop_product_types',
			'action' => 'edit',
			$product['ShopProductType']['id']
		));
	}

	if (!empty($product['ShopCategory'][0]['name'])) {
		$product['ShopCategory'][0]['name'] = $this->Html->link($product['ShopCategory'][0]['name'], array(
			'controller' => 'shop_categories',
			'action' => 'edit',
			$product['ShopCategory'][0]['id']
		));
	}

	$subTotal = $product['ShopOrderProductPrice']['selling'] * $product['ShopOrderProduct']['quantity'];
	$total += $subTotal;
	$cost += ($product['ShopOrderProductPrice']['cost'] * $product['ShopOrderProduct']['quantity']);
	$product['ShopCategory'][0]['name'] = !empty($product['ShopCategory'][0]['name']) ? $product['ShopCategory'][0]['name'] : '-';
	$rows[] = $this->Html->tag('tr', implode('', array(
		$this->Html->tag('td', implode($this->Html->tag('br'), array(
			$this->Html->image($product['ShopImage']['image_thumb'], array('width' => 75)),
			$product['ShopOrderProduct']['name']
		))),
		$this->Html->tag('td', $product['ShopOrderProduct']['product_code']),
		$this->Html->tag('td', $product['ShopCategory'][0]['name']),
		$this->Html->tag('td', $product['ShopProductType']['name'] ?: '-'),
		$this->Html->tag('td', $product['ShopOrderProduct']['brand'] ?: '-'),
		$this->Html->tag('td', $this->Design->count($product['ShopOrderProduct']['quantity'])),
		$this->Html->tag('td', $this->Shop->currency($product['ShopOrderProductPrice']['selling'])),
		$this->Html->tag('td', $this->Shop->currency($subTotal)),
	)));
}

$rows[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('th', '&nbsp;', array('colspan' => 6)),
	$this->Html->tag('th', __d('shop', 'Income')),
	$this->Html->tag('th', __d('shop', 'Expense')),
)));

$rows[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4)),
	$this->Html->tag('td', __d('shop', 'Sub total'), array('colspan' => 2)),
	$this->Html->tag('td', $this->Shop->currency($total)),
	$this->Html->tag('td', $this->Shop->currency($cost)),
)));

$rows[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4)),
	$this->Html->tag('td', __d('shop', 'Shipping'), array('colspan' => 2)),
	$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['shipping'])),
	$this->Html->tag('td', $this->Shop->currency(0)),
)));

$rows[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4)),
	$this->Html->tag('td', __d('shop', 'Handling'), array('colspan' => 2)),
	$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['handling'])),
	$this->Html->tag('td', $this->Shop->currency(0)),
)));

$rows[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4)),
	$this->Html->tag('td', __d('shop', 'Insurance'), array('colspan' => 2)),
	$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['insurance'])),
	$this->Html->tag('td', $this->Shop->currency(0)),
)));

$rows[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4)),
	$this->Html->tag('td', __d('shop', 'Fees'), array('colspan' => 2)),
	$this->Html->tag('td', $this->Shop->currency(0)),
	$this->Html->tag('td', $this->Shop->currency($shopOrder['InfinitasPaymentLog']['transaction_fee'])),
)));

$rows[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4)),
	$this->Html->tag('td', __d('shop', 'Tax'), array('colspan' => 2)),
	$this->Html->tag('td', $this->Shop->currency($shopOrder['ShopOrder']['tax'])),
	$this->Html->tag('td', $this->Shop->currency(0)),
)));
$income = array_sum(array(
	$total,
	$shopOrder['ShopOrder']['shipping'],
	$shopOrder['ShopOrder']['handling'],
	$shopOrder['ShopOrder']['insurance']
));
$expense = array_sum(array(
	$cost,
	$shopOrder['InfinitasPaymentLog']['transaction_fee']
));
$textClass = ($income > $expense) ? 'text-success' : 'text-error';
$rows[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4)),
	$this->Html->tag('th', __d('shop', 'Income / Expense'), array('colspan' => 2)),
	$this->Html->tag('td', $this->Shop->currency($income), array('class' => $textClass)),
	$this->Html->tag('td', $this->Shop->currency($expense), array('class' => $textClass)),
)));

$rows[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('th', '&nbsp;', array('colspan' => 6)),
	$this->Html->tag('th', __d('shop', 'Profit')),
	$this->Html->tag('th', __d('shop', 'Margin')),
)));
$margin = @CakeNumber::toPercentage((1 - ($expense / $income)) * 100);
$rows[] = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('td', '&nbsp;', array('colspan' => 4)),
	$this->Html->tag('th', __d('shop', 'Profit'), array('colspan' => 2)),
	$this->Html->tag('td', $this->Shop->currency($income - $expense)),
	$this->Html->tag('td', $margin),
)));

echo $this->Html->tag('table', implode('', array(
	$this->Html->tag('thead', $header),
	$this->Html->tag('tbody', implode('', $rows)),
)), array('class' => 'listing'));
