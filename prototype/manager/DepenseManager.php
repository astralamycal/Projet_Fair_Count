<?php
class DepenseManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(Depense $depense): Depense
    {
        $query = $this->db->prepare("INSERT INTO depenses(categorie, montant, auteur, date, motif) VALUES(:categorie, :auteur, :montant, :date, :motif);");
        $parameters = [
            "categorie" => $depense->getCategorie()->getId(),
            "montant" => $depense->getMontant(),
            "auteur" => $depense->getAuteur()->getId(),
            "date" => $depense->getDate()->format('Y-m-d H:i:s'),
            "motif" => $depense->getmotif()
        ];

        $query->execute($parameters);
        return $depense;
    }

    public function update(Depense $depense): Depense
    {
        $query = $this->db->prepare("UPDATE depenses SET categorie = :categorie, montant = :montant, auteur = :auteur, date = :date, motif = :motif WHERE id = :id;");
        $parameters = [
            "categorie" => $depense->getCategorie(),
            "montant" => $depense->getMontant(),
            "auteur" => $depense->getAuteur()->getId(),
            "date" => $depense->getDate()->format('Y-m-d H:i:s'),
            "motif" => $depense->getmotif(),
            "id" => $depense->getId()
        ];

        $query->execute($parameters);
        return $depense;
    }

    public function delete(Depense $depense): void
    {
        $query = $this->db->prepare("DELETE FROM depenses WHERE id = :id;");
        $parameters = [
            "id" => $depense->getId()
        ];

        $query->execute($parameters);
    }

    public function findAll(): array
    {
        $categorieManager = new CategorieManager();
        $userManager = new UserManager();
        $query = $this->db->prepare("SELECT * FROM depenses;");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $depenses = [];

        foreach ($results as $result) {
            $depenses[] = new Depense($categorieManager->findById($result["categorie"]), $result["montant"], $userManager->findById($result["auteur"]), new DateTime($result["date"]), $result["motif"], $result["id"]);
        }

        return $depenses;
    }

    public function findById(int $id): ?Depense
    {
        $categorieManager = new CategorieManager();
        $userManager = new UserManager();
        $query = $this->db->prepare("SELECT * FROM depenses WHERE id = :id;");
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Depense($categorieManager->findById($result["categorie"]), $result["montant"], $userManager->findById($result["auteur"]), new DateTime($result["date"]), $result["motif"], $result["id"]);
        }
        return null;
    }

    public function findByName(int $id): array
    {
        $categorieManager = new CategorieManager();
        $userManager = new UserManager();
        $query = $this->db->prepare("SELECT * FROM depenses WHERE auteur = :id;");
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $depenses = [];

        foreach ($results as $result) {
            $temp = new Depense($categorieManager->findById($result["categorie"]), $result["montant"], $userManager->findById($result["auteur"]), new DateTime($result["date"]), $result["motif"], $result["id"]);
            $depenses[] = $temp->toArray();
        }

        return $depenses;
    }
}