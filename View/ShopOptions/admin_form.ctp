<?php
	/**
	 * @brief Add some documentation for this add form.
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

		if(empty($this->request->data['ShopOptionValue'])) {
			$this->request->data['ShopOptionValue'] = array();
		}
		$table = array();
		foreach($this->request->data['ShopOptionValue'] as $shopOptionValue) {
			$table[] = sprintf(
				'<tr class="%s"><td title="%s">%s&nbsp;</td><td>%s&nbsp;</td><td>%s&nbsp;</td><td>%s&nbsp;</td></tr>',
				$this->Infinitas->rowClass(),
				__d('shop', 'Details :: %s', $shopOptionValue['description']),
				$shopOptionValue['name'],
				$shopOptionValue['product_code'],
				$this->Infinitas->date($shopOptionValue),
				implode('', array(
					'D'
				))
			);
		}
		$table = sprintf(
			'<div class="table"><table class="listing" cellpadding="0" cellspacing="0">%s%s</table></div>',
			$this->Infinitas->adminTableHeader(array(
				__d('shop', 'Name'),
				__d('shop', 'Code') => array(
					'style' => 'width: 150px;'
				),
				__d('shop', 'Updated') => array(
					'style' => 'width: 100px;'
				),
				__d('shop', 'Actions') => array(
					'style' => 'width: 100px;'
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
				$this->Form->input('slug'),
				$this->Infinitas->wysiwyg('ShopOption.description'),
				$this->Form->input('required', array('type' => 'checkbox'))
			)),
			$table . implode('', array(
				$this->Html->tag('label', __d('shop', 'Add an option value'), array('for' => 'ShopOptionValue0Id')),
				$this->Html->tag('div', implode('', array(
					$this->Form->input('ShopOptionValue.0.id'),
					$this->Html->tag('div', implode('', array(
						$this->Form->input('ShopOptionValue.0.name', $smallField + array('placeholder' => __d('shop', 'Value name'))),
						$this->Form->input('ShopOptionValue.0.product_code', $smallField + array('placeholder' => __d('shop', 'Product Code'))),
					)), array('class' => 'smaller')),
					$this->Form->input('ShopOptionValue.0.description', array(
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
