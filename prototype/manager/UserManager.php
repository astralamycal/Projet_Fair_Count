<?php
class UserManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }

    public function create(User $user) : User{
        $query = $this->db->prepare("INSERT INTO users(username, email, password, role) VALUES(:username, :email, :password, :role);");
        $parameters = [
            "username" => $user->getUsername(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "role" => $user->getRole(),
        ];

        $query->execute($parameters);
        return $user;
    }

    public function update(User $user): User{
        $query = $this->db->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email, password = :password, created_at = :created_at WHERE id = :id;");
        $parameters = [
            "id" => $user->getId(),
            "username" => $user->getUsername(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "role" => $user->getRole(),
        ];

        $query->execute($parameters);
        return $user;
    }

    public function delete(user $user): void{
        $query = $this->db->prepare("DELETE FROM users WHERE id = :id;");
        $parameters = [
            "id" => $user->getId()
        ];

        $query->execute($parameters);
    }

    public function findAll(): array{
        $query = $this->db->prepare("SELECT * FROM users;");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach($results as $result){
            $users[] = new User($result["firstName"], $result["lastName"], $result["email"], $result["password"], new DateTime($result["created_at"]), $result["id"]);
        }

        return $users;
    }

    public function findOne(int $id): User{
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id;");
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if(isset($result)){
            return new User($result["firstName"], $result["lastName"], $result["email"], $result["password"], new DateTime($result["created_at"]), $result["id"]);
        }
    }
}