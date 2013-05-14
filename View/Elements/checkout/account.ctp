<?php
if (!AuthComponent::user('id')) {
	echo $this->Html->tag('div', implode('', array(
		$this->Html->tag('div', $this->element('Users.register'), array(
			'class' => 'span4 register'
		)),
		$this->Html->tag('div', $this->element('Users.login'), array(
			'class' => 'span4 login'
		))
	)), array('class' => 'span8'));
	return;
}

echo $this->Html->tag('div', implode('', array(
	$this->Form->input('Ignore.address_option', array(
		'type' => 'select',
		'empty' => __d('shop', 'Please enter your details'),
		'label' => false,
		'id' => 'AddressOption',
		'options' => array(
			'account' => __d('shop', 'Use my account details'),
			'gateway' => __d('shop', 'Use the details from my payment provider'),
			'guest' => __d('shop', 'I will check out as a guest')
		)
	)),
	$this->Html->tag('div', implode('', array(
		$this->Form->input('address', array(
			'type' => 'select',
			'label' => false,
			'empyt' => __d('shop', 'Select a past address'),
		)),
		$this->Html->link(__d('shop', 'Add new address'), array(
			'controller' => 'shop_address',
			'action' => 'add'
		))
	)), array('class' => 'address-details', 'id' => 'details-account')),
	$this->Html->tag('div', implode('', array(

	)), array('class' => 'address-details', 'id' => 'details-gateway')),
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('div', implode('', array(
			$this->Html->tag('h4', __d('shop', 'Shipping Information')),
			$this->Form->input('ShopShippingAddress.full_name'),
			$this->Form->input('ShopShippingAddress.email'),
			$this->Form->input('ShopShippingAddress.phone'),
			$this->Form->input('ShopShippingAddress.company'),
			$this->Form->input('ShopShippingAddress.address_1'),
			$this->Form->input('ShopShippingAddress.address_2'),
			$this->Form->input('ShopShippingAddress.city'),
			$this->Form->input('ShopShippingAddress.post_code'),
			$this->Form->input('ShopShippingAddress.state'),
			$this->Form->input('ShopShippingAddress.country'),
		)), array('class' => 'span4')),
		$this->Html->tag('div', implode('', array(
			$this->Html->tag('h4', __d('shop', 'Billing Information')),
			$this->Form->input('ShopBillingAddress.full_name'),
			$this->Form->input('ShopBillingAddress.email'),
			$this->Form->input('ShopBillingAddress.phone'),
			$this->Form->input('ShopBillingAddress.company'),
			$this->Form->input('ShopBillingAddress.address_1'),
			$this->Form->input('ShopBillingAddress.address_2'),
			$this->Form->input('ShopBillingAddress.city'),
			$this->Form->input('ShopBillingAddress.post_code'),
			$this->Form->input('ShopBillingAddress.state'),
			$this->Form->input('ShopBillingAddress.country'),
		)), array('class' => 'billing-adddress span4')),
		$this->Form->input('Ignore.billing_address', array(
			'type' => 'checkbox',
			'value' => 0,
			'id' => 'BillingAddressCheck',
			'label' => __d('shop', 'My billing address is different to my shipping address'),
			'div' => array(
				'class' => 'input checkbox span8'
			)
		)),
	)), array('class' => 'address-details row', 'id' => 'details-guest')),
)), array('class' => 'span8'));
