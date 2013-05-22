<?php
$header = $this->Html->tag('tr', implode('', array(
	$this->Html->tag('th', __d('shop', 'Date'), array(
		'class' => 'date'
	)),
	$this->Html->tag('th', __d('shop', 'Note')),
	$this->Html->tag('th', __d('shop', 'Status'), array(
		'class' => 'small'
	)),
	$this->Html->tag('th', __d('shop', 'Status'), array(
		'class' => 'small'
	))
)));
$statuses = array();
array_walk($shopOrderStatuses, function ($group) use(&$statuses) {
	$statuses += $group;
});
$rows = array();
foreach ($shopOrder['ShopOrderNote'] as $shopOrderNote) {
	$rows[] = $this->Html->tag('tr', implode('', array(
		$this->Html->tag('td', $this->Infinitas->date($shopOrderNote)),
		$this->Html->tag('td', $shopOrderNote['notes']),
		$this->Html->tag('td', $statuses[$shopOrderNote['shop_order_status_id']]),
		$this->Html->tag('td', implode('', array(
			$shopOrderNote['user_notified'] ? $this->Html->link($this->Design->icon('envelope'), $this->here . '#', array('escape' => false)) : null,
			$shopOrderNote['internal'] ? $this->Html->link($this->Design->icon('eye-close'), $this->here . '#', array('escape' => false)) : null,
		))),
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
	$this->Form->input('ShopOrderNote.internal', array(
		'label' => __d('shop', 'Internal note (not visable to clients)')
	)),
	$this->Form->input('ShopOrderNote.notes', array(
		'class' => 'span12'
	)),
	$this->Form->submit(__d('shop', 'SAve'))
)));
