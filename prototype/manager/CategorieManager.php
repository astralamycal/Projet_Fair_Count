<?php
class categorieManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(Categorie $categorie): Categorie
    {
        $query = $this->db->prepare("INSERT INTO categories(nom) VALUES(:nom);");
        $parameters = [
            "nom" => $categorie->getNom()
        ];

        $query->execute($parameters);
        return $categorie;
    }

    public function update(Categorie $categorie): Categorie
    {
        $query = $this->db->prepare("UPDATE categories SET nom = :nom WHERE id = :id;");
        $parameters = [
            "nom" => $categorie->getNom(),
            "id" => $categorie->getId()
        ];

        $query->execute($parameters);
        return $categorie;
    }

    public function delete(Categorie $categorie): void
    {
        $query = $this->db->prepare("DELETE FROM categories WHERE id = :id;");
        $parameters = [
            "id" => $categorie->getId()
        ];

        $query->execute($parameters);
    }

    public function findAll(): array
    {
        $query = $this->db->prepare("SELECT * FROM categories;");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach ($results as $result) {
            $categories[] = new Categorie($result["nom"], $result["id"]);
        }

        return $categories;
    }

    public function findById(int $id): ?Categorie
    {
        $query = $this->db->prepare("SELECT * FROM categories WHERE id = :id;");
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Categorie($result["nom"], $result["id"]);
        }
        return null;
    }
}