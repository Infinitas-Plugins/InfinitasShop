<?php
if (empty($paymentOptions)) {
	$paymentOptions = ClassRegistry::init('Shop.ShopPaymentMethod')->find('info', array(
		'order_value' => 0
	));
}

$config = array_merge(array(
	'title' => __d('shop', 'Payment info')
), $config);
echo $this->Html->tag('h3', $config['title']);
foreach ((array)$paymentOptions as $paymentOption) {
	echo $this->Html->tag('div', $paymentOption['ShopPaymentMethod']['name']);
}