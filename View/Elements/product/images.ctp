<?php
$images = array();
foreach($shopProduct['ShopImagesProduct'] as $image) {

}

if(!empty($images)) {
	$images = $this->Design->arrayToList($images, array(
		'ul' => 'thumbnails',
		'li' => 'span2'
	));
} else {
	$images = '';
}
echo $this->Html->tag('div', implode('', array(
	$this->Html->image($shopProduct['ShopImage']['image_full']),
	$images
)), array('class' => 'thumbnail span4'));