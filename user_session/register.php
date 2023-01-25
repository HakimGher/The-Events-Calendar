<?php
  require_once('./Signup.php');
  if (isset($_POST) && count($_POST) > 0) {
        $Response = Signup($_POST);
  }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <div class="container">
    <h1>Register</h1>
    <hr>

    <label for="firstname"><b>Nom</b></label>
    <input type="text" placeholder="Entrer Nom" name="first_name" id="first_name" required>

    <?php if (isset($Response['first_name']) && !empty($Response['first_name'])): ?>
    <small class="alert alert-danger alert-dismissable"><?php echo $Response['first_name']; ?></small>
    <?php endif; ?>

    <label for="lastname"><b>Prénom</b></label>
    <input type="text" placeholder="Entrer Prénom" name="last_name" id="last_name" required>

    <?php if (isset($Response['last_name']) && !empty($Response['last_name'])): ?>
    <small class="alert alert-danger alert-dismissable"><?php echo $Response['last_name']; ?></small>
    <?php endif; ?>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Entrer Email" name="email" id="email" required>

    <?php if (isset($Response['email']) && !empty($Response['email'])): ?>
    <small class="alert alert-danger alert-dismissable"><?php echo $Response['email']; ?></small>
    <?php endif; ?>   

    <label for="password"><b>Mot de passe</b></label>
    <input type="password" placeholder="Entrer Mot de passe" name="password" id="password" required>

    <?php if (isset($Response['password']) && !empty($Response['password'])): ?>
    <small class="alert alert-danger alert-dismissable"><?php echo $Response['password']; ?></small>
    <?php endif; ?>

    <hr>

    <button type="submit" class="registerbtn">Register</button>
  </div>

  <div class="container signin">
    <p>Vous avez déja un compte? <a href="index.php">S'identifier</a>.</p>
  </div>
</form>
    
</body>
</html>