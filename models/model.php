<?php
require("connect.php");

/** Classe de gestion des contacts servant de modèle
*   à notre application avec des méthodes de type CRUD
*/
class Products {
	/** Objet contenant la connexion pdo à la BD */
	private static $connexion;

	/** Constructeur établissant la connexion */
	function __construct()
	{
    $dsn="mysql:dbname=".BASE.";host=".SERVER;
    try{
			self::$connexion=new PDO($dsn,USER,PASSWD);
    }
    catch(PDOException $e){
      printf("Échec de la connexion : %s\n", $e->getMessage());
      $this->connexion = NULL;
    }
	}

	/** Récupére la liste des produits sous forme d'un tableau */
	function get_all_products()
	{
	  $sql="SELECT * from products";
	  $data=self::$connexion->query($sql);
	  return $data;
	}
}
?>