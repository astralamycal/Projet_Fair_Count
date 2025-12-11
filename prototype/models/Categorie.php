<?php
class categorie{
    public function __construct(private string $nom, private ? int $id = null){
    }

    public function getId(): int{
        return $this->id;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function setNom(string $nom): void{
        $this->nom = $nom;
    }
}