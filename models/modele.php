<?php
require("connect.php");
abstract class Modele
{
	/** Objet contenant la connexion pdo à la BD */
	private $connexion;

	/** Constructeur établissant la connexion */
	public function __construct()
	{
		$dsn = "mysql:dbname=" . BASE . ";host=" . SERVER;
		try {
			$this->connexion = new PDO($dsn, USER, PASSWD);
		} catch (PDOException $e) {
			printf("Échec de la connexion : %s\n", $e->getMessage());
			$this->connexion = NULL;
		}
	}

	protected function executerRequete($sql)
	{
		$data = $this->connexion->query($sql);
		return $data;
	}
}