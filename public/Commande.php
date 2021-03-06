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

  <h2>Entrer une commande</h2>
  <div class="form">
  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="adresse_livraison">Adresse</label>
    <input type="text" name="adresse_livraison" id="adresse_livraison">
    
    
  <br></br>
    <select name="nom" id="nom_client">
    <option value="">Nom du Client</option>
    <?php
    foreach ($data as $key => $value) {
        echo '<option value="' .$value['id_client'].'">'.$value['nom'].'</option>';
    }
    ?>
    </select>


    <br></br>
    <select name="libelle" id="libelle_client">
    <option value="">Produit</option>
    <?php
    foreach ($data_produit as $key => $value) {
        echo '<option value="' .$value['id_produit'].'">'.$value['libelle'].'</option>';
    }
    ?>
    </select>
    <input class="small button" type="submit" name="submit" value="Envoyer">
        
  </form>
  </div>

  <a href="index.php" class="small button">Acceuil</a>


<?php require "templates/footer.php"; ?>
