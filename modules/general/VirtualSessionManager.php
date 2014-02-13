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
			global $_SESSION;
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
		public function exists() {
			global $_SESSION;
			return isset($_SESSION['vSession'][$this->name]);
		}
		public function destroy() {
			global $_SESSION;
			unset($_SESSION['vSession'][$this->name]);
		}
		public function setAttribute($name, $value) {
			global $_SESSION;
			$_SESSION['vSession'][$this->name][$name] = $value;
		}
		public function getAttribute($name) {
			global $_SESSION;
			return $_SESSION['vSession'][$this->name][$name];
		}
		public function attributeIsset($name) {
			global $_SESSION;
			return isset($_SESSION['vSession'][$this->name][$name]);
		}
	}
?>