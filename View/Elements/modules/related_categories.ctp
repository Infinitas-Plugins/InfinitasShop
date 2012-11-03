<?php
if(empty($shopRelatedCategories)) {
	return;
}

echo $this->Html->tag('div', implode('', array(
	$this->Html->tag('h4', __d('shop', 'Related Categories')),

)), array('class' => 'well'));