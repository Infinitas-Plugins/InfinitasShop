<?php
if (!AuthComponent::user('id')) {
	echo $this->Html->tag('div', implode('', array(
		$this->Html->tag('div', $this->element('Users.register'), array(
			'class' => 'span4'
		)),
		$this->Html->tag('div', $this->element('Users.login'), array(
			'class' => 'span4'
		))
	)), array('class' => 'span8'));
	return;
}

var_dump('shipping information');
