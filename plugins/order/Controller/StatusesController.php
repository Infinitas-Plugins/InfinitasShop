<?php
	class StatusesController extends OrderAppController {
		public function admin_index(){
			$this->paginate = array(
				'order' => array(
					'Status.ordering' => 'ASC'
				)
			);

			$statuses = $this->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'name'
			);
			$this->set(compact('statuses','filterOptions'));
		}
	}