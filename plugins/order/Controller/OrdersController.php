<?php
	class OrdersController extends OrderAppController {
		public function index() {
			$user_id = $this->Auth->user('id');

			$this->Paginator->settings = array(
				'conditions' => array(
					'Order.user_id' => $user_id
				),
				'contain' => array(
					'User',
					'Address',
					'Status'
				),
				'order' => array(
					'Status.ordering' => 'ASC'
				)
			);

			$orders = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'user_id' => $this->Order->User->find('list'),
				'status_id' => $this->Order->Status->find('list'),
				'payment_method' => array(),
				'shipping_method' => array()
			);
			$this->set(compact('orders','filterOptions'));
		}

		public function checkout() {
			$user_id = $this->Auth->user('id');
			if($user_id < 1) {
				$this->notice(
					__('You need to be logged in to checkout'),
					array(
						'redirect' => array('plugin' => 'shop', 'controller' => 'carts', 'action' => 'index')
					)
				);
			}

			$cartItems = ClassRegistry::init('Shop.Cart')->getCartData($user_id);
			if(empty($cartItems)) {
				$this->notice(
					__('You dont have any products'),
					array(
						'redirect' => array('plugin' => 'shop', 'controller' => 'products', 'action' => 'dashboard')
					)
				);
			}

			$this->data['Order']['status_id'] = $this->Order->Status->getFirst();
			$this->data['Order']['user_id'] = $user_id;
			$this->data['Order']['tracking_number'] = '';

			foreach($cartItems as $item) {
				unset($item['Cart']['created']);
				unset($item['Cart']['modified']);
				unset($item['Cart']['sub_total']);
				unset($item['Cart']['deleted']);
				unset($item['Cart']['deleted_date']);
				$this->data['Item'][] = $item['Cart'];
			}

			if($this->Order->saveAll($this->data)) {
				ClassRegistry::init('Shop.Cart')->clearCart($user_id);
				$this->notice(
					__('Your order has been completed and now requires payment'),
					array('action' => 'pay')
				);
			}

			$this->notice(
				__('Your order has been completed and now requires payment'),
				array('action' => 'pay')
			);
		}

		public function pay() {
			$orders = $this->Order->getPendingOrders($this->Auth->user('id'));
			if(empty($orders)) {
				$this->notice(
					__('It seems you do not have any orders that require payment'),
					array(
						'redirect' => true
					)
				);
			}

			$paymentMethods = Configure::read('Shop.payment_methods');
			$this->set(compact('orders', 'paymentMethods'));
		}

        public function recive_payment() {
            $this->autoRender = false;

            $something['accepted']  = $this->request->params['url']['TransactionAccepted'];
            $something['Reference'] = $this->request->params['url']['Reference'];
            $something['Amount']    = $this->request->params['url']['Amount'];

            $this->log(serialize($this->request->params['url']), 'payment');

            if (!empty($something) && $something['accepted'] == true) {
                $this->data['Payment']['order_id'] = $this->request->params['url']['Extra1'];
                $this->data['Payment']['user_id'] = $this->request->params['url']['Extra2'];
                $this->data['Payment']['payment_method_id'] = 3;
                $this->data['Payment']['amount'] = $this->request->params['url']['Amount'];

                if ($this->Payment->save($this->data)) {
                    unset( $this->data );
                    $data['Order']['id'] = $this->request->params['url']['Extra1'];
                    $data['Order']['status_id'] = 2;
                    $this->Payment->Order->save($data);
                }
            }

            if (isset($this->request->params['url']['Extra1'])) {
                $user = ClassRegistry::init( 'User.User' )->read(null, $this->request->params['url']['Extra2']);

                // @todo send email here about the payment

                $this->notice(
					__( 'Payment has been credited and items are now being processed'),
					array(
						'redirect' => array('plugin' => 'sales', 'controller' => 'orders', 'action' => 'view', $this->request->params['url']['Extra1'])
					)
				);
            }

			$this->notice(
				__('There was a problem with the payment, please contact admin'),
				array(
					'redirect' => array( 'plugin' => 'sales', 'controller' => 'orders')
				)
			);
        }

		public function admin_index() {
			$year = $month = null;
			if(isset($this->Filter->filter['Order.year'])) {
				$year  = $this->Filter->filter['Order.year'];
				unset($this->Filter->filter['Order.year']);
			}
			if(isset($this->Filter->filter['Order.month'])) {
				$month = $this->Filter->filter['Order.month'];
				unset($this->Filter->filter['Order.month']);
			}

			$conditions = array();
			if($year || $month) {
				if(!$year) {
					$year = date('Y');
				}
				if(!$month) {
					$month = date('m');
				}

				$startDate = $year.'-'.$month.'-01 00:00:00';
				$endDate   = $year.'-'.$month.'-'.date('t').' 23:59:59';
				$conditions = array('Order.created BETWEEN ? AND ?' => array($startDate, $endDate));
			}

			$this->Paginator->settings = array(
				'conditions' => $conditions,
				'contain' => array(
					'User',
					'Address',
					'Status'
				),
				'order' => array(
					'Status.ordering' => 'ASC'
				)
			);

			$orders = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$years = array_combine(range(2000, date('Y')), range(2000, date('Y')));
			rsort($years);
			$filterOptions['fields'] = array(
				'user_id' => $this->Order->User->find('list'),
				'status_id' => $this->Order->Status->find('list'),
				'payment_method' => Configure::read('Shop.payment_methods'),
				'shipping_method',
				'tracking_number',
				'year' => $years,
				'month' => array(
					'01' => 'Jan', '02' => 'Feb', '03' => 'Mar',
					'04' => 'Apr', '05' => 'May', '06' => 'Jun',
					'07' => 'Jul', '08' => 'Aug', '09' => 'Sep',
					'10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
				)
			);
			$this->set(compact('orders','filterOptions'));
		}

		public function admin_view($id = null) {
			if(!$id) {
				$this->notice('invalid');
			}

			$order = $this->Order->find(
				'first',
				array(
					'conditions' => array(
						'Order.id' => $id
					),
					'contain' => array(
						'Item' => array(
							'Product'
						),
						'Status',
						'Payment'
					)
				)
			);

			$this->set(compact('order'));
		}
	}