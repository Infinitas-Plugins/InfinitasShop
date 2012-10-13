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

$massActions = $this->Infinitas->massActionButtons(
	array(
		'add',
		'edit',
		'copy',
		'delete',
	)
);

echo $this->Infinitas->adminIndexHead($filterOptions, $massActions);
echo $this->Filter->alphabetFilter();
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
					$this->Paginator->sort('modified') => array(
						'style' => 'width:75px;'
					),
				)
			);

			foreach ($shopProductTypes as $shopProductType) { ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td><?php echo $this->Infinitas->massActionCheckBox($shopProductType); ?>&nbsp;</td>
					<td title="<?php echo $shopProductType['ShopProductType']['slug']; ?>"><?php echo $this->Html->adminQuickLink($shopProductType['ShopProductType']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopProductType['ShopProductType']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>