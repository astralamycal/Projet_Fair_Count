<?php

class UserController extends AbstractController
{

    public function profile() :void
    {
        if (isset($_SESSION["id"]) && isset($_SESSION["role"]))
        {
            $this->render('member/profile.html.twig', []);
        }

        else
        {
            $this->render('auth/login.html.twig', []);
        }
    }

    public function create() :void
    {
        if ($_SESSION['role'] === 'ADMIN') 
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
                        $user = new User($_POST['username'], $_POST['email'], $hashed_password, $_POST['role']);
                        $userManager->create($user);
                        $this->list();
                    }

                    else
                    {
                        echo "Erreur : Le mot de passe ne correspond pas.";
                    }
                }

                else
                {
                    echo "Erreur : L'adresse email existe déjà.";
                }
            }
            
            else
            {
                $this->render('admin/users/create.html.twig', []);
            }
            
        }
    }

    public function update() : void
    {
        if ($_SESSION['role'] === 'ADMIN') 
        {
            $userManager = new UserManager();
            $user = $userManager->findById((int)$_GET["id"]);
            var_dump($user);

            if (isset($_POST["username"], $_POST["email"], $_POST["password"], $_POST["role"]))
            {
                $userManager->update(new User($_POST["username"], $_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["role"], (int)$_GET["id"]));
                $this->list();
            }

            else{
                $this->render('admin/users/update.html.twig', ['id' => $user->getId(), 'username' => $user->getUsername(), 'email' => $user->getEmail(), 'role' => $user->getRole()]);
            }
        }
    }

    public function delete() : void
    {
        if ($_SESSION['role'] === 'ADMIN') 
        {
            $userManager = new UserManager();
            $user = $userManager->findById($_GET['id']);
            $userManager->delete($user);
            $this->redirect("index.php?route=list");
        }
    }

    public function list() : void
    {
        if ($_SESSION['role'] === 'ADMIN') 
        {
            $userManager = new UserManager();
            $users = $userManager->findAll();
            $data = [];

            foreach ($users as $user)
            {
                $data[] = [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail()
                ];
            }

            $this->render('admin/users/index.html.twig', ['data' => $data]);
        }

        else 
        {
            $this->redirect('index.php?route=notFound');
        }
    }

    public function show() : void
    {
        if ($_SESSION['role'] === 'ADMIN') 
        {   
            $userManager = new UserManager();
            $user = $userManager->findById($_GET['id']);

            $data = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'role' => $user->getRole()
            ];

            $this->render('admin/users/show.html.twig', ['data' => $data]);
        }
    }
}
