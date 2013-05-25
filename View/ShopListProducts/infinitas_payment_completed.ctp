<?php
echo $this->Html->tag('h2', __d('shop', 'Your order is complete'));

if (AuthComponent::user('id')) {
	$link = $this->Html->link(__d('shop', 'your account'), array(
		'plugin' => 'users',
		'controller' => 'users',
		'action' => 'profile'
	));
	echo $this->Html->tag('p', __d('shop', 'To view your order details please check %s or view an order directly with one of the links below:', $link));

	foreach ($results as $order) {
		$link = $this->Html->link($order['invoice_number'], array(
			'controller' => 'shop_orders',
			'action' => 'view',
			$order['id']
		));
		echo $this->Html->tag('p', $link);
	}
} else {
	echo $this->Html->tag('p', __d('shop', 'You have checked out as a guest so we are unable to display your order details securely on our website. Please check your emails for any updates to your order'));
}

echo $this->Html->tag('p', __d('shop', 'Your order will be processed once payment has been confirmed.'));