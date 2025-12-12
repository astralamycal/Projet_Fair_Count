<?php
class Depense
{
    public function __construct(private Categorie $categorie, private int $montant, private User $auteur, private DateTime $date, private string $motif, private ?int $id = null)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategorie(): Categorie
    {
        return $this->categorie;
    }

    public function getMontant(): int
    {
        return $this->montant;
    }

    public function getAuteur(): User
    {
        return $this->auteur;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getMotif(): string
    {
        return $this->motif;
    }

    public function setCategory(Categorie $categorie): void
    {
        $this->categorie = $categorie;
    }

    public function setMontant(int $montant): void
    {
        $this->montant = $montant;
    }

    public function setAuteur(User $auteur): void
    {
        $this->auteur = $auteur;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    public function setMotif(string $motif): void
    {
        $this->motif = $motif;
    }
}