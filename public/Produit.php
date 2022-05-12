<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "code_produit"  => $_POST['code_produit'],
      "libelle" => $_POST['libelle'],
      "prix_unitaire"  => $_POST['prix_unitaire']

    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Produit",
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

  <h2>Add a user</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="code_produit">code_produit</label>
    <input type="text" name="code_produit" id="code_produit">
    <label for="libelle">libelle</label>
    <input type="text" name="libelle" id="libelle">
    <label for="prix_unitaire">prix_unitaire</label>
    <input type="text" name="prix_unitaire" id="prix_unitaire">
    <input type="submit" name="submit" value="Submit">
    
  </form>

  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
