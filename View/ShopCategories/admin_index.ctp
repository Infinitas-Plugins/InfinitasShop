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

$massActions = $this->Infinitas->massActionButtons(
	array(
		'add',
		'edit',
		'toggle',
		'copy',
		'delete',

		// other methods available
		// 'unlock',
	)
);

echo $this->Infinitas->adminIndexHead($filterOptions, $massActions);
?>
<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<?php
			echo $this->Infinitas->adminTableHeader(
				array(
					$this->Form->checkbox('all') => array(
						'class' => 'first',
						'style' => 'width:25px;'
					),
					$this->Paginator->sort('name'),
					$this->Paginator->sort('ParentShopCategory.name', __d('shop', 'Parent')),
					$this->Paginator->sort('ShopProductType.name', __d('shop', 'Type')),
					$this->Paginator->sort('product_count', __d('shop', 'Products')) => array(
						'style' => 'width:50px;'
					),
					$this->Paginator->sort('active') => array(
						'style' => 'width:50px;'
					),
					$this->Paginator->sort('modified') => array(
						'style' => 'width:100px;'
					),
				)
			);

			foreach ($shopCategories as $shopCategory) { ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td><?php echo $this->Infinitas->massActionCheckBox($shopCategory); ?>&nbsp;</td>
					<td>
						<?php 
							echo $this->Html->link($shopCategory['ShopImage']['id'], array(
								'controller' => 'shop_images', 
								'action' => 'view', 
								$shopCategory['ShopImage']['id']
							));
            				if ($shopCategory['ShopCategory']['path_depth'] >= 1) {
            					echo '<b>', str_repeat('- ', $shopCategory['ShopCategory']['path_depth']), ' |</b> ';
            				}
							echo $this->Html->adminQuickLink($shopCategory['ShopCategory']); 
						?>&nbsp;
					</td>
					<td>
						<?php 
							echo $this->Html->link($shopCategory['ParentShopCategory']['name'], array(
								'controller' => 'shop_categories', 
								'action' => 'view', 
								$shopCategory['ParentShopCategory']['id']
							)); 
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
					<td><?php echo $shopCategory['ShopCategory']['product_count']; ?>&nbsp;</td>
					<td>
						<?php 
							echo $this->Infinitas->status($shopCategory['ShopCategory']['active'], array(
								'title_yes' => __d('infinitas', 'Status :: This category is enabled'),
								'title_no' => __d('infinitas', 'Status :: This category has been disabled, any ' .
									'products within this category will not be available on the front end'),
							)); 
						?>&nbsp;
					</td>
					<td><?php echo $this->Infinitas->date($shopCategory['ShopCategory']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>