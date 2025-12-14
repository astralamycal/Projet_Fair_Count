<?php
class RemboursementManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create(Remboursement $remboursement): Remboursement
    {
        $query = $this->db->prepare("INSERT INTO remboursements(montant, auteur, receveur, motif) VALUES(:montant, :auteur, :receveur, :motif);");
        $parameters = [
            "montant" => $remboursement->getMontant(),
            "auteur" => $remboursement->getAuteur()->getId(),
            "receveur" => $remboursement->getReceveur()->getId(),
            "motif" => $remboursement->getMotif()
        ];

        $query->execute($parameters);
        return $remboursement;
    }

    public function update(Remboursement $remboursement): Remboursement
    {
        $query = $this->db->prepare("UPDATE remboursements SET montant = :montant, auteur = :auteur, receveur = :receveur, motif = :motif WHERE id = :id;");
        $parameters = [
            "montant" => $remboursement->getMontant(),
            "auteur" => $remboursement->getAuteur()->getId(),
            "receveur" => $remboursement->getReceveur()->getId(),
            "id" => $remboursement->getId()
        ];

        $query->execute($parameters);
        return $remboursement;
    }

    public function delete(Remboursement $remboursement): void
    {
        $query = $this->db->prepare("DELETE FROM remboursements WHERE id = :id;");
        $parameters = [
            "id" => $remboursement->getId()
        ];

        $query->execute($parameters);
    }

    public function findAll(): array
    {
        $userManager = new UserManager();
        $query = $this->db->prepare("SELECT * FROM remboursements;");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $remboursements = [];

        foreach ($results as $result) {
            $remboursements[] = new Remboursement($result["montant"], $userManager->findById($result["auteur"]), $userManager->findById($result["receveur"]), $result["motif"], $result["id"]);
        }

        return $remboursements;
    }

    public function findById(int $id): ?Remboursement
    {
        $userManager = new UserManager();
        $query = $this->db->prepare("SELECT * FROM remboursements WHERE id = :id;");
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Remboursement($result["montant"], $userManager->findById($result["auteur"]), $userManager->findById($result["receveur"]), $result["motif"], $result["id"]);
        }
    }

    public function findByName(int $id): array
    {
        $userManager = new UserManager();
        $query = $this->db->prepare("SELECT * FROM remboursements WHERE auteur = :id;");
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $remboursements = [];

        foreach ($results as $result) {
            $remboursements[] = new Remboursement($result["montant"], $userManager->findById($result["auteur"]), $userManager->findById($result["receveur"]), $result["motif"], $result["id"]);
        }

        $query = $this->db->prepare("SELECT * FROM remboursements WHERE receveur = :id;");
        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
            $remboursements[] = new Remboursement($result["montant"], $userManager->findById($result["auteur"]), $userManager->findById($result["receveur"]), $result["motif"], $result["id"]);
        }

        return $remboursements;
    }
}