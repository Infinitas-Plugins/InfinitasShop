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
	'delete',
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
			$this->Paginator->sort('active') => array(
				'style' => 'width:75px;'
			),
			$this->Paginator->sort('modified') => array(
				'style' => 'width:100px;'
			),
		));

		foreach ($shopProductTypes as $shopProductType) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopProductType); ?>&nbsp;</td>
				<td><?php echo $this->Html->adminQuickLink($shopProductType['ShopProductType']); ?>&nbsp;</td>
				<td>
					<?php
						echo $this->Infinitas->status($shopProductType['ShopProductType']['active'], array(
							'title_yes' => __d('shop', 'Active :: The product type is active'),
							'title_no' => __d('shop', 'Inactive :: Products of this type will not be available for purchase')
						));
					?>&nbsp;
				</td>
				<td><?php echo $this->Infinitas->date($shopProductType['ShopProductType']); ?></td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');