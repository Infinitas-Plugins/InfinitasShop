<?php
	class OrderAppController extends AppController {
		public $helpers = array(
			'Shop.Shop',
			'Data.Csv'
		);

		public $components = array(
			'Shop.Shop'
		);

		function beforeFilter(){
			parent::beforeFilter();
			$data = $this->Event->trigger('loadPaymentGateways');

			$gateways = array();
			foreach($data['loadPaymentGateways'] as $gateway){
				$gateways[] = $gateway;
			}
			Configure::write('Shop.payment_methods', $gateways);
			Configure::write('Order.notify_url', 'http://'.env('SERVER_NAME').$this->webroot.'order/orders/recive_payment');
			return true;
		}

		function admin_mass() {
			$massAction = $this->MassAction->getAction($this->params['form']);
			switch(strtolower($massAction)){
				case 'export':
					$this->redirect($this->referer().'.csv');
					break;

				case 'save':
					$this->save();
					break;

				default:
					return parent::admin_mass();
					break;
			}
		}

		function save(){
			$data[$this->modelClass] = $this->data['Save'];

			if($this->{$this->modelClass}->saveAll($data[$this->modelClass])){
				$this->Infinitas->noticeSaved();
			}

			$this->Infinitas->noticeNotSaved();
		}
	}