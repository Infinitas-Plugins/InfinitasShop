<?php
try {
	$shippingMethods = ClassRegistry::init('Shop.ShopShippingMethod')->find('info');
} catch (Exception $e) {
	var_dump($e->getMessage());
	exit;
}
$td = $this->Html->tag('td', '%s');
foreach ($shippingMethods as &$shippingMethod) {
	$shippingTime = $this->Shop->timeEstimate($shippingMethod['ShopShippingMethod']['shipping_time_min']);
	if ($shippingMethod['ShopShippingMethod']['shipping_time_min'] != $shippingMethod['ShopShippingMethod']['shipping_time_max']) {
		$shippingTime = __d('shop', 'Between %s and %s',
			$this->Shop->timeEstimate($shippingMethod['ShopShippingMethod']['shipping_time_min']),
			$this->Shop->timeEstimate($shippingMethod['ShopShippingMethod']['shipping_time_max'])
		);
	}
	$shippingMethod = $this->Html->tag('tr', implode('', array(
		sprintf($td, $shippingMethod['ShopSupplier']['name']),
		sprintf($td, $shippingMethod['ShopShippingMethod']['name']),
		sprintf($td, $shippingTime),
		sprintf($td, $this->Shop->currency($shippingMethod['ShopShippingMethod']['insurance_cover_max']))
	)));
}

echo $this->Html->tag('table', implode('', array(
	$this->Html->tag('thead', $this->Html->tag('tr', implode('', array(
		$this->Html->tag('th', __d('shop', 'Supplier'), array('style' => 'width:150px;')),
		$this->Html->tag('th', __d('shop', 'Shipping method')),
		$this->Html->tag('th', __d('shop', 'Expected'), array(
			'style' => 'width:100px;',
			'title' => __d('shop', 'The estimated delivery time for this shipping method')
		)),
		$this->Html->tag('th', __d('shop', 'Cover'), array(
			'style' => 'width:100px;',
			'title' => __d('shop', 'The maximum insurance cover (actual value based on final order)')
		))
	)))),
	$this->Html->tag('tbody', implode('', $shippingMethods))
)), array('class' => 'listing'));
