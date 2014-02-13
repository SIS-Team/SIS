<?php
	/* /modules/general/VirtualSessionManager.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.1
	 * Beschreibung:
	 *	Zum Erstellen Virtueller Sessions
	 *
	 */
	 
	class vSession {
		private $name;
		public function __construct($name) {
			$this->name = $name;
		}
		public function init() {
			if (!isset($_SESSION['vSession']))
				$_SESSION['vSession'] = array();
			if (!isset($_SESSION['vSession'][$this->name])) {
				$_SESSION['vSession'][$this->name] = array();
				$_SESSION['vSession'][$this->name]['created'] = time();
				$_SESSION['vSession'][$this->name]['modified'] = time();
			} else {
				throw new Exception("session exists");
			}
		}
		public function setAttribute($name, $value) {
			$_SESSION['vSession'][$this->name][$name] = $value;
		}
		public function getAttribute($name) {
			return $_SESSION['vSession'][$this->name][$name];
		}
		public function attributeIsset($name) {
			return isset($_SESSION['vSession'][$this->name][$name]);
		}
	}
?>