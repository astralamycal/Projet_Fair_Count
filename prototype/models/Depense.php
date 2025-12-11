<?php
class Depense{
    public function __construct(private Category $category, private int $amount, private User $auteur, private DateTime $date, private string $motif, private ? int $id = null){
    }

    public function getId(): int{
        return $this->id;
    }

    public function getCategory(): Category{
        return $this->category;
    }

    public function getAmount(): int{
        return $this->amount;
    }

    public function getAuteur(): User{
        return $this->auteur;
    }

    public function getDate(): DateTime{
        return $this->date;
    }

    public function getMotif(): string{
        return $this->motif;
    }

    public function setCategory(Category $category): void{
        $this->category = $category;
    }

    public function setAmount(int $amount): void{
        $this->amount = $amount;
    }

    public function setAuteur(User $auteur): void{
        $this->auteur = $auteur;
    }

    public function setDate(DateTime $date): void{
        $this->date = $date;
    }

    public function setMotif(string $motif): void{
        $this->motif = $motif;
    }
}