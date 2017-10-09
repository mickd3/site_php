<?php
	class BDD{
		private $user;
		private $password;
		private $host;
		private $bd_name;

		public function __construct($_user,$_password,$_host,$_bd_name){
			$this->setUser($_user);
			$this->setPassword($_password);
			$this->setHost($_host);
			$this->setBd_name($_bd_name);
		}

		public function setUser($_user){
			$this->user = $_user;
		}

		public function setPassword($_password){
			$this->password = $_password;
		}

		public function setHost($_host){
			$this->host = $_host;
		}

		public function setBd_name($_bd_name){
			$this->bd_name = $_bd_name;
		}

		public function connexion(){
			try{
				$dsn = 'mysql:host='.$this->host.';port=3306;dbname='.$this->bdname.'';
				$pdo = new PDO($dsn, $this->user, $this->password);
			}
			catch (Exception $e){
				die('Erreur : ' . $e->getMessage());
			}
		}

		public function select($_attribut,$_table,$_condition){
			if($_condition == ""){
				$requete = "SELECT ".$_attribut." FROM ".$_table;
			}
			else{
				$requete = "SELECT ".$_attribut." FROM ".$_table." WHERE ".$_condition;
			}

			$stmt = $pdo->query($requete);
			$res = $stmt->fetch();

			return $res;
		}

	}
?>