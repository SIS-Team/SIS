<?php
	/** 
	 * @file /modules/general/VirtualSessionManager.php 
	 * @brief virtuele Sessions
	 * @author Florian Buchberger
	 */
	
	/** 
	 * @def MAX_VESSIONS
	 * @brief Definiert die maximal erlaubten parallelen virtuellen Sessions
	 * 
	 * Die Standard-Wert ist 15
	 */
	define("MAX_VSESSIONS", 15);
	
	/** 
	 * @class vSession
	 * @brief Verwaltet virtuelle Session
	 */
	class vSession {
		/**
		 * 
		 */
		private $name;

		/** Konstructor
		 * @param $name	Name der Session
		 */
		public function __construct($name) {
			$this->name = $name;
		}
		
		/**
		 * @brief initialisiert das virtuelle-Session-Array und die aktuelle vSession
		 * @details prüft die Anzahl der virtuellen Sessions und löscht gegebenenfalls die älteste
		 * @throws Exception virtuelle Session existiert bereits
		 */
		public function init() {
			global $_SESSION;
			if (!isset($_SESSION['vSession']))
				$_SESSION['vSession'] = array();
			if (count($_SESSION['vSession']) > MAX_VSESSIONS)
				$this->deleteOldest();
			if (!isset($_SESSION['vSession'][$this->name])) {
				$_SESSION['vSession'][$this->name] = array();
				$_SESSION['vSession'][$this->name]['created'] = time();
				$_SESSION['vSession'][$this->name]['modified'] = time();
			} else {
				throw new Exception("session exists");
			}
		}

		/** 
		 * @brief pürft ob die virtuelle Session bereits existiert
		 * @return ob die virtuelle Session existiert
		 */
		public function exists() {
			global $_SESSION;
			return isset($_SESSION['vSession']) && isset($_SESSION['vSession'][$this->name]);
		}

		/**
		 * @brief löscht die aktuelle virtuelle Session
		 */
		public function destroy() {
			global $_SESSION;
			unset($_SESSION['vSession'][$this->name]);
		}

		/**
		 * @brief löscht das Array der virtuellen Sessions
		 */
		public function destroyAll() {
			global $_SESSION;
			unset($_SESSION['vSession']);
		}

		/**
		 * @brief setzt ein Attribut einer virtuellen Session
		 * @param $name	Name des Attributs
		 * @param $value Wert des Attributs
		 * @pre Die virtuelle Session muss initialisiert sein.
		 */
		public function setAttribute($name, $value) {
			global $_SESSION;
			if (count($_SESSION['vSession']) > MAX_VSESSIONS)
				$this->deleteOldest();
			$_SESSION['vSession'][$this->name]['modified'] = time();
			$_SESSION['vSession'][$this->name][$name] = $value;
		}

		/**
		 * @brief liest ein Attribut einer virtuellen Session
		 * @param $name Name des Attributs
		 * @return Wert des Attributs
		 * @pre Die virtuelle Session muss initialisiert sein.
		 */
		public function getAttribute($name) {
			global $_SESSION;
			return $_SESSION['vSession'][$this->name][$name];
		}

		/**
		 * @brief prüft ob ein Attribut einer virtuellen Session gesetzt ist
		 * @param $name Name des Attributs
		 * @return ob das Attribut gesetzt ist
		 * @pre Die virtuelle Session muss initialisiert sein.
		 */
		public function attributeIsset($name) {
			global $_SESSION;
			return isset($_SESSION['vSession'][$this->name][$name]);
		}

		/**
		 * @brief löscht die älteste virtuelle Session
		 */
		private function deleteOldest() {
			global $_SESSION;
			$oldestKey = false;
			$last = time() + 1;
			foreach ($_SESSION['vSession'] as $key => $value) {
				if ($value['modified'] < $last) {
					$last = $value['modified'];
					$oldestKey = $key;
				}
			}
			if (!$oldestKey)
				return;
			unset($_SESSION['vSession'][$oldestKey]);
		}
	}
?>
