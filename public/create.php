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
      "nom" => $_POST['nom'],
      "prenom"  => $_POST['prenom'],
      "adresse"     => $_POST['adresse'],
      "code_postal"       => $_POST['code_postal'],
      "ville"  => $_POST['ville']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Client",
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
<div class="form">
  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="nom">Nom</label>
    <input type="text" name="nom" id="nom">
    <label for="prenom">Prenom</label>
    <input type="text" name="prenom" id="prenom">
    <label for="adresse">Address</label>
    <input type="text" name="adresse" id="adresse">
    <label for="">Age</label>
    <input type="text" name="code_postal" id="code_postal">
    <label for="ville">Ville</label>
    <input type="text" name="ville" id="ville">
    <input type="submit" name="submit" value="Submit">
  </form>
  </div>
  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
