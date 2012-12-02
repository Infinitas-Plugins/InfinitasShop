<?php
	/**
	 * Add some documentation for this add form.
	 *
	 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
	 *
	 * @link    http://infinitas-cms.org/Shop
	 * @package	Shop.views.add
	 * @license	http://infinitas-cms.org/mit-license The MIT License
	 * @since   0.9b1
	 *
	 * @author dogmatic69
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */
	echo $this->Form->create();
		echo $this->Infinitas->adminEditHead(); 
		echo $this->Form->input('id');
		echo $this->Form->hidden('shop_shipping_method_id', array(
			'default' => !empty($this->request->params['named']) ? $this->request->params['named'] : null
		));

		$rates = $insurance = array();
		if (!empty($this->request->data['ShopShippingMethodValue'])) {
			$smallField = array('div' => false, 'label' => false);
			$rates[] = $this->Form->label('rates', __d('shop', 'Shipping option rates'));
			foreach ($this->request->data['ShopShippingMethodValue']['rates'] as $k => $rate) {
				$rates[] = $this->Html->tag('div', implode('', array(
					$this->Form->input('limit', array_merge($smallField, array(
						'name' => sprintf('data[ShopShippingMethodValue][rates][%s][limit]', $k),
						'value' => $rate['limit'],
						'placeholder' => __d('shop', 'Limit ($)')
					))),
					$this->Form->input('rate', array_merge($smallField, array(
						'name' => sprintf('data[ShopShippingMethodValue][rates][%s][rate]', $k),
						'value' => $rate['rate'],
						'placeholder' => __d('shop', 'Rate ($)')
					))),
					$this->Image->image('actions', 'remove', array(
						'url' => $this->here . '#', 
						'class' => 'rate remove',
						'title' => __d('shop', 'Remove tier :: Remove this tier from the shipping option')
					))
				)), array('class' => 'tiny'));
			}
			$rates[] = $this->Image->image('actions', 'add', array(
				'url' => $this->here . '#', 
				'class' => 'rate add',
				'data-type' => 'rates'
			));
			$rates[] = $this->Form->hidden('rates_counter', array_merge($smallField, array(
				'value' => count($this->request->data['ShopShippingMethodValue']['rates'])
			)));

			$insurance[] = $this->Form->label('insurance', __d('shop', 'Shipping option insurance'));
			foreach ($this->request->data['ShopShippingMethodValue']['insurance'] as $k => $rate) {
				$insurance[] = $this->Html->tag('div', implode('', array(
					$this->Form->input('limit', array_merge($smallField, array(
						'name' => sprintf('data[ShopShippingMethodValue][insurance][%s][limit]', $k),
						'value' => $rate['limit'],
						'placeholder' => __d('shop', 'Limit (g)')
					))),
					$this->Form->input('limit', array_merge($smallField, array(
						'name' => sprintf('data[ShopShippingMethodValue][insurance][%s][rate]', $k),
						'value' => $rate['rate'],
						'placeholder' => __d('shop', 'Rate ($)')
					))),
					$this->Image->image('actions', 'remove', array('url' => $this->here . '#', 'class' => 'rate remove'))
				)), array('class' => 'tiny'));
			}
			$insurance[] = $this->Image->image('actions', 'add', array(
				'url' => $this->here . '#', 
				'class' => 'rate add',
				'data-type' => 'insurance'
			));
			$insurance[] = $this->Form->hidden('insurance_counter', array_merge($smallField, array(
				'value' => count($this->request->data['ShopShippingMethodValue']['insurance'])
			)));
		}

		$tabs = array(
			__d('shop', 'Configuration'),
			__d('shop', 'Shipping Tiers'),
			__d('shop', 'Insurance Tiers')
		);

		$contents = array(
			implode('', array(
				$this->Form->input('name'),
				$this->Form->input('surcharge'),
				$this->Form->input('delivery_time', array('label' => __d('shop', 'Estimated hours for delivery'))),
				$this->Form->input('total_minimum', array('label' => __d('shop', 'Order minimum to use this shipping option'))),
				$this->Form->input('total_maximum', array('label' => __d('shop', 'Order minimum to use this shipping option'))),
				$this->Form->input('require_login', array('label' => __d('shop', 'Only available to members'))),
				$this->Form->input('active'),
			)),
			implode('', $rates),
			implode('', $insurance)
		);

		echo $this->Design->tabs($tabs, $contents);

	echo $this->Form->end();
