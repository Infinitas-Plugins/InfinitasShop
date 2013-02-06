<?php

echo $this->Form->create(null, array(
	'inputDefaults' => array(
		'div' => false,
		'label' => false,
	),
	'novalidate' => 'novalidate'
));
echo $this->Infinitas->adminEditHead();
$k = 0;
foreach ($shopAttributeGroups as &$attributeGroup) {
	foreach ($attributeGroup['ShopAttribute'] as &$attribute) {
		$field = 'ShopAttribute.' . $k++;

		$attribute = $this->Html->tag('li', implode('', array(
			$this->Html->link($this->Html->image($attribute['image_medium'], array('class' => array('img-rounded', 'img-polaroid'))), $this->request->here . '#', array(
				'class' => array(
					'attribute'
				),
				'escape' => false,
				'title' => $attribute['name']
			)),
			implode('', array(
				$this->Form->input($field . '.shop_product_id', array(
					'value' => $shopProductId,
					'type' => 'hidden'
				)),
				$this->Form->input($field . '.shop_attribute_id', array(
					'value' => $attribute['id'],
					'type' => 'hidden'
				)),
				$this->Form->input($field . '.selected', array(
					'checked' => (bool)$attribute['ShopProductAttribute']['id'],
					'type' => 'checkbox',
					'id' => $attribute['id'],
					'data-name' => $attribute['name'],
					'div' => array(
						'class' => 'hide attribute'
					)
				))
			))
		)), array('class' => array('span2', $attribute['ShopProductAttribute']['id'] ? 'active' : null)));
	} 
	$attributeGroup = $this->Html->tag('div', implode('', array(
		$this->Html->tag('h4', $attributeGroup['ShopAttributeGroup']['name']),
		$this->Html->tag('ul', implode('', $attributeGroup['ShopAttribute']), array(
			'class' => 'thumbnails'
		))
	)), array('class' => 'row'));
}
$shopAttributeGroups = array_chunk($shopAttributeGroups, 3);
foreach ($shopAttributeGroups as &$shopAttributeGroup) {
	$shopAttributeGroup = $this->Html->tag('div', implode('', $shopAttributeGroup), array(
		'class' => 'span6'
	));
}

foreach ($shopProductImages as &$image) {
	$image = $this->Html->link($this->Html->image($image, array('class' => array('img-rounded', 'img-polaroid'))), $image, array(
		'class' => 'thickbox',
		'escape' => false
	));
}
$shopProductImages = $this->Design->arrayToList($shopProductImages, array(
		'ul' => 'thumbnails',
		'li' => 'span2'
	));
echo $this->Html->tag('div', implode('', array(
	$this->Html->tag('div', implode('', $shopAttributeGroups), array('class' => 'span8')),
	$this->Html->tag('div', $shopProductImages, array('class' => 'span4', 'style' => 'position: fixed'))
)), array('class' => 'attributes row'));