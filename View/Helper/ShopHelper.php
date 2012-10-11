<?php
class ShopHelper extends AppHelper {
	public $helpers = array(
		'Text',
		'Html'
	);

	public function emailLink($email, $icon = true, $options = array()) {
		if(!$icon) {
			return $this->Text->autoLinkEmails($email);
		}

		$options = array_merge($options, array(
			'escape' => false,
			'title' => $email,
			'target' => 'blank'
		));

		return $this->Html->link(
			$this->Html->image('Emails.icon.png', array(
				'width' => 24,
				'alt' => __d('shop', 'Email')
			)),
			'mailto:' . $email,
			$options
		);
	}
}