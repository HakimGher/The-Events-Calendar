<?php 
    // si ca marche pas utilise absolute file paths
    require_once('../cal-dataBase.php');

    //Recoit un tableau contenant nos informations utilisateur dans le but de créer un nouvel utilisateur.

    function Signup(array $data) 
    {
        $Data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        //enregister les données filtrées
        $first_name = stripcslashes(strip_tags($Data['first_name']));
        $last_name = stripcslashes(strip_tags($Data['last_name']));
        $email = stripcslashes(strip_tags($Data['email']));
        $password = htmlspecialchars($Data['password']);
        //vecteur pour les erreurs
        $Errors = [];

        if (preg_match('/[^A-Za-z0-9_]/', $first_name)) {
            $Errors['first_name'] = "Désolé, veuillez saisir un nom valide";
        }

        if (preg_match('/[^A-Za-z0-9_]/', $last_name)) {
            $Errors['last_name'] = "Désolé, veuillez saisir un prénom valide";
        }

        //Vérifiez si l'e-mail existe...
        $emailExists = checkEmail($email);
        if ($emailExists['status']) {
            $Errors['email'] = "Désolé, cet e-mail existe déjà.";
        }

        if (strlen($password) < 7) {
            $Errors['password'] = "Désolé, utilisez un mot de passe plus fort";
        }

        if (count($Errors) > 0) {           
            $Errors['error'] = "Veuillez corriger les erreurs dans votre formulaire afin de continuer.
";
            return $Errors;
        } else {
            //créer un nouvel utilisateur
            $Data = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $password
            ];
            $registration = Register($Data);
            
            if ($registration) {
                array_pop($Data);
                $_SESSION['current_session'] = [
                    'status' => 1,
                    'user' => $Data,
                    'date_time' => date('Y-m-d H:i:s'),
                ];
                header("Location: ../index.php");
            } else {
                $Errors['error'] = "Désolé une erreur inattendue et votre compte n'a pas pu être créé. Veuillez réessayer plus tard.";
                return $Errors;
            }
        }
    }

   //Vérifie si email string existe dans la base de données et renvoie un tableau qui détermine la sortie de l'opération.

    function checkEmail(string $email) : array
    {
        $_CAL = new Cal();
        $dbHandler = $_CAL->pdo;
        $statement = $dbHandler->prepare("SELECT * FROM `user` WHERE `email` = :email");
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

    //Crée un nouvel utilisateur et renvoie un booléen indiquant l'état de l'opération

    function Register(array $data)
    {
        $_CAL = new Cal();
        $dbHandler = $_CAL->pdo;
        $statement = $dbHandler->prepare("INSERT INTO `user` (first_name, last_name, email, password, status, created_at, updated_at) VALUES (:first_name, :last_name, :email, :password, :status, :created_at, :updated_at)");
        
        //Valeurs par défaut
        $timestamps = date('Y-m-d H:i:s');
        $status = 1;
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        //Liaisons de valeurs
        $statement->bindValue(':first_name', $data['first_name'], PDO::PARAM_STR);
        $statement->bindValue(':last_name', $data['last_name'], PDO::PARAM_STR);
        $statement->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $statement->bindValue(':password', $password, PDO::PARAM_STR);
        $statement->bindValue(':status', $status, PDO::PARAM_INT);
        $statement->bindValue(':created_at', $timestamps, PDO::PARAM_STR);
        $statement->bindValue(':updated_at', $timestamps, PDO::PARAM_STR);
        
        $result = $statement->execute();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
?>