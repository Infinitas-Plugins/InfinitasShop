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

    echo $this->Form->create('Cart', array('url' => array('action' => 'mass')));

	echo $this->Infinitas->adminIndexHead($filterOptions);
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
                    $this->Paginator->sort('User.name', __d('shop', 'User')),
                    $this->Paginator->sort('Product.name', __d('shop', 'Product')),
                    $this->Paginator->sort('quantity'),
                    $this->Paginator->sort('price'),
                    $this->Paginator->sort('sub_total'),
                    $this->Paginator->sort('created') => array(
                        'style' => 'width:100px;'
                    ),
                    $this->Paginator->sort('deleted_date') => array(
                        'style' => 'width:150px;'
                    )
                )
            );

            $i = 0;
            foreach ($carts as $cart){
                ?>
                	<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
                        <td><?php echo $this->Infinitas->massActionCheckBox($cart); ?>&nbsp;</td>
						<td>
							<?php
								echo $this->Html->link(
									$cart['User']['username'],
									array(
										'plugin' => 'management',
										'controller' => 'users',
										'action' => 'edit',
										$cart['User']['id']
									)
								);
							?>
						</td>
						<td>
							<?php
								echo $this->Html->link(
									$cart['Product']['name'],
									array(
										'plugin' => 'shop',
										'controller' => 'products',
										'action' => 'edit',
										$cart['Product']['id']
									)
								);
							?>
						</td>
						<td>
							<?php echo $cart['Cart']['quantity']; ?>
						</td>
						<td>
							<?php echo $this->Shop->currency($cart['Cart']['price']); ?>
						</td>
						<td>
							<?php echo $this->Shop->currency($cart['Cart']['sub_total']); ?>
						</td>
						<td>
							<?php echo $this->Time->niceShort($cart['Cart']['created']); ?>
						</td>
						<td>
							<?php echo $this->Time->timeAgoInWords($cart['Cart']['deleted_date']); ?>
						</td>
                	</tr>
                <?php
            }
        ?>
    </table>
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>