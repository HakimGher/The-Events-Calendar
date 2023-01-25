<html lang="en">
<head>
    <?php
  require_once('./Signup.php');
  if (isset($_POST) && count($_POST) > 0) {
        $Response = Signup($_POST);
  }
?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./user_cal/event.css">
    <script src="./eventScript.js" defer></script>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="container">
          <h1>S'inscrire</h1>
          <p>Veuillez remplir ce formulaire pour créer un compte.</p>
          <hr>

          <label class="login__label" for="firstname" ><b>Nom</b></label>
          <input class="login__input" type="text" placeholder="Entrer Nom" name="first_name" id="first_name" required>
      
        <?php if (isset($Response['first_name']) && !empty($Response['first_name'])): ?>
    <small class="alert alert-danger alert-dismissable"><?php echo $Response['first_name']; ?></small>
    <?php endif; ?>

          <label class="login__label" for="lastname" ><b>Prénom</b></label>
          <input class="login__input" type="text" placeholder="Entrer Prénom" name="last_name" id="last_name" required>

        <?php if (isset($Response['last_name']) && !empty($Response['last_name'])): ?>
    <small class="alert alert-danger alert-dismissable"><?php echo $Response['last_name']; ?></small>
    <?php endif; ?>
      

          <label class="login__label" for="email" ><b>Email</b></label>
          <input class="login__input" type="text" placeholder="Entrer Email" name="email" id="email" required>

        <?php if (isset($Response['email']) && !empty($Response['email'])): ?>
    <small class="alert alert-danger alert-dismissable"><?php echo $Response['email']; ?></small>
    <?php endif; ?>
      
          <label class="login__label" for="password"><b>Mot de passe</b></label>
          <input class="login__input" type="password" placeholder="Entrer Mot de passe" name="password" id="password" required>
            <?php if (isset($Response['password']) && !empty($Response['password'])): ?>
    <small class="alert alert-danger alert-dismissable"><?php echo $Response['password']; ?></small>
    <?php endif; ?>
          <hr>
          <p>En créant un compte, vous acceptez nos <a href="#">conditions et confidentialité.</a>.</p>
      
          <button type="submit"  class="registerbtn">S'inscrire</button>
        </div>
        
        <div class="container_signin">
          <p>Vous avez déjà un compte?
 <a href="../index.php">S'identifier</a>.</p>
        </div>
      </form>
</body>
</html>