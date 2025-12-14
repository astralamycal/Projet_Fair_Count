<?php

class UserController extends AbstractController
{

    public function profile(): void
    {
        if (isset($_SESSION["id"], $_SESSION["role"])) {
            $categorieManager = new CategorieManager();
            $userManager = new UserManager();
            $depenseManager = new DepenseManager();
            $remboursementManager = new RemboursementManager();
            $this->render('member/profile.html.twig', ["depenses" => $depenseManager->findByName($_SESSION["id"]), "remboursements" => $remboursementManager->findByName($_SESSION["id"])]);
        } else {
            $this->render('auth/login.html.twig', []);
        }
    }

    public function create(): void
    {
        if ($_SESSION['role'] === 'ADMIN') {
            $userManager = new UserManager();

            if (!empty($_POST)) {
                $clearPassword = $_POST['confirmPassword'];

                if ($userManager->findByEmail($_POST['email']) === null) {
                    if ($clearPassword === $_POST['password']) {
                        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                        $user = new User($_POST['username'], $_POST['email'], $hashed_password, $_POST['role']);
                        $userManager->create($user);
                        $this->list();
                    } else {
                        echo "Erreur : Le mot de passe ne correspond pas.";
                    }
                } else {
                    echo "Erreur : L'adresse email existe déjà.";
                }
            } else {
                $this->render('admin/users/create.html.twig', []);
            }

        }
    }

    public function update(): void
    {
        if ($_SESSION['role'] === 'ADMIN') {
            $userManager = new UserManager();
            $user = $userManager->findById($_GET["id"]);

            if (isset($_POST["username"], $_POST["email"], $_POST["password"], $_POST["role"])) {
                $userManager->update(new User($_POST["username"], $_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["role"], $user->getId()));
                $this->list();
            } else {
                $this->render('admin/users/update.html.twig', ['id' => $_GET["id"], 'username' => $user->getUsername(), 'email' => $user->getEmail(), 'role' => $user->getRole()]);
            }
        }
    }

    public function delete(): void
    {
        if ($_SESSION['role'] === 'ADMIN') {
            $userManager = new UserManager();
            $user = $userManager->findById($_GET['id']);
            $userManager->delete($user);
            $this->redirect("index.php?route=list");
        }
    }

    public function list(): void
    {
        if ($_SESSION['role'] === 'ADMIN') {
            $userManager = new UserManager();
            $users = $userManager->findAll();
            $data = [];

            foreach ($users as $user) {
                $data[] = [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail()
                ];
            }

            $this->render('admin/users/index.html.twig', ['data' => $data]);
        } else {
            $this->redirect('index.php?route=notFound');
        }
    }

    public function show(): void
    {
        if ($_SESSION['role'] === 'ADMIN') {
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

    public function addDepense(): void
    {
        if (isset($_SESSION["id"])) {
            $depenseManager = new DepenseManager();
            $categorieManager = new CategorieManager();
            $userManager = new UserManager();

            if (!empty($_POST)) {
                if (isset($_POST['categorie_id'], $_POST['montant'], $_POST['date'], $_POST['motif'])) {
                    $categorie = $categorieManager->findById($_POST['categorie_id']);
                    $auteur = $userManager->findById($_SESSION['id']);
                    $date = new DateTime($_POST['date']);

                    $depense = new Depense($categorie, (int) $_POST['montant'], $auteur, $date, $_POST['motif']);

                    $depenseManager->create($depense);

                    $this->redirect("index.php?route=profile");
                }
            } else {
                $categories = $categorieManager->findAll();
                $this->render('member/createDepense.html.twig', ["categories" => $categories]);
            }
        } else {
            $this->render('auth/login.html.twig', []);
        }
    }

    public function updateDepense(): void
    {
        if (isset($_SESSION['id'])) {
            $depenseManager = new DepenseManager();
            $categorieManager = new CategorieManager();

            $depense = $depenseManager->findById($_GET["id"]);

            if (isset($_POST["categorie_id"], $_POST["montant"], $_POST["date"], $_POST["motif"])) {
                $categorie = $categorieManager->findById($_POST['categorie_id']);
                $auteur = $depense->getAuteur();
                $date = new DateTime($_POST['date']);

                $newDepense = new Depense($categorie, (int) $_POST["montant"], $auteur, $date, $_POST["motif"], $depense->getId());

                $depenseManager->update($newDepense);
                $this->redirect("...");
            } else {
                $categories = $categorieManager->findAll();

                $data = [
                    'id' => $depense->getId(),
                    'montant' => $depense->getMontant(),
                    'motif' => $depense->getMotif(),
                    'date' => $depense->getDate()->format('Y-m-d'),
                    'categorie_id' => $depense->getCategorie()->getId()
                ];

                $this->render('...', ['data' => $data, 'categories' => $categories]);
            }
        } else {
            $this->render('auth/login.html.twig', []);
        }
    }

    public function addRemboursement(): void
    {
        if (isset($_SESSION['id'])) {
            $remboursementManager = new RemboursementManager();
            $userManager = new UserManager();

            if (!empty($_POST)) {
                if (isset($_POST['montant'], $_POST['receveur_id'], $_POST['motif'])) {
                    $auteur = $userManager->findById($_SESSION['id']);
                    $receveur = $userManager->findById($_POST['receveur_id']);

                    $remboursement = new Remboursement((int) $_POST['montant'], $auteur, $receveur, $_POST['motif']);

                    $remboursementManager->create($remboursement);
                    $this->redirect("index.php?route=profile");
                }
            } else {
                $users = $userManager->findAll();
                $this->render('member/createRemboursement.html.twig', ["users" => $users]);
            }
        } else {
            $this->render('auth/login.html.twig', []);
        }
    }

    public function updateRemboursement(): void
    {
        if (isset($_SESSION['id'])) {
            $remboursementManager = new RemboursementManager();
            $userManager = new UserManager();

            $remboursement = $remboursementManager->findById($_GET["id"]);

            if (isset($_POST["montant"], $_POST["receveur_id"], $_POST["motif"])) {
                $auteur = $remboursement->getAuteur();
                $receveur = $userManager->findById($_POST["receveur_id"]);

                $newRemboursement = new Remboursement((int) $_POST["montant"], $auteur, $receveur, $_POST["motif"], $remboursement->getId());

                $remboursementManager->update($newRemboursement);
                $this->redirect("...");
            } else {
                $users = $userManager->findAll();

                $data = [
                    'id' => $remboursement->getId(),
                    'montant' => $remboursement->getMontant(),
                    'motif' => $remboursement->getMotif(),
                    'receveur_id' => $remboursement->getReceveur()->getId()
                ];

                $this->render('...', ['data' => $data, 'users' => $users]);
            }
        } else {
            $this->render('auth/login.html.twig', []);
        }
    }
}
