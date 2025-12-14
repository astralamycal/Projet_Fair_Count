<?php

class AuthController extends AbstractController
{
    public function home(): void
    {
        if (isset($_SESSION["id"], $_SESSION["role"])) {
            if ($_SESSION["role"] === 'ADMIN') {
                $role = $_SESSION['role'];
                $this->render('home/home.html.twig', ['role' => $role]);
            } else {
                $this->render('home/home.html.twig', []);
            }

        } else {
            $this->render('home/home.html.twig', []);
        }
    }

    public function login(): void
    {
        $userManager = new UserManager();

        if (isset($_POST['email'], $_POST['password'])) {
            $tempUser = $userManager->findByEmail($_POST['email']);

            if ($tempUser !== null) {
                if (password_verify($_POST['password'], $tempUser->getPassword())) {
                    $_SESSION["id"] = $tempUser->getId();
                    $_SESSION["role"] = $tempUser->getRole();
                    var_dump($_SESSION);
                    $this->render('member/profile.html.twig', []);
                } else {
                    echo "Erreur : Le mot de passe n'est pas correct.";
                    $this->render('auth/login.html.twig', []);
                }
            } else {
                echo "Erreur : L'adresse email ne correspond pas.";
                $this->render('auth/login.html.twig', []);
            }
        } else {
            $this->render('auth/login.html.twig', []);
        }
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('index.php');
    }

    public function register(): void
    {
        $userManager = new UserManager();

        if (!empty($_POST)) {
            $clearPassword = $_POST['confirmPassword'];

            if ($userManager->findByEmail($_POST['email']) === null) {
                if ($clearPassword === $_POST['password']) {
                    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $user = new User($_POST['username'], $_POST['email'], $hashed_password, 'USER');
                    $userManager->create($user);
                    $this->render('auth/login.html.twig', []);
                } else {
                    echo "Erreur : Le mot de passe n'est pas valide.";
                }
            } else {
                echo "Erreur : L'adresse email existe déjà.";
            }
        } else {
            $this->render('auth/register.html.twig', []);
        }


    }





    public function notFound(): void
    {
        $this->render('error/notFound.html.twig', []);
    }
}