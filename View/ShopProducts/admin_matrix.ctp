<?php
$optionsHeader = array();
foreach ($shopProduct['ShopOption'] as $option) {
	$optionsHeader[] = $option['name'];
}

$optionsHeader[] = __d('shop', 'Disabled');
$optionsHeader[] = __d('shop', 'Product Code');
$optionsHeader[] = __d('shop', 'Total');

$mainHeader = array(
	__d('shop', 'Options') => array('colspan' => count($shopProduct['ShopOption']) * 2),
	__d('shop', 'Product') => array('colspan' => (count($optionsHeader) - count($shopProduct['ShopOption'])) * 2)
);
foreach ($mainHeader as $main => &$trOption) {
	$trOption = $this->Html->tag('th', $main, $trOption);
}

$shopOptionValues = Hash::extract($shopProduct['ShopOption'], '{n}.ShopOptionValue');
$shopOptions = Hash::combine($shopProduct['ShopOption'], '{n}.id', '{n}.slug');
$allOptions = array(array());
foreach ($shopOptionValues as $list) {
	$temp = array();
	foreach ($allOptions as $resultItem) {
		foreach ($list as $listItem) {
			$temp[] = array_merge($resultItem, array(
				$shopOptions[$listItem['shop_option_id']] => $listItem['id']
			));
		}
	}
	$allOptions = $temp;
}
$valueNames = Hash::combine($shopProduct, 'ShopOption.{n}.ShopOptionValue.{n}.id', 'ShopOption.{n}.ShopOptionValue.{n}.name');

$rows = array();
$i = 0;
$formField = 'ShopProduct.' . $i;
foreach ($allOptions as $options) {
	$row = array();
	$options = array_combine(array_keys($shopOptions), $options);
	foreach ($options as $k => $v) {
		$row[] = implode('', array(
			$this->Form->hidden($formField . '.id', array('value' => $shopProduct['ShopProduct']['id'])),
			$this->Form->hidden($formField . '.shop_option_id', array('value' => $k)),
			$this->Form->hidden($formField . '.shop_option_value_id', array('value' => $v)),
			$valueNames[$v]
		));
		$row[] = $this->Form->input($formField . '.price', array(
			'div' => false,
			'label' => false,
			'class' => 'span3',
			'type' => 'number',
			'min' => 0,
			'step' => 0.01
		));
	}

	$row[] = $this->Form->input($formField . '.disabled', array(
		'type' => 'checkbox',
		'div' => false,
		'label' => false
	));
	$row[] = '&nbsp;';
	$row[] = $shopProduct['ShopProductCode'][$i]['product_code'];
	$row[] = '&nbsp;';
	$row[] = '&nbsp;';

	$rows[] = $row;
	$i++;
}

echo $this->Html->tag('h3', $shopProduct['ShopProduct']['name']);
echo $this->Html->tag('table', implode('', array(
	$this->Html->tag('tr', implode('', $mainHeader)),
	$this->Html->tableHeaders($optionsHeader, array(), array(
		'colspan' => 2
	)),
	$this->Html->tableCells($rows)
)), array('class' => 'listing'));