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

    echo $this->Form->create('Cart', array('url' => array('plugin' => 'order', 'controller' => 'orders', 'action' => 'checkout')));
?>
<div class="table checkout">
	<h2 class="fade"><?php echo __d('shop', 'Checkout'); ?></h2>
    <table class="listing" cellpadding="0" cellspacing="0">
        <?php
            echo $this->Infinitas->adminTableHeader(
                array(
                    __d('shop', 'Product'),
                    __d('shop', 'Quantity') => array(
                        'style' => 'width:75px;'
                    ),
                    __d('shop', 'Price') => array(
                        'style' => 'width:100px;'
                    ),
                    __d('shop', 'Sub Total') => array(
                        'style' => 'width:100px;'
                    ),
                    __d('shop', 'Added') => array(
                        'style' => 'width:150px;'
                    ),
                    __d('shop', 'Actions') => array(
                        'style' => 'width:100px;'
                    )
                ),
                false
            );

            $i = 0;
            foreach ($carts as $cart) {
                ?>
                	<tr class="<?php echo $this->Infinitas->rowClass('even'); ?>">
						<td>
							<?php
								$cart['Product']['plugin'] = 'shop';
								$cart['Product']['controller'] = 'products';
								$cart['Product']['action'] = 'view';
								$eventData = $this->Event->trigger('Shop.slugUrl', array('type' => 'products', 'data' => $cart['Product']));

								echo $this->Html->link(
									$cart['Product']['name'],
									current($eventData['slugUrl'])
								);
							?>&nbsp;
						</td>
						<td>
							<?php echo $cart['Cart']['quantity']; ?>&nbsp;
						</td>
						<td>
							<?php echo $this->Shop->currency($cart['Cart']['price']); ?>&nbsp;
						</td>
						<td>
							<?php echo $this->Shop->currency($cart['Cart']['sub_total']); ?>&nbsp;
						</td>
						<td>
							<?php echo $this->Time->timeAgoInWords($cart['Cart']['created']); ?>&nbsp;
						</td>
						<td>
							<?php echo $this->Shop->cartActions($cart); ?>&nbsp;
						</td>
                	</tr>
                <?php
            }
        ?>
        <tr class="<?php echo $this->Infinitas->rowClass('even'); ?>">
			<th><?php echo __d('shop', 'Sub total');?>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><?php echo $this->Shop->currency($amounts['sub_total']); ?>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
        </tr>
        <tr class="<?php echo $this->Infinitas->rowClass('even'); ?>">
			<td><?php echo sprintf('%s (%s)', __d('shop', 'Shipping'), __d('shop', Inflector::humanize($this->Session->read('Shop.shipping_method'))));?>&nbsp;</td>
			<td colspan="2"><?php echo $this->Html->link(__d('shop', 'Change Shipping method'), array('action' => 'change_shipping_method'));?></td>
			<td><?php echo $this->Shop->currency($amounts['shipping']); ?>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
        <?php
        	if($amounts['vat'] > 0) {
        		?>
			        <tr class="<?php echo $this->Infinitas->rowClass('even'); ?>">
						<td><?php echo __d('shop', 'Tax');?>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><?php echo sprintf(__d('shop', '%s @%s'), $this->Shop->currency($amounts['vat']), $this->Number->toPercentage((int)Configure::read('Shop.vat_rate'))); ?>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
			        </tr>
        		<?php
        	}
        ?>
        <tr class="<?php echo $this->Infinitas->rowClass('even'); ?>">
			<th><?php echo __d('shop', 'Total Due');?>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><?php echo $this->Shop->currency($amounts['total_due']); ?>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
        </tr>
        <tr class="<?php echo $this->Infinitas->rowClass('even'); ?>">
			<td>
				<?php
					echo sprintf('%s %s', __d('shop', 'Ship to'), $this->Form->input('Order.address_id', array('div' => false, 'label' => false)));
				?>&nbsp;
			</td>
			<td colspan="5"><?php echo $this->Html->link(__d('shop', 'Add address'), array('plugin' => 'management', 'controller' => 'addresses', 'action' => 'add'));?></td>
        </tr>
    </table>
    <?php
    	echo $this->Form->input('Order.special_instructions', array('type' => 'textarea', 'style' => 'width:100%'));
    	echo $this->Form->hidden('Order.total', array('value' => $amounts['sub_total']));
    	echo $this->Form->hidden('Order.shipping', array('value' => $amounts['shipping']));
    	echo $this->Form->hidden('Order.shipping_method', array('value' => $this->Session->read('Shop.shipping_method')));
    	echo $this->Form->submit('Checkout');
    ?>
</div>