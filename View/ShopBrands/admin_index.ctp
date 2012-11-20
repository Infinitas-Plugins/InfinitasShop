<?php
/**
 * @brief Add some documentation for this index form.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.View.index
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

echo $this->Form->create(null, array('action' => 'mass'));
echo $this->Infinitas->adminIndexHead($filterOptions, array(
	'add',
	'edit',
	'toggle',
	'copy',
	'delete'
));
echo $this->Filter->alphabetFilter();
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(array(
			$this->Form->checkbox('all') => array(
				'class' => 'first'
			),
			$this->Paginator->sort('name'),
			$this->Paginator->sort('shop_product_count', __d('shop', 'Products')) => array(
				'style' => 'width:50px;'
			),
			$this->Paginator->sort('active') => array(
				'style' => 'width:50px;'
			),
			$this->Paginator->sort('modified') => array(
				'style' => 'width:75px;'
			),
		));

		foreach ($shopBrands as $shopBrand) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopBrand); ?>&nbsp;</td>
				<td>
					<?php
						echo sprintf('%s<br/>%s',
							$this->Html->image($shopBrand['ShopBrand']['image_thumb'], array('width' => 75)),
							$this->Html->adminQuickLink($shopBrand['ShopBrand'])
						);
					?>&nbsp;
				</td>
				<td>
					<?php
						if(empty($shopBrand['ShopBrand']['shop_product_count'])) {
							$shopBrand['ShopBrand']['shop_product_count'] = '-';
						}
						echo $this->Html->link($shopBrand['ShopBrand']['shop_product_count'], array(
							'controller' => 'shop_products',
							'action' => 'index',
							'ShopProduct.shop_brand_id' => $shopBrand['ShopBrand']['id']
						))
					?>&nbsp;
				</td>
				<td><?php echo $this->Infinitas->status($shopBrand['ShopBrand']['active']); ?>&nbsp;</td>
				<td><?php echo $this->Infinitas->date($shopBrand['ShopBrand']); ?></td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');