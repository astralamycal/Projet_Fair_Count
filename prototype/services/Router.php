<?php

class Router
{
    private AuthController $ac;
    private UserController $uc;
    public function __construct()
    {
        $this->ac = new AuthController();
        $this->uc = new UserController();
    }

    public function handleRequest() : void
    {
        if(!empty($_GET['route'])) {
            if($_GET['route'] === 'home') {
                $this->ac->home();
            }
            //else if($_GET['route'] === 'profil') {
                //$this->ac->profil();
            //}
            else if($_GET['route'] === 'login') {
                $this->ac->login();
            }
            else if($_GET['route'] === 'register') {
                $this->ac->register();
            }
            else if($_GET['route'] === 'create_depense') {
                $this->uc->create();
            }
            else if($_GET['route'] === 'create_refund') {
                $this->uc->update();
            }
            //else if($_GET['route'] === 'show_depense') {
            //    $this->uc->delete();
            //}
            //else if($_GET['route'] === 'show_refund') {
            //    $this->uc->list();
            //}

            //else if($_GET['route'] === 'index') {
            //    $this->uc->index();
            //}
            
            else if($_GET['route'] === 'create') {
                $this->uc->create();
            }
            else if($_GET['route'] === 'update') {
                $this->uc->update();
            }
            else if($_GET['route'] === 'show') {
                $this->uc->show();
            }
            else
            {
                $this->ac->notFound();
            }

            }

            else
            {
            $this->ac->home();
            }
        }
        
    }