<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id_client, nom FROM Client");
    $stmt->execute();
  
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data = $stmt->fetchAll();
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id_produit, libelle FROM Produit");
    $stmt->execute();
  
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data_produit = $stmt->fetchAll();
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "adresse_livraison"  => $_POST['adresse_livraison'],
      "nom_client"=> $_POST['nom'],
      "nom_produit"=> $_POST['libelle'],

    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Commande",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['firstname']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h3>Voir les commandes</h3>
<div class="form">
  <form method="post">
    
    
    
  <br></br>
    <select name="nom" id="nom_client">
    <option value="">Client</option>
    <?php
    foreach ($data as $key => $value) {
        echo '<option value="' .$value['id_client'].'">'.$value['nom'].'</option>';
    }
    ?>
    </select>


    <br></br>
   
  
  </form>
  <button onclick="getinfo()" class="small button">Voir </button>
  </div>
  <br></br>
 
  
  <br></br>
  <div id="commandes"> </div>
  <a href="index.php" class="small button">Acceuil</a>

<?php require "templates/footer.php"; ?>
