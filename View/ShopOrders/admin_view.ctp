<?php
/**
 * Order details view
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link    http://infinitas-cms.org/Shop
 * @package	Shop.views.admin_add
 * @license	http://infinitas-cms.org/mit-license The MIT License
 * @since   0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */
echo $this->Form->create();
	echo $this->Infinitas->adminOtherHead(array(
		'invoice',
		'delivery-note',
		'cancel'
	));

	$tabs = array(
		__d('shop', 'Order'),
		__d('shop', 'Payment'),
		__d('shop', 'Delivery'),
		__d('shop', 'Items'),
		__d('shop', 'Notes'),
	);
	$contents = array(
		$this->element('Shop.order/overview'),
		$this->element('Shop.order/payment'),
		$this->element('Shop.order/delivery'),
		$this->element('Shop.order/items'),
		$this->element('Shop.order/notes'),
	);

	$details = implode('', array(
		$this->Html->tag('h3', __d('shop', 'Order #%s', $shopOrder['ShopOrder']['invoice_number'])),
		$this->Html->tag('dl', implode('', array(
			$this->Html->tag('dt', __d('shop', 'Status')),
			$this->Html->tag('dd', $this->Design->label($shopOrder['ShopOrderStatus']['name'])),
			$this->Html->tag('dt', __d('shop', 'Order date')),
			$this->Html->tag('dd', CakeTime::timeAgoInWords($shopOrder['ShopOrder']['created'])),
			$this->Html->tag('dt', __d('shop', 'Customer')),
			$this->Html->tag('dd', $shopOrder['User']['full_name']),
			$this->Html->tag('dt', __d('users', 'Email')),
			$this->Html->tag('dd', $this->Text->autoLinkEmails($shopOrder['User']['email'])),
			$this->Html->tag('dt', __d('shop', 'Value')),
			$this->Html->tag('dd', $this->Shop->adminCurrency($shopOrder['ShopOrder']['total'])),
			$this->Html->tag('dt', __d('shop', 'Assigned To')),
			$this->Html->tag('dd', $this->Text->autoLinkEmails($shopOrder['ShopAssignedUser']['username'] ?: '-')),
		)), array('class' => 'dl-horizontal')),
	));

	echo $this->Html->tag('div', implode('', array(
		$this->Html->tag('div', $this->Design->tabs($tabs, $contents), array(
			'class' => 'span8'
		)),
		$this->Html->tag('div', $details, array(
			'class' => 'span4'
		)),
	)), array('class' => 'row'));
echo $this->Form->end();