<?php
class User{
    public function __construct(private int $id, private string $username, private string $password, private string $email, private string $role){
    }

    public function getId(): int{
        return $this->id;
    }

    public function getUsername(): string{
        return $this->username;
    }

    public function getPassword(): string{
        return $this->password;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getRole(): string{
        return $this->role;
    }

    public function setUsername(string $username): void{
        $this->username = $username;
    }

    public function setPassword(string $password): void{
        $this->password = $password;
    }

    public function setEmail(string $email): void{
        $this->email = $email;
    }

    public function setRole(string $role): void{
        $this->role = $role;
    }
}