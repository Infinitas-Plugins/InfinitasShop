<?php
echo $this->Form->input('ModuleConfig.title', array(
	'type' => 'text',
	'label' => __d('infinitas', 'Title'),
	'placeholder' => __d('shop', 'Default - Payment info')
));
echo $this->Form->input('ModuleConfig.layout', array(
	'type' => 'select',
	'empty' => __d('shop', 'Default - div'),
	'options' => array(
		'table' => __d('shop', 'Table layout')
	)
));