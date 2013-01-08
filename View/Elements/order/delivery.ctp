<?php
echo $this->Html->tag('div', implode('', array(
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', __d('shop', 'Delivery')),
		$this->Shop->address($shopOrder['ShopShippingAddress'], $shopOrder['User'])
	)), array('class' => 'span6')),
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', __d('shop', 'Billing')),
		$this->Shop->address($shopOrder['ShopBillingAddress'], $shopOrder['User'])
	)), array('class' => 'span6'))
)), array('class' => 'row'));
