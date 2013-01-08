<?php

$blocks = array();
$blocks[] = $this->Html->tag('div', implode('', array(
	$this->Html->tag('h4', __d('shop', 'Details')),
	$this->Html->tag('dl', implode('', array(
		$this->Html->tag('dt', __d('shop', 'Currency')),
		$this->Html->tag('dd', $shopOrder['InfinitasPaymentLog']['currency_code']),
		$this->Html->tag('dt', __d('shop', 'Fee')),
		$this->Html->tag('dd', $this->Shop->currency($shopOrder['InfinitasPaymentLog']['transaction_fee'], $shopOrder['InfinitasPaymentLog']['currency_code'])),
		$this->Html->tag('dt', __d('shop', 'Total')),
		$this->Html->tag('dd', $this->Shop->currency($shopOrder['InfinitasPaymentLog']['total'], $shopOrder['InfinitasPaymentLog']['currency_code'])),
		$this->Html->tag('dt', __d('shop', 'Date')),
		$this->Html->tag('dd', CakeTime::nice($shopOrder['InfinitasPaymentLog']['created'])),
		$this->Html->tag('dt', __d('shop', 'Status')),
		$this->Html->tag('dd', $shopOrder['InfinitasPaymentLog']['status']),
	)), array('class' => 'dl-horizontal')),
)), array('class' => 'span6'));

$blocks[] = $this->Html->tag('div', implode('', array(
	$this->Html->tag('h4', __d('shop', 'Technical')),
	$this->Html->tag('dl', implode('', array(
		$this->Html->tag('dt', __d('shop', 'Token')),
		$this->Html->tag('dd', $shopOrder['InfinitasPaymentLog']['token'] ?: '-'),
		$this->Html->tag('dt', __d('shop', 'Transaction ID')),
		$this->Html->tag('dd', $shopOrder['InfinitasPaymentLog']['transaction_id'] ?: '-'),
		$this->Html->tag('dt', __d('shop', 'Type')),
		$this->Html->tag('dd', $shopOrder['InfinitasPaymentLog']['transaction_type'] ?: '-'),
		$this->Html->tag('dt', __d('shop', 'Custom')),
		$this->Html->tag('dd', $shopOrder['InfinitasPaymentLog']['custom'] ?: '-'),
		$this->Html->tag('dt', __d('shop', 'Transaction date')),
		$this->Html->tag('dd', CakeTime::nice($shopOrder['InfinitasPaymentLog']['transaction_date'])),
	)), array('class' => 'dl-horizontal')),
)), array('class' => 'span6'));

echo $this->Html->tag('div', implode('', $blocks), array('class' => 'row'));

$codeBlock = $this->Html->tag('div', '%s' . $this->Html->tag('pre', $this->Html->tag('code', '%s')), array('class' => 'span6 raw-data'));
$blocks = array();

echo $this->Html->tag('div', implode('', array(
	sprintf($codeBlock,
		$this->Html->tag('h4', __d('shop', 'Raw Request')),
		print_r($shopOrder['InfinitasPaymentLog']['raw_request'], true)
	),
	sprintf($codeBlock,
		$this->Html->tag('h4', __d('shop', 'Raw Response')),
		print_r($shopOrder['InfinitasPaymentLog']['raw_response'], true)
	),
)), array('class' => 'row'));
