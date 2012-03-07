<?php
	class OrderAppController extends AppController {
		public $helpers = array(
			'Shop.Shop',
			'Data.Csv'
		);

		public $components = array(
			'Shop.Shop'
		);

		public function beforeFilter(){
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

		public function admin_mass() {
			$massAction = $this->MassAction->getAction($this->request->params['form']);
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

		public function save(){
			$data[$this->modelClass] = $this->data['Save'];

			if($this->{$this->modelClass}->saveAll($data[$this->modelClass])){
				$this->notice('saved');
			}

			$this->notice('not_saved');
		}
	}