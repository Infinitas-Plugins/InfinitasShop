<?php
$header = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('th', __d('shop', 'Date'), array(
		'class' => 'date'
	)),
	$this->Html->tag('th', __d('shop', 'Note')),
	$this->Html->tag('th', __d('shop', 'Status'), array(
		'class' => 'small'
	)),
	$this->Html->tag('th', __d('shop', 'Notified'), array(
		'class' => 'small'
	))
)));
$rows = array();
foreach ($shopOrder['ShopOrderNote'] as $shopOrderNote) {
	$rows[] = $this->Html->tag('tr', implode('', array(
		$this->Html->tag('td', $this->Infinitas->date($shopOrderNote)),
		$this->Html->tag('td', $shopOrderNote['note']),
		$this->Html->tag('td', $shopOrderStatuses[$shopOrderNote['shop_order_status_id']]),
		$this->Html->tag('td', $shopOrderNote['user_notified']),
	)));
}

echo $this->Html->tag('table', implode('', array(
	$this->Html->tag('thead', $header),
	$this->Html->tag('tbody', implode('', $rows)),
)), array('class' => 'listing'));

echo $this->Html->tag('div', implode('', array(
	$this->Form->input('ShopOrderNote.shop_order_id', array(
		'value' => $shopOrder['ShopOrder']['id'],
		'type' => 'hidden'
	)),
	$this->Form->input('ShopOrderNote.shop_order_status_id', array(
		'label' => __d('shop', 'Order status'),
		'default' => $shopOrder['ShopOrder']['shop_order_status_id']
	)),
	$this->Form->input('ShopOrderNote.user_notified', array(
		'label' => __d('shop', 'Notify customer')
	)),
	$this->Form->input('ShopOrderNote.notes', array(
		'class' => 'span12'
	))
)));
