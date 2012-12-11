<?php
$images = array();
foreach ($shopProduct['ShopImagesProduct'] as &$image) {
	$image = $this->Html->link($this->Html->image($image['image_thumb']), $image['image_full'], array(
		'class' => 'thickbox',
		'escape' => false
	));
}

if (!empty($shopProduct['ShopImagesProduct'])) {
	$shopProduct['ShopImagesProduct'] = $this->Design->arrayToList($shopProduct['ShopImagesProduct'], array(
		'ul' => 'thumbnails',
		'li' => 'span2'
	));
}

$colourLinks = implode('', array(
	$this->Html->link(__d('shop', 'White'), '#', array(
		'class' => 'background-change btn btn-mini btn-primary',
		'data-colour' => '#ffffff'
	)),
	$this->Html->link(__d('shop', 'Gray'), '#', array(
		'class' => 'background-change btn btn-mini btn-primary',
		'data-colour' => '#E3E3E3'
	)),
	$this->Html->link(__d('shop', 'Black'), '#', array(
		'class' => 'background-change btn btn-mini btn-primary',
		'data-colour' => '#000000'
	)),
	$this->Html->link(__d('shop', 'Red'), '#', array(
		'class' => 'background-change btn btn-mini btn-primary',
		'data-colour' => '#ff0000'
	)),
	$this->Html->link(__d('shop', 'Green'), '#', array(
		'class' => 'background-change btn btn-mini btn-primary',
		'data-colour' => '#00ff00'
	)),
	$this->Html->link(__d('shop', 'Blue'), '#', array(
		'class' => 'background-change btn btn-mini btn-primary',
		'data-colour' => '#0000ff'
	))
));

echo $this->Html->tag('div', implode('', array(
	$this->Html->tag('div', implode('', array(
		$this->Form->button('×', array(
			'class' => 'close',
			'type' => 'button',
			'data-dismiss' => 'modal',
			'aria-hidden' => 'true'
		)),
		$this->Html->tag('h3', $shopProduct['ShopProduct']['name'], array(
			'id' => 'mainImageHeading'
		))
	)), array('class' => 'modal-header')),
	$this->Html->tag('div', $this->Html->image($shopProduct['ShopImage']['image_full']), array('class' => 'modal-body')),
	$this->Html->tag('div', $colourLinks, array('class' => 'modal-footer'))
)), array(
	'id' => 'mainProductImage',
	'class' => 'modal hide fade',
	'tabindex' => -1,
	'role' => 'dialog',
	'aria-labelledby' => 'main-image',
	'aria-hidden' => 'true'
));
echo $this->Html->tag('div', implode('', array(
	$this->Html->link($this->Html->image($shopProduct['ShopImage']['image_full']), '#mainProductImage', array(
		'escape' => false,
		'role' => 'button',
		'data-toggle' => 'modal'
	)),
	!empty($shopProduct['ShopImagesProduct']) ? $shopProduct['ShopImagesProduct'] : null
)), array('class' => 'thumbnail span4'));