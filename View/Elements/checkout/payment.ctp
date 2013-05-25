<?php
foreach ($shopPaymentMethods as $k => $v) {
	$class = array('btn', 'btn-small');
	if ($k == $shopList['ShopPaymentMethod']['id']) {
		$class[] = 'active';
	}
	$buttons[] = $this->Html->link($v, array(
		'plugin' => 'shop',
		'controller' => 'shop_list_products',
		'action' => 'set_payment_method',
		$k
	), array('class' => $class));
}
echo $this->Html->tag('div', implode('', array(
	$this->Html->tag('p', __d('shop', 'Select your payment option below')),
	$this->Html->tag('div', implode('', $buttons), array(
		'class' => 'btn-group'
	))
)), array('class' => 'options payment'));
