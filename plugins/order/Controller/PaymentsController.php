<?php
	class PaymentsController extends OrderAppController {
		public function admin_index(){
			$this->Paginator->settings = array(
				'fields' => array(
				),
				'contain' => array(
					'Order',
					'User'
				)
			);

			$payments = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'order_id' => $this->Payment->Order->find('list'),
				'user_id' => $this->Payment->User->find('list')
			);
			$this->set(compact('payments','filterOptions'));
		}

		public function admin_add(){
			parent::admin_add();

			$orders = $this->Payment->Order->find('list');
			$users = $this->Payment->User->find('list');
			$this->set(compact('orders', 'users'));
		}
	}