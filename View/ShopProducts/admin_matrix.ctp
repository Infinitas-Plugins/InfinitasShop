<?php
	echo $this->Form->create(false, array('action' => 'mass'));
	echo $this->Infinitas->adminOtherHead();
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(array(
			__d('shop', 'Image') => array(
				'class' => 'medium'
			),
			__d('shop', 'Code') => array(
				'class' => 'medium'
			),
			__d('shop', 'Options'),
			__d('shop', 'Size (%s)', $this->Shop->sizeLabel()) => array(
				'class' => 'larger'
			),
			__d('shop', 'Price') => array(
				'class' => 'medium'
			),
			__d('shop', 'Markup') => array(
				'class' => 'medium'
			),
			__d('shop', 'Stock') => array(
				'class' => 'small'
			),
			__d('shop', 'Actions') => array(
				'class' => 'small'
			)
		), false);

		foreach ($shopProduct['ShopProductVariant'] as $variant) { ?>
			<tr>
				<td>
					<?php
						echo $this->Html->link($this->Html->image($variant['ShopImage']['image_thumb']), $variant['ShopImage']['image_full'], array(
							'class' => 'thickbox',
							'escape' => false
						));
					?>
				</td>
				<td>
					<?php
						$codes = Hash::extract($variant['ShopOptionVariant'], '{n}.ShopOptionValue.product_code');
						echo String::highlight($variant['product_code'], $codes, array(
							'format' => '<strong>\1</strong>'
						));
					?>&nbsp;
				</td>
				<td>
					<?php
						$rows = array();
						foreach ($variant['ShopOptionVariant'] as &$option) {
							$rows[] = $this->Html->tag('dt', $this->Html->link($option['ShopOption']['name'], array(
								'controller' => 'shop_options',
								'action' => 'edit',
								$option['ShopOption']['id']
							)));
							$rows[] = $this->Html->tag('dd', $option['ShopOptionValue']['name']);
						}
						echo $this->Html->tag('dl', implode('', $rows), array('class' => 'dl-horizontal'));
					?>&nbsp;
				</td>
				<td>
					<?php
						if (!empty($variant['ShopProductVariantSize']['id'])) {
							echo $this->Shop->size($variant['ShopProductVariantSize']);
							echo __d('shop', '%s g', ' ' . (float)$variant['ShopProductVariantSize']['product_weight']);
						} elseif (!empty($shopProduct['ShopProductVariantMaster']['ShopProductVariantSize']['id'])) {
							echo $this->Shop->size($shopProduct['ShopProductVariantMaster']['ShopProductVariantSize']);
							echo __d('shop', '%s g', ' ' . (float)$shopProduct['ShopProductVariantMaster']['ShopProductVariantSize']['product_weight']);
						} else {
							echo '-';
						}
					?>&nbsp;
				</td>
				<td><?php echo $this->Shop->adminPrice($variant['ShopProductVariantPrice']); ?>&nbsp;</td>
				<td><?php echo $this->Shop->adminMarkup($variant['ShopProductVariantPrice']); ?>&nbsp;</td>
				<td>
					<?php
						echo $this->Html->link(
							$this->Shop->stockValue($variant['ShopStockValue']),
							array(
								'controller' => 'shop_branch_stock_logs',
								'action' => 'index',
								'ShopBranchStockLog.shop_product_variant_id' => $variant['id']
							),
							array('escape' => false)
						);
					?>&nbsp;
				</td>
				<td>&nbsp;</td>
			</tr> <?php
		}
	?>
</table>