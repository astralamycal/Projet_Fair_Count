<?php

class AuthController extends AbstractController
{
    public function home() : void
    {
        $this->render('lien du home', []);
    }

    public function login() : void
    {
        $userManager = new UserManager();

        if (isset($_POST['email'],$_POST['password'])) 
        {
            $tempUser = $userManager->findByEmail($_POST['email']);
            
            if ($tempUser !== null)
            {
                if (password_verify($_POST['password'], $tempUser->getPassword()))
                {
                    $_SESSION["id"] = $tempUser->getId();
                    $_SESSION["role"] = $tempUser->getRole();
                    $this->render('lien du profil', []);
                }

                else
                {
                    echo "Erreur : Le mot de passe n'est pas correct.";
                    $this->render('lien du login', []);
                }
            }

            else
            {
                echo "Erreur : L'adresse email ne correspond pas.";
                $this->render('lien du login', []);
            }
        }
        
        else
        {
            $this->render('lien du login', []);
        }
    }

    public function logout() : void
    {
        session_destroy();
        $this->redirect('index.php');
    }

    public function register() : void
    {
        $userManager = new UserManager();

        if (!empty($_POST))
        {
            $clearPassword = $_POST['confirmPassword'];

            if ($userManager->findByEmail($_POST['email']) === null) 
            {
                if ($clearPassword === $_POST['password'])
                {
                    $hashed_password = password_hash($_POST['password'],PASSWORD_DEFAULT);
                    $user = new User($_POST['username'], $_POST['email'], $hashed_password, 'USER');
                    $userManager->create($user);
                    $this->render('lien du login', []);
                }

                else
                {
                    echo "Erreur : Le mot de passe n'est pas valide.";
                }
            }

            else
            {
                echo "Erreur : L'adresse email existe déjà.";
            }
        }
        
        else
        {
            $this->render('lien du register', []);
        }
        
        
    }

    public function notFound() : void
    {
        $this->render('lien page 404', []);
    }
}