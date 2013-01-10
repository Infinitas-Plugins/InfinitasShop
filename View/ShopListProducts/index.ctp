<?php
/**
 * Add some documentation for this index form.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.View.index
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */


if (empty($shopListProducts)) {
	echo $this->Design->alert(__d('shop', 'You dont have anything in your cart yet'));
	return;
}

echo $this->Form->create(null, array('action' => 'mass'));
$contents = $this->element('Shop.checkout/contents');
$total = $this->Html->tag('table', $this->Html->tag('thead', implode('', array(
	$this->Html->tag('tr', implode('', array(
		$this->Html->tag('td', ''),
		$this->Html->tag('td', __d('shop', 'Sub Total'), array('style' => 'width: 100px;')),
		$this->Html->tag('td', $this->Shop->cartPrice($shopListProducts), array('style' => 'width: 100px;'))
	))),
	$this->Html->tag('tr', implode('', array(
		$this->Html->tag('td', ''),
		$this->Html->tag('td', __d('shop', 'Shipping')),
		$this->Html->tag('td', $this->Shop->shipping($shopShippingMethod))
	))),
	$this->Html->tag('tr', implode('', array(
		$this->Html->tag('td', ''),
		$this->Html->tag('td', __d('shop', 'Total')),
		$this->Html->tag('td', ' ' . $this->Shop->cartPrice($shopListProducts, $shopShippingMethod))
	)))
))), array('class' => 'shipping'));
if ($this->request->is('ajax')) {
	echo $contents . $total;
	echo $this->Form->end();
	return;
}

$boxes = array();

$buttons = $this->Html->tag('div', implode('', array(
	$this->Html->link(__d('shop', 'Next'), '#checkout-account', array(
		'class' => 'accordion-toggle btn',
		'data-toggle' => 'collapse',
		'data-parent' => '#accordion-checkout'
	))
)), array('class' => 'btn-group'));
$contents = implode('', array(
	$this->Html->tag('div', $this->Html->link(__d('shop', 'Products'), $this->here . '#', array('class' => 'accordion-toggle')), array(
		'class' => 'accordion-heading'
	)),
	$this->Html->tag('div', $this->Html->tag('div', $contents . $buttons, array('class' => 'accordion-body')), array(
		'id' => 'checkout-content',
		'class' => 'accordion-body collapse in'
	))
));
$boxes[] = $this->Html->tag('div', $contents, array('class' => 'accordion-group'));





$contents = $this->element('Shop.checkout/account');
$buttons = $this->Html->tag('div', implode('', array(
	$this->Html->link(__d('shop', 'Next'), '#checkout-shipping', array(
		'class' => 'accordion-toggle btn',
		'data-toggle' => 'collapse',
		'data-parent' => '#accordion-checkout'
	)),
	$this->Html->link(__d('shop', 'Previous'), '#checkout-content', array(
		'class' => 'accordion-toggle btn',
		'data-toggle' => 'collapse',
		'data-parent' => '#accordion-checkout'
	))
)), array('class' => 'btn-group'));
$contents = implode('', array(
	$this->Html->tag('div', $this->Html->link(__d('shop', 'Account information'), $this->here . '#', array('class' => 'accordion-toggle')), array(
		'class' => 'accordion-heading'
	)),
	$this->Html->tag('div', $this->Html->tag('div', $contents . $buttons, array('class' => 'accordion-body')), array(
		'id' => 'checkout-account',
		'class' => 'accordion-body collapse'
	))
));
$boxes[] = $this->Html->tag('div', $contents, array('class' => 'accordion-group'));






$contents = $this->element('Shop.checkout/shipping');
$buttons = $this->Html->tag('div', implode('', array(
	$this->Html->link(__d('shop', 'Next'), '#checkout-payment', array(
		'class' => 'accordion-toggle btn',
		'data-toggle' => 'collapse',
		'data-parent' => '#accordion-checkout'
	)),
	$this->Html->link(__d('shop', 'Previous'), '#checkout-account', array(
		'class' => 'accordion-toggle btn',
		'data-toggle' => 'collapse',
		'data-parent' => '#accordion-checkout'
	))
)), array('class' => 'btn-group'));
$contents = implode('', array(
	$this->Html->tag('div', $this->Html->link(__d('shop', 'Shipping options'), $this->here . '#', array('class' => 'accordion-toggle')), array(
		'class' => 'accordion-heading'
	)),
	$this->Html->tag('div', $this->Html->tag('div', $contents . $buttons, array('class' => 'accordion-body')), array(
		'id' => 'checkout-shipping',
		'class' => 'accordion-body collapse'
	))
));
$boxes[] = $this->Html->tag('div', $contents, array('class' => 'accordion-group'));





$contents = $this->element('Shop.checkout/payment');
$buttons = $this->Html->tag('div', implode('', array(
	$this->Html->link(__d('shop', 'Previous'), '#checkout-shipping', array(
		'class' => 'accordion-toggle btn',
		'data-toggle' => 'collapse',
		'data-parent' => '#accordion-checkout'
	))
)), array('class' => 'btn-group'));
$contents = implode('', array(
	$this->Html->tag('div', $this->Html->link(__d('shop', 'Payment options'), $this->here . '#', array('class' => 'accordion-toggle')), array(
		'class' => 'accordion-heading'
	)),
	$this->Html->tag('div', $this->Html->tag('div', $contents . $buttons, array('class' => 'accordion-body')), array(
		'id' => 'checkout-payment',
		'class' => 'accordion-body collapse'
	))
));
$boxes[] = $this->Html->tag('div', $contents, array('class' => 'accordion-group'));



echo $this->Html->tag('div', implode('', $boxes), array(
	'class' => 'accordion',
	'id' => 'accordion-checkout'
));
echo $total;

echo $this->Form->end();