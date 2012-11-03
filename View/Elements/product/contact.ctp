<?php
$message = __d('shop', 'Please %s if you need any more infomation or assistance regarding to this product.',
	$this->Html->link(__d('newsletter', 'contact us'), array(
		'plugin' => 'newsletter',
		'controller' => 'newsletters',
		'action' => 'contact'
	))
);
echo $this->Html->tag('div', $message, array('class' => 'alert alert-info'));
echo $this->Html->tag('hr');
