<?php
echo $this->Html->tag('div', $this->element('Shop.order/invoice', array(
	'shopOrder' => $shopOrder
)), array('class' => 'invoices'));