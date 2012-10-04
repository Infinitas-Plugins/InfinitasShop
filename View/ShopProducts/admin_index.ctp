<?php
    /**
     * Comment Template.
     *
     * @todo -c Implement .this needs to be sorted out.
     *
     * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @filesource
     * @copyright     Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     * @link          http://infinitas-cms.org
     * @package       sort
     * @subpackage    sort.comments
     * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
     * @since         0.5a
     */

    echo $this->Form->create('Product', array('url' => array('action' => 'mass')));

    $massActions = $this->Infinitas->massActionButtons(
        array(
            'add',
            'edit',
            'copy',
            'toggle',
            'move',
            'delete'
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
                    __d('shop', 'Image') => array(
                        'style' => 'width:100px;'
                    ),
                    $this->Paginator->sort('name'),
                    $this->Paginator->sort('ShopCategory.name', __d('shop', 'Category')),
                    $this->Paginator->sort('ShopBranch.name', __d('shop', 'Branch')),
                    $this->Paginator->sort('ShopUnit.name', __d('shop', 'ShopUnit')) => array(
                        'style' => 'width:75px;'
                    ),
                    $this->Paginator->sort('price') => array(
                        'style' => 'width:75px;'
                    ),
                    $this->Paginator->sort('Supplier.name', __d('shop', 'Supplier')) => array(
                        'style' => 'width:75px;'
                    ),
                    $this->Paginator->sort('modified') => array(
                        'style' => 'width:75px;'
                    ),
                    $this->Paginator->sort('active') => array(
                        'style' => 'width:50px;'
                    )
                )
            );

            foreach ($products as $product) {
                ?>
                	<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
                        <td><?php echo $this->Infinitas->massActionCheckBox($product); ?>&nbsp;</td>
                        <td>
							<?php
								echo $this->Html->image(
									'content/shop/global/'.$product['Image']['image'],
									array(
										'height' => '35px'
									)
								);
							?>&nbsp;
						</td>
                		<td>
                			<?php echo $this->Html->link($product['Product']['name'], array('action' => 'edit', $product['Product']['id'])); ?>&nbsp;
                		</td>
                		<td>
                			<?php echo $this->Text->toList(Set::extract('/name', $product['ShopCategory'])); ?>
                		</td>
						<td>
							<?php echo $this->Text->toList(Set::extract('/BranchDetail/name', $product['ShopBranch'])); ?>
						</td>
						<td>
                			<?php echo $this->Html->link($product['ShopUnit']['name'], array('action' => 'edit', $product['ShopUnit']['id'])); ?>&nbsp;
						</td>
						<td title="<?php echo $this->Shop->breakdown($product['Product'], $product['Special']); ?>">
							<?php echo $this->Shop->calculateSpecial($product['Product'], $product['Special']); ?>
						</td>
                		<td>
                			<?php echo $this->Html->link($product['Supplier']['name'], array('action' => 'edit', $product['Supplier']['id'])); ?>&nbsp;
                		</td>
						<td>
							<?php echo $this->Infinitas->date($product['Product']['modified']); ?>
						</td>
                		<td>
                			<?php echo $this->Infinitas->status($product['Product']['active']); ?>&nbsp;
                		</td>
                	</tr>
                <?php
            }
        ?>
    </table>
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>