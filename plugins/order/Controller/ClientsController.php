<?php
	class ClientsController extends OrderAppController {
		public $uses = false;

		public function index(){
			$this->loadModel('Order.Order');
			$pendingOrders = $this->Order->getPendingOrders($this->Auth->user('id'));
			$this->set(compact('pendingOrders'));
		}

		public function addresses(){
			$this->loadModel('Management.Address');
			$addresses = $this->Address->getAddressByUser($this->Auth->user('id'), 'all');
			$this->set(compact('addresses'));
		}
	}