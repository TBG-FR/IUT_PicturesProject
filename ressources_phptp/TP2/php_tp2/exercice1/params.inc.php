<?php       // Fichier "params.inc.php" : Connexion BDD

$host="localhost";
$user="p1520325";
$password="11520325";
$dbname="p1520325";

function BDD_Connect()
{

global $host;
global $user;
global $password;
global $dbname;
    
    try {
        // Data Source Name
        $dsn ="mysql:host=$host;port=3306;dbname=$dbname;charset=utf8";
        /* ALTERNATIVE : $bdd->query('SET NAMES UTF8'); */
        
        // Instanciation
        $pdo = new PDO($dsn, $user, $password);
        
        return $pdo;
    }
    catch (PDOException $e) {
        die("Erreur Connexion BDD : " . $e->getMessage());
    }
}

?>