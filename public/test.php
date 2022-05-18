<?php 
require "../config.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn ->prepare("SELECT libelle FROM Produit INNER JOIN Commande ON id_produit=nom_produit INNER JOIN Client ON id_client=nom_client WHERE nom_client=".$_GET["id_nom"].";");
    $stmt->execute();
  
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data_produit = $stmt->fetchAll();
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
echo "<h1>Cette utilisateur à commander :</h1><br></br>";


?>
<div class="liste">
  <?php
foreach ($data_produit as $key) {
  echo "<br></br>";
  echo "🚀 ".$key['libelle'];
}
  ?>
</div>

