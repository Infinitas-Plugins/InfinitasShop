<?php
	class StatusesController extends OrderAppController {
		public function admin_index() {
			$this->Paginator->settings = array(
				'order' => array(
					'Status.ordering' => 'ASC'
				)
			);

			$statuses = $this->Paginator->paginate(
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