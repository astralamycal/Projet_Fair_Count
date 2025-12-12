<?php
class RemboursementManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }

    public function create(Remboursement $remboursement) : Remboursement{
        $query = $this->db->prepare("INSERT INTO remboursements(montant, auteur, receveur, motif) VALUES(:montant, :auteur, :receveur, :motif);");
        $parameters = [
            "montant" => $remboursement->getMontant(),
            "auteur" => $remboursement->getAuteur()->getId(),
            "receveur" => $remboursement->getReceveur()->getId(),
            "motif" => $remboursement->getMotif()
        ];

        $query->execute($parameters);
    }

    public function update(Remboursement $remboursement): Remboursement{
        $query = $this->db->prepare("UPDATE users SET montant = :montant, auteur = :auteur, receveur = :receveur, motif = :motif WHERE id = :id;");
        $parameters = [
            "montant" => $remboursement->getMontant(),
            "auteur" => $remboursement->getAuteur()->getId(),
            "receveur" => $remboursement->getReceveur()->getId(),
            "id" => $remboursement->getId()
        ];

        $query->execute($parameters);
    }

    public function delete(Remboursement $remboursement): void{
        $query = $this->db->prepare("DELETE FROM users WHERE id = :id;");
        $parameters = [
            "id" => $user->getId()
        ];

        $query->execute($parameters);
    }

    public function findAll(): array{
        $userManager = new UserManager();
        $query = $this->db->prepare("SELECT * FROM users;");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $remboursements = [];

        foreach($results as $result){
            $remboursements[] = new Remboursement($result["montant"], $userManager->getById($result["auteur"]), $userManager->getById($result["receveur"],
            $result["montant"],
            $result["id"]));
        }

        return $users;
    }

    public function findById(int $id): ? Remboursement{
        $userManager = new UserManager();
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id;");
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result !== null){
            return new Remboursement($result["montant"], $userManager->getById($result["auteur"]), $userManager->getById($result["receveur"]), $result["motif"], $result["id"]);
        }
    }
}