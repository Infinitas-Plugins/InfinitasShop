<?php
/**
 * @brief Add some documentation for this admin_index form.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.View.admin_index
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
			__d('shop', 'Image'),
			$this->Paginator->sort('name'),
			$this->Paginator->sort('ShopProductType.name', __d('shop', 'Type')),
			$this->Paginator->sort('shop_product_count', __d('shop', 'Products')) => array(
				'style' => 'width:50px;'
			),
			$this->Paginator->sort('active') => array(
				'style' => 'width:50px;'
			),
			$this->Paginator->sort('modified') => array(
				'style' => 'width:100px;'
			),
		));

		foreach ($shopCategories as $shopCategory) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopCategory); ?>&nbsp;</td>
				<td>
					<?php
						echo $this->Html->image($shopCategory['ShopImage']['image_small'], array(
							'width' => 75
						));
					?>&nbsp;
				</td>
				<td>
					<?php
						if ($shopCategory['ShopCategory']['path_depth'] >= 1) {
							echo sprintf('<b>%s |</b> ', str_repeat('- ', $shopCategory['ShopCategory']['path_depth']));
						}
						echo $this->Html->adminQuickLink($shopCategory['ShopCategory']);
					?>&nbsp;
				</td>
				<td>
					<?php
						echo $this->Html->link($shopCategory['ShopProductType']['name'], array(
							'controller' => 'shop_product_types',
							'action' => 'view',
							$shopCategory['ShopProductType']['id']
						));
					?>&nbsp;
				</td>
				<td>
					<?php
						if(!$shopCategory['ShopCategory']['shop_product_count']) {
							$shopCategory['ShopCategory']['shop_product_count'] = '-';
						}

						echo $this->Html->link($shopCategory['ShopCategory']['shop_product_count'], array(
							'controller' => 'shop_products',
							'action' => 'index',
							'ShopCategory.id' => $shopCategory['ShopCategory']['id']
						))
					?>&nbsp;
				</td>
				<td>
					<?php
						echo $this->Infinitas->status($shopCategory['ShopCategory']['active'], array(
							'title_yes' => __d('infinitas', 'Status :: This category is enabled'),
							'title_no' => __d('infinitas', 'Status :: This category has been disabled, any ' .
								'products within this category will not be available on the front end'),
						));
					?>&nbsp;
				</td>
				<td><?php echo $this->Infinitas->date($shopCategory['ShopCategory']); ?></td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');