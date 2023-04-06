<?php
// session_start();

class User
{
    private $id;
    public $login;
    public $password;
    public $email;
    public $id_droits;
  

    public function __construct()
    {   $this->error = "";
        try {
            $options =
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ];
            $DB_SDN = 'mysql:host=localhost;dbname=blog';
            $DB_USER = 'root';
            $DB_PASS = '';

            //on va instancier donc créer un objet PDO
            $this->bdd = new PDO($DB_SDN, $DB_USER, $DB_PASS, $options);
        } catch (PDOException $exception) {
            echo 'ERREUR :' . $exception->getMessage();
        }
    }

    public function register($login, $password, $passwordConfirm, $email, $id_droits = 1)
    // Enregistré l'utilisateur en bdd
    //ici droits 1 : reprséente le user
    {
        $this->login    = $login;
        $this->password = $password;
        $this->password = $passwordConfirm;
        $this->email    = $email;
        $this->droits   = (int)$id_droits;

        $_login = htmlspecialchars($login);
        $_password = htmlspecialchars($password);
        $_passwordConfirm = htmlspecialchars($passwordConfirm);
        $email = htmlspecialchars($email);

        $login = trim($_login);
        $passwordConfirm = trim($_passwordConfirm);
        $password = trim($_password);
        $email = trim($email);

        if (!empty($login) && !empty($password) && !empty($passwordConfirm) && !empty($email))
        {
            $infos = "SELECT * FROM utilisateurs WHERE login = :login AND email = :email";
            $result = $this->bdd->prepare($infos);
            $result->bindvalue(':login', $login);
            $result->bindvalue(':email', $email);
            $result->setFetchMode(PDO::FETCH_ASSOC); // j'utilise fetch_assoc pour récuperer les key d'un tableau associatif 
            $result->execute();
            $userData = $result->fetchAll();
            // var_dump($userData);

            if ((count($userData)) === 0)
            {
                if ($password == $passwordConfirm)
                {
                    $cost = ['cost' => 12];
                    $password = password_hash($password, PASSWORD_BCRYPT);


                    $query = "INSERT INTO utilisateurs(login, password, email, id_droits)
                            VALUES(:login, :password, :email, :id_droits)";
                    $result = $this->bdd->prepare($query);
                    $result->bindvalue(':login', $login);
                    $result->bindvalue(':password', $password);
                    $result->bindvalue(':email', $email);
                    $result->bindvalue(':id_droits', $id_droits);
                    $result->execute(array(
                        ":login" => $login,
                        ":password" => $password,
                        ":email" => $email,
                        ":id_droits" => $id_droits,

                    ));
                    header('Location:connexion.php?reg_err=success');
                }
                else
                {
                    header('Location: inscription.php?reg_err=password');
                    die();
                }
            }
            else
            {
                header('Location: inscription.php?reg_err=already');
                die();
            }
        }
    }

    public function connect($login, $password)
    // permet d'ouvrir une session à l'utilisateur 
    {
        $_login = htmlspecialchars($login);
        $_password = htmlspecialchars($password);

        $login = trim($_login);
        $password = trim($_password);

        if (!empty($login) && !empty($password))
        {
            $infos = "SELECT * FROM utilisateurs WHERE login = :login ";
            $result = $this->bdd->prepare($infos);
            $result->setFetchMode(PDO::FETCH_ASSOC); // j'utilise fetch_assoc pour récuperer les key d'un tableau associatif 
            $result->execute(array(
                ":login" => $login,
            ));
 
            $userData = $result->fetchAll();

            if (password_verify($password, $userData[0]['password']))
            {
                // header('Location: profil.php');

                $_SESSION["user"] = $userData[0];
             

               
            }
            else
            {
                header('Location: connexion.php?login_err=password');
            
            }
        }
    }

    public function disconnect()
    {

        session_start(); // demarrage de la session
        unset($_SESSION['user']);
        unset($_SESSION['user']['id']);
        session_destroy(); // on détruit la/les session(s), soit si vous utilisez une autre session, utilisez de préférence le unset()
        header('Location: connexion.php');
        die();
    }

    public function updatelogin($login)
    {
        if (isset($_SESSION['user']) && isset($login))
        {
            $this->login = $login;

            $infos2 = "SELECT * FROM utilisateurs WHERE login = :login ";
            $result2 = $this->bdd->prepare($infos2);
            $result2->setFetchMode(PDO::FETCH_ASSOC);
            $result2->execute(array(
                ":login" => $login,
            ));

            $verifyLogin = $result2->fetchAll();
            // var_dump($verifyLogin);


            if (!$verifyLogin)
            {
                $update = "UPDATE utilisateurs SET login= :login  WHERE id_utilisateurs = :id ";
                $result = $this->bdd->prepare($update);

                $result->execute(array(
                    ":id" => $_SESSION['user']['id_utilisateurs'],
                    ":login" => $login,
                ));
                
            }
            if ($login !== $_SESSION['user']['login']) {
                $update = "UPDATE utilisateurs SET login= :login  WHERE id_utilisateurs = :id ";
                $result = $this->bdd->prepare($update);
                $result->execute(array(
                    ":id" => $_SESSION['user']['id_utilisateurs'],
                    ":login" => $login,
                ));
                $_SESSION['user']['login'] = $login;

                     $_SESSION['error'] = "<p> les informations de l'utilisateurs ont bien été modifiées.</p>";
            }
            else
            {
                $_SESSION['error'] = "<p>Vous ne pouvez pas utiliser ce login, car c'est votre login actuel.</p>";
            }
        }
        
    }

    public function updateEmail($email)
    {
        if (isset($_SESSION['user']) && isset($email))
        {
            $this->email = $email;

            $infos2 = "SELECT * FROM utilisateurs WHERE email = :email ";
            $result2 = $this->bdd->prepare($infos2);
            $result2->setFetchMode(PDO::FETCH_ASSOC);
            $result2->execute(array(
                ":email" => $email,
            ));

            $verifyEmail = $result2->fetchAll();


            if (!$verifyEmail)
            {
                $update = "UPDATE utilisateurs SET email= :email  WHERE id_utilisateurs = :id ";
                $result = $this->bdd->prepare($update);

                $result->execute(array(
                    ":id" => $_SESSION['user']['id_utilisateurs'],
                    ":email" => $email,
                ));
            }
            if ($email !== $_SESSION['user']['email']) {
                $update = "UPDATE utilisateurs SET email= :email  WHERE id_utilisateurs = :id ";
                $result = $this->bdd->prepare($update);
                $result->execute(array(
                    ":id" => $_SESSION['user']['id_utilisateurs'],
                    ":email" => $email,
                ));
                $_SESSION['user']['email'] = $email;

                     $_SESSION['error-email'] = "<p> les informations de l'utilisateurs ont bien été modifiées.</p>";
            }
            else
            {
                $_SESSION['error-email'] = "<p>Vous ne pouvez pas utiliser cet email, car c'est votre email actuel ou c'est vide.</p>";
            }
        }
        
    }


    public function updatepassword($password, $passwordConfirm)
    {


            if ($password == $passwordConfirm)
            {
                $cryptedpass = password_hash($passwordConfirm, PASSWORD_BCRYPT);
                $update = "UPDATE utilisateurs SET password= :password WHERE id_utilisateurs = :id ";
                $result = $this->bdd->prepare($update);

                $result->execute(array(
                    ":id" => $_SESSION['user']['id_utilisateurs'],
                    ":password" => $cryptedpass,
                ));
                $_SESSION['error'] = "les informations de l'utilisateurs ont bien été modifiées";
            }
            else
            {
                $_SESSION['error'] = "Les mots de passes doivent être identiques.";
            }
        }
    
        
    // public function getAllInfos()
    public function getAllInfos($id)
    {
        $this->id = $id;
        // var_dump($id);
        $query = "SELECT * FROM utilisateurs WHERE id_utilisateurs = ?";
        $result = $this->bdd->prepare($query);
        // $result->bindValue(":id", $id);
        // var_dump($result);

        // $result->execute(array($_SESSION['user']['id']));
        $result->execute([$id]);
        // var_dump($result);

        $getAllInf = $result->fetch(PDO::FETCH_ASSOC);
        // var_dump($getAllInf);

        return $getAllInf;
    }

    public function getAllInfosById($byId) 
    {
        // var_dump($id);
        $query = "SELECT * FROM utilisateurs WHERE id_utilisateurs = ?";
        $result = $this->bdd->prepare($query);

        $result->execute([$byId]);
        // var_dump($result);

        $getAllInfId = $result->fetch(PDO::FETCH_ASSOC);
        return $getAllInfId;
        // var_dump($getAllInfId);
    }

    //CRUD ADMIN
    public function getUserAdmin() 
    {
        $query = "SELECT * 
                    FROM `utilisateurs` 
                    INNER JOIN droits ON utilisateurs.id_droits = droits.id";
        $result = $this->bdd->prepare($query);

        $result->execute();
        $res = $result->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function getUserAdminByID($id)
    {   
        $query = "SELECT * 
                    FROM `utilisateurs` 
                    INNER JOIN droits ON utilisateurs.id_droits = droits.id 
                    WHERE utilisateurs.id_utilisateurs = ?";
        $result = $this->bdd->prepare($query);

        $result->execute([$id]);
        // var_dump($result);

        $res = $result->fetch(PDO::FETCH_ASSOC);

        return $res;
    }
    
    public function updateUser($login, $email, $id_droits, $id)
    {   
        $this->login = $login;
        $this->email = $email; 
        $this->id_droits = $id_droits;  
        $this->id = $id;

        $query = "UPDATE utilisateurs 
                    SET login = ?, email = ?, id_droits = ? 
                    WHERE id_utilisateurs = ? ";
        $result = $this->bdd->prepare($query);
        // id_droits

        $result->execute([$login, $email, $id_droits, $id]);
    }

    public function deleteUser($id)
    {   
        $this->id = $id;
        $sql ="DELETE 
                FROM utilisateurs 
                WHERE id_utilisateurs = ?";
        // On prépare la requête
        $request = $this->bdd->prepare($sql);
        // On exécute
        $request->execute([$id]);
    }
}   

$user = new User();