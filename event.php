<?php
	class Event{
		private $event_name;
		private $event_start_date;
		private $event_end_date;


		
		function __construct($event_name, $event_start_date, $event_end_date){
			$this->setName($event_name);
			$this->setStartDate($event_start_date);
			$this->setEndDate($event_end_date);
		}


		public function getName(){
			return $this->event_name;
		}
		
		public function setName($event_name){
			$this->event_name = $event_name;
		}

		public function getStartDate(){
			return $this->event_start_date;
		}
		
		public function setStartDate($event_start_date){
			$this->event_start_date = $event_start_date;
		}

		public function getEndDate(){
			return $this->event_end_date;
		}
		
		public function setEndDate($event_end_date){
			$this->event_end_date = $event_end_date;
		}

	}
?>