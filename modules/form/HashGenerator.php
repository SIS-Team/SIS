<?php
	include_once(ROOT_LOCATION . "/modules/general/VirtualSessionManager.php");

	
	class HashGenerator {
		private $name;
		private $sessionName;
		private $id;
		private $hash;
		private $virtualSession;
		public function __construct($name, $id) {
			$this->name = $name;
			$this->sessionName = $name;
			$this->id = $id;
		}
		public function generate() {
			$this->virtualSession = new vSession($this->sessionName);
			for ($i = 0; $this->virtualSession->exists(); i++) {
				$this->sessionName = $this->name . $i;
				$this->virtualSession = new vSession($this->sessionName);
			}
			
			$this->virtualSession->init();
			
			$this->hash = hash("sha256", time() * rand());
			
			$this->virtualSession->setAttribute("ID", $this->id);
			$this->virtualSession->setAttribute("hash", $this->hash);
			$this->virtualSession->setAttribute("time", time());
		}
		public function printForm() {
			echo '<input type="hidden" name="sessionName" value="' . $this->sessionName . '" />';
			echo '<input type="hidden" name="hash" value="' . $this->hash . '" />';
		}
		public function check() {
			public $_POST;
			
			if (isset($_POST['sessionName']))
				$this->sessionName = $_POST['sessionName'];
				
			$this->virtualSession = new vSession($_POST['sessionName']);
			
			if (!$this->virtualSession->exists())
				throw new Exception("vSession doesn't exist");
			
			if (!$this->virtualSession->attributeIsset("ID") || 
			    ($virtualSession->getAttribute("ID") != $this->id))
				throw new Exception("invalid form id");
			
			if (!isset($_POST['hash']) || $this->virtualSession->getAttribute("hash") != $_POST['hash'])
				throw new Exception("invalid hash");
				
			if ($this->virtualSession->getAttribute("time") < time() - 60*30)
				throw new Exception("form older than 30 minutes");
				
			$this->virtualSession->destroy(); // vSession is not longer used
			
			return true;
		}
	}
	
?>
