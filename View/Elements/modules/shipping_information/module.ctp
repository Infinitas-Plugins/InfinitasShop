<?php
if (empty($shippingMethods)) {
	$shippingMethods = ClassRegistry::init('Shop.ShopShippingMethod')->find('info');
}
$config = array_merge(array(
	'layout' => null,
	'title' => __d('shop', 'Shipping options')
), $config);

echo $this->Html->tag('h3', $config['title']);
if ($config['layout'] == 'table') {
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
} else {
	foreach ($shippingMethods as &$shippingMethod) {
		$shippingTime = $this->Shop->timeEstimate($shippingMethod['ShopShippingMethod']['shipping_time_min']);
		if ($shippingMethod['ShopShippingMethod']['shipping_time_min'] != $shippingMethod['ShopShippingMethod']['shipping_time_max']) {
			$shippingTime = __d('shop', 'Between %s and %s',
				$this->Shop->timeEstimate($shippingMethod['ShopShippingMethod']['shipping_time_min']),
				$this->Shop->timeEstimate($shippingMethod['ShopShippingMethod']['shipping_time_max'])
			);
		}

		echo $this->Html->tag('div', implode('', array(
			$this->Html->tag('div', implode('', array(
				//$this->Html->image($shippingMethod['ShopSupplier']['logo']),
				$this->Html->tag('span', implode(' / ', array(
					$shippingMethod['ShopSupplier']['name'], 
					$shippingMethod['ShopShippingMethod']['name']
				)))
			))),
			$this->Html->tag('div', __d('shop', 'Estimated delivery %s', $shippingTime)),
			$this->Html->tag('div', __d('shop', 'Included cover %s', $this->Shop->currency($shippingMethod['ShopShippingMethod']['insurance_cover_max'])))
		)));
	}
}
