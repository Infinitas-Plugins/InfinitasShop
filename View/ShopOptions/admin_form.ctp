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

		$smallField = array('div' => false, 'error' => false, 'label' => false);

		if (empty($this->request->data['ShopOptionValue'])) {
			$this->request->data['ShopOptionValue'] = array();
		}
		$table = array();
		$k = 0;
		foreach ($this->request->data['ShopOptionValue'] as $k => $shopOptionValue) {
			$shopOptionValueForm = 'ShopOptionValue.' . $k;
			echo $this->Form->input($shopOptionValueForm . '.id', array(
				'value' => $shopOptionValue['id'],
				'type' => 'hidden'
			));
			$table[] = sprintf(
				'<tr><td title="%s">%s&nbsp;</td><td>%s&nbsp;</td><td>%s&nbsp;</td><td>%s</td><td>%s&nbsp;</td></tr>',
				__d('shop', 'Details :: %s', $shopOptionValue['description']),
				$shopOptionValue['name'],
				$this->Design->colourPicker($shopOptionValueForm . '.colour', array(
					'value' => $shopOptionValue['colour'],
					'type' => 'text',
				)),
				$this->Design->label($shopOptionValue['product_code']),
				$this->Infinitas->date($shopOptionValue),
				implode('', array(
					'D'
				))
			);
		}
		$shopOptionValueForm = 'ShopOptionValue.' . ++$k;
		$table = sprintf(
			'<table class="listing"><thead>%s</thead><tbody>%s</tbody></table>',
			$this->Infinitas->adminTableHeader(array(
				__d('shop', 'Name'),
				__d('shop', 'Colour') => array(
					'class' => 'larger'
				),
				__d('shop', 'Code') => array(
					'class' => 'large'
				),
				__d('shop', 'Updated') => array(
					'class' => 'date'
				),
				__d('shop', 'Actions') => array(
					'class' => 'large'
				)
			), false),
			implode('', $table)
		);

		$tabs = array(
			__d('shop', 'Option'),
			__d('shop', 'Values'),
			__d('shop', 'Affects')
		);

		$this->request->data['ShopOptionValue'] = array();
		$contents = array(
			implode('', array(
				$this->Form->input('name'),
				$this->Form->input('slug', array(
					'label' => __d('shop', 'Alias')
				)),
				$this->Infinitas->wysiwyg('ShopOption.description'),
				$this->Form->input('required', array('type' => 'checkbox'))
			)),
			$table . implode('', array(
				$this->Html->tag('label', __d('shop', 'Add an option value'), array('for' => 'ShopOptionValue0Id')),
				$this->Html->tag('div', implode('', array(
					$this->Form->input($shopOptionValueForm . '.id'),
					$this->Html->tag('div', implode('', array(
						$this->Form->input($shopOptionValueForm . '.name', $smallField + array('placeholder' => __d('shop', 'Value name'))),
						$this->Form->input($shopOptionValueForm . '.product_code', $smallField + array('placeholder' => __d('shop', 'Product Code'))),
						$this->Html->tag('span', $this->Design->colourPicker($shopOptionValueForm . '.colour', array(
							'value' => '',
							'type' => 'text',
							'style' => 'width: 100px'
						)))
					)), array('class' => 'smaller')),
					$this->Form->input($shopOptionValueForm . '.description', array(
						'style' => 'height: 70px;',
						'label' => false,
						'placeholder' => __d('shop', 'description')
					)),
					$this->Html->tag('div', implode(array(
						$this->Form->hidden('ShopPrice.0.id'),
						$this->Form->input('ShopPrice.0.retail', $smallField + array('placeholder' => __d('shop', 'Retail'))),
						$this->Form->input('ShopPrice.0.selling', $smallField + array('placeholder' => __d('shop', 'Selling'))),
						$this->Form->input('ShopPrice.0.cost', $smallField + array('placeholder' => __d('shop', 'Cost'))),
					)), array('class' => 'input tiny')),
					$this->Html->tag('div', implode(array(
						$this->Form->hidden('ShopSize.0.id'),
						$this->Form->input('ShopSize.0.product_width', $smallField + array('placeholder' => __d('shop', 'Width (mm)'))),
						$this->Form->input('ShopSize.0.product_length', $smallField + array('placeholder' => __d('shop', 'Length (mm)'))),
						$this->Form->input('ShopSize.0.product_height', $smallField + array('placeholder' => __d('shop', 'Height (mm)'))),
						$this->Form->input('ShopSize.0.product_weight', $smallField + array('placeholder' => __d('shop', 'Weight (g)'))),
					)), array('class' => 'input tiny')),
					$this->Html->tag('div', implode(array(
						$this->Form->input('ShopSize.0.shipping_width', $smallField + array('placeholder' => __d('shop', 'Width (mm)'))),
						$this->Form->input('ShopSize.0.shipping_length', $smallField + array('placeholder' => __d('shop', 'Length (mm)'))),
						$this->Form->input('ShopSize.0.shipping_height', $smallField + array('placeholder' => __d('shop', 'Height (mm)'))),
						$this->Form->input('ShopSize.0.shipping_weight', $smallField + array('placeholder' => __d('shop', 'Weight (g)'))),
					)), array('class' => 'input tiny'))
				)), array('class' => 'option-value'))
			)),
			implode('', array(
				$this->Form->input('ShopProductType', array(
					'selected' => Hash::extract($this->request->data, 'ShopProductTypesOption.{n}.shop_product_type_id'),
					'multiple' => true,
					'label' => __d('shop', 'Product Types'),
					'style' => 'height: 200px'
				))
			)),
		);

		echo $this->Design->tabs($tabs, $contents);
	echo $this->Form->end();
