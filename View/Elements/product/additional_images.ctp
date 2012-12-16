<?php
if (empty($shopProduct['ShopImagesProduct'])) {
	return;
}

foreach ($shopProduct['ShopImagesProduct'] as &$image) {
	$image = $this->Html->link($this->Html->image($image['image_small']), $image['image_full'], array(
		'class' => 'thickbox',
		'escape' => false
	));
}

echo $this->Design->arrayToList($shopProduct['ShopImagesProduct'], array(
	'ul' => 'thumbnails',
	'li' => 'span2'
));
