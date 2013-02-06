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
			echo $this->Infinitas->adminTableHeader(
				array(
					$this->Form->checkbox('all') => array(
						'class' => 'first',
					),
					$this->Paginator->sort('ShopAttribute.name', 'ShopAttribute'),
					$this->Paginator->sort('ShopProduct.name', 'ShopProduct'),
				)
			);

			foreach ($shopProductAttributes as $shopProductAttribute) { ?>
				<tr>
					<td><?php echo $this->Infinitas->massActionCheckBox($shopProductAttribute); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($shopProductAttribute['ShopAttribute']['name'], array('controller' => 'shop_attributes', 'action' => 'view', $shopProductAttribute['ShopAttribute']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($shopProductAttribute['ShopProduct']['name'], array('controller' => 'shop_products', 'action' => 'view', $shopProductAttribute['ShopProduct']['id'])); ?>
					</td>
				</tr><?php
			}
		?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');