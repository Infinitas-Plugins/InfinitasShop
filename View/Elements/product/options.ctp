<?php
if(empty($shopProduct['ShopOption'])) {
	return;
}

$options = array();
foreach($shopProduct['ShopOption'] as $option) {
	$options[] = $this->Form->input($option['id'], array(
		'label' => false,
		'div' => false,
		'name' => sprintf('data[ShopOption][%s]', $option['id']),
		'type' => 'select',
		'empty' => $option['name'],
		'options' => Hash::combine($option, 'ShopOptionValue.{n}.id', 'ShopOptionValue.{n}.name'),
		'class' => $option['required'] ? 'required' : null,
		'title' => trim(strip_tags($option['description']))
	));
}

echo $this->Html->tag('div', implode('', array(
	__d('shop', 'Options'),
	$this->Html->tag('div', implode('', $options), array('class' => 'pull-right ')),
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', __d('shop', 'Required option')),
		__d('shop', 'The higlighted option is required. Please select an option before adding to your cart.')
	)), array('class' => 'alert alert-block'))
)), array('class' => 'options'));
echo $this->Html->tag('hr');