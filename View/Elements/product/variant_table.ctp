<table class="listing">
	<thead>
		<tr>
			<th><?php echo __d('shop', 'Product code'); ?></th>
			<th><?php echo __d('shop', 'Options'); ?></th>
			<th><?php echo __d('shop', 'Size'); ?></th>
			<th><?php echo __d('shop', 'Price'); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<?php
		foreach ($shopProduct['ShopProductVariant'] as $k => &$variant) { ?>
			<tr>
				<td><?php echo $variant['product_code']; ?>&nbsp;</td>
				<td>
					<?php
						$rows = array();
						if (count($variant['ShopOptionVariant']) < 2) {
							if (empty($variant['ShopOptionVariant'][0])) {
								$variant['ShopOptionVariant'][0]['ShopOptionValue']['name'] = '-';
							}
							echo $variant['ShopOptionVariant'][0]['ShopOptionValue']['name'];
						} else {
							foreach ($variant['ShopOptionVariant'] as $option) {
								$rows[] = $this->Html->tag('dt', $option['ShopOption']['name']);
								$rows[] = $this->Html->tag('dd', $option['ShopOptionValue']['name']);
							}
							echo $this->Html->tag('dl', implode('', $rows), array('class' => 'dl-horizontal'));
						}
					?>&nbsp;
				</td>
				<td><?php echo $this->Shop->size($variant['ShopProductVariantSize']); ?>&nbsp;</td>
				<td><?php echo $this->Shop->price($variant['ShopProductVariantPrice']); ?>&nbsp;</td>
				<td>
					<?php
						$formInput = 'ShopProductVariant.' . $k;
						echo $this->Form->input($formInput . '.id', array(
							'type' => 'hidden',
							'value' => $variant['id']
						));
						echo $this->Form->input($formInput . '.quantity', array(
							'value' => 0,
							'class' => 'quantity',
							'div' => false,
							'label' => false,
							'type' => 'number',
							'step' => $shopProduct['ShopProduct']['quantity_unit'],
							'min' => $shopProduct['ShopProduct']['quantity_min'],
							'max' => $shopProduct['ShopProduct']['quantity_max'],
						));
					?>
				</td>
			</tr> <?php
		}
	?>
	<tr>
		<td colspan="100">
			<?php
				echo $this->Form->button(__d('shop', 'Add to cart'), array(
					'class' => 'pull-right btn btn-small add-to-cart'
				));
			?>
		</td>
	</tr>
</table>