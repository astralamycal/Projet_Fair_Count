<?php
class Remboursement{
    public function __construct(private int $montant, private User $auteur, private User $receveur, private string $motif, private ? int $id = null){
    }

    public function getId(): int{
        return $this->id;
    }

    public function getMontant(): int{
        return $this->montant;
    }

    public function getAuteur(): User{
        return $this->auteur;
    }

    public function getReceveur(): User{
        return $this->receveur;
    }

    public function getMotif(): string{
        return $this->motif;
    }

    public function setMontant(int $montant): void{
        $this->montant = $montant;
    }

    public function setAuteur(User $auteur): void{
        $this->auteur = $auteur;
    }

    public function setReceveur(User $receveur): void{
        $this->receveur = $receveur;
    }

    public function setMotif(string $motif): void{
        $this->motif = $motif;
    }
}