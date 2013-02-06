<?php
/**
 * @brief Add some documentation for this admin_index form.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.View.admin_index
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

echo $this->Form->create(null, array(
	'action' => 'mass'
));
echo $this->Infinitas->adminIndexHead($filterOptions, array(
	'add',
	'edit',
	'copy',
	'delete'
));

$orderHandle = $this->Html->link($this->Design->icon('reorder'), $this->here . '#', array(
	'escape' => false,
	'class' => 'icon reorder'
));

$empty = array();
foreach ($shopAttributeGroups as $k => $shopAttributeGroup) {
	$products = array_sum(Hash::extract($shopAttributeGroup['ShopAttribute'], '{n}.shop_product_attribute_count'));
	foreach ($shopAttributeGroup['ShopAttribute'] as &$attribute) {
		$name = $this->Html->tag('div', $attribute['name'], array('class' => 'name'));
		if ($attribute['image']) {
			$name = $this->Html->image($attribute['image_small'], array(
				'width' => 50
			)) . $name;
		}
		$attribute = $this->Html->tag('li', implode('', array(
			$name,
			$this->Design->count($attribute['shop_product_attribute_count'], null, false),
			$this->Html->tag('div', implode('', array(
				$orderHandle,
				$this->Html->link($this->Design->icon('minus'), array(
					'controller' => 'shop_attributes',
					'action' => 'delete',
					$attribute['id']
				), array('escape' => false, 'class' => 'icon delete')),
				$this->Html->link($this->Design->icon('edit'), array(
					'controller' => 'shop_attributes',
					'action' => 'edit',
					$attribute['id'],
					'?' => 'asd'
				), array('escape' => false, 'class' => 'icon thickbox'))
			)), array('class' => 'actions'))
		)), array(
			'class' => array(
				'thumbnail attribute',
				'group-' . $attribute['shop_attribute_group_id']
			)
		));
	}
	$attributes = $this->Html->tag('ul', implode('', $shopAttributeGroup['ShopAttribute']), array(
		'class' => 'thumbnails'
	));

	$shopAttributeGroups[$k] = $this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', implode('', array(
			$this->Infinitas->massActionCheckBox($shopAttributeGroup),
			Inflector::humanize($shopAttributeGroup['ShopAttributeGroup']['name']),
			$this->Html->link($this->Design->icon('add'), array(
				'controller' => 'shop_attributes',
				'action' => 'add',
				'ShopAttributeGroup.id' => $shopAttributeGroup['ShopAttributeGroup']['id']
			), array('escape' => false, 'class' => 'icon')),
			$this->Html->tag('small', __dn('shop', '%d product', '%d products', $products, $products), array('class' => 'count')),
		))),
		$attributes
	)), array(
		'class' => 'thumbnail',
		'data-original-position' => $shopAttributeGroup['ShopAttributeGroup']['id']
	));

	if(empty($attributes)) {
		$empty[] = $shopAttributeGroups[$k];
		unset($shopAttributeGroups[$k]);
	}
}
$shopAttributeGroups = array_chunk($shopAttributeGroups, 4);
foreach ($shopAttributeGroups as &$set) {
	$set = $this->Html->tag('div', $this->Design->arrayToList($set, array(
		'ul' => 'module-positions thumbnails',
		'li' => 'span12'
	)), array('class' => 'span3'));
}
echo $this->Html->tag('div', implode('', $shopAttributeGroups), array(
	'class' => 'row'
));


if ($empty) {
	echo $this->Html->tag('h2', __d('shop', 'Unused'));
	echo $this->Design->arrayToList($empty, array(
		'ul' => 'module-positions thumbnails',
		'li' => 'span3 empty'
	));
}