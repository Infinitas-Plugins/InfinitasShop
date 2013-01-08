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
		$this->Html->tag('td', $this->Shop->currency(0)),
		$this->Html->tag('td', $this->Shop->currency(0)),
	)));
}

echo $this->Html->tag('table', implode('', array(
	$this->Html->tag('thead', $header),
	$this->Html->tag('tbody', implode('', $rows)),
)), array('class' => 'listing'));
