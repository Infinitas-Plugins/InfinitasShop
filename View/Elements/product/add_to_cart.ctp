<?php
echo $this->Html->tag('strong', __d('shop', 'Price: %s', $this->Shop->price($shopProduct, false)));
echo $this->Form->button(__d('shop', 'Add to cart'), array(
	'class' => 'pull-right btn btn-small add-to-cart'
));
echo $this->Form->input('quantity', array(
	'value' => 1,
	'class' => 'quantity',
	'div' => false,
	'label' => false
));
echo $this->Html->tag('hr');