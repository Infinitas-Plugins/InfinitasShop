<?php
echo $this->Html->tag('div', implode('', array(
	$this->Html->tag('div', implode('', array(

	)), array('class' => 'control')),
	$this->Html->tag('div', '', array(
		'class' => 'charts',
		'data-url' => '/admin/shop/shop_orders/report_data/grouped'
	))
)), array('class' => 'grouped'));