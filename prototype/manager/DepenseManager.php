<?php
class DepenseManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }

    public function create(Depense $depense) : Depense{
        $query = $this->db->prepare("INSERT INTO depenses(categorie, montant, auteur, date, motif) VALUES(:categorie, :montant, :date, :motif, :created_at);");
        $parameters = [
            "categorie" => $depense->getCategorie()->getId(),
            "montant" => $depense->getMontant(),
            "auteur" => $depense->getAuteur()->getId(),
            "date" => $depense->getDate()->format('Y-m-d H:i:s'),
            "motif" => $depense->getmotif()
        ];

        $query->execute($parameters);
        return $user;
    }

    public function update(Depense $depense): Depense{
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
        return $user;
    }

    public function delete(Depense $depense): void{
        $query = $this->db->prepare("DELETE FROM depenses WHERE id = :id;");
        $parameters = [
            "id" => $depense->getId()
        ];

        $query->execute($parameters);
    }

    public function findAll(): array{
        $query = $this->db->prepare("SELECT * FROM depenses;");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach($results as $result){
            $users[] = new Depense($result["firstName"], $result["lastName"], $result["email"], $result["password"], new DateTime($result["created_at"]), $result["id"]);
        }

        return $users;
    }

    public function findById(int $id): Depense{
        $categorieManager = new CategorieManager();
        $userManager = new UserManager();
        $query = $this->db->prepare("SELECT * FROM depenses WHERE id = :id;");
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if(isset($result)){
            return new Depense($categorieManager->findById($result["firstName"]), $result["montant"], $userManager->findById($result["auteur"]), new DateTime($result["date"]), $result["motif"], $result["id"]);
        }
    }
}