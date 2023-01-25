<?php
  include('./cal-dataBase.php');
  

  function Login(array $data)
  {
    $Data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $Errors = [];
    $Email = stripcslashes(strip_tags($Data['email']));
    $Password = htmlspecialchars($Data['password']);

    //vérifie si email existe dans la bdd
    $Email_check = checkEmail($Email);
    if (!$Email_check['status']) {
      $Errors['error'] = "Identifiants non valides transmis. Veuillez vérifier l'e-mail ou le mot de passe et réessayer.";
      return $Errors;
    } else {
      //on vérifie que le mot de passe correspond au hash
      if (password_verify($Password, $Email_check['data']['password'])) {
        $_SESSION['current_session'] = [
          'status' => 1,
          'user' => $Email_check['data'],
          'date_time' => date('Y-m-d H:i:s'),
        ];
        header("Location: ./user_session/user_cal/3-calendar.php");
      }

      if (!password_verify($Password, $Email_check['data']['password'])) {
        $Errors['error'] = "Identifiants non valides transmis. Veuillez vérifier l'e-mail ou le mot de passe et réessayer.";
        return $Errors;
      }
    }
  }

 //Vérifie si email string existe dans la base de données et renvoie un tableau qui détermine la sortie de l'opération.
  
  function checkEmail(string $email) : array
  { $_CAL = new Cal();

    $dbHandler = $_CAL->pdo;
    $statement = $dbHandler->prepare("SELECT `id`, `first_name`, `last_name`, `email`, `password` FROM `user` WHERE `email` = :email");
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if (empty($result)) {
        $response['status'] = false;
        $response['data'] = [];
        return $response;
    }

    $response['status'] = true;
    $response['data'] = $result;
    return $response;
  }
?>
