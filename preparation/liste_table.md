liste table :
- users
    - id (int A.I)
    - username (varchar 255)
    - password (varchar 255)
    - email (varchar 255)
    - role (varchar 255)

- depenses
    - id (int A.I)
    - categorie (foreign key --> categorie.id)
    - montant (int)
    - auteur ((foreign key --> users.id))
    - date (datetime)
    - motif (varchar 1024)

- categorie
    - id (int A.I)
    - nom (varchar 255)


- remboursement
    - id (int A.I)
    - montant (int)
    - date (datetime)
    - auteur (foreign key --> users.id)
    - receveur (foreign key --> users.id)
    - motif (varchar 1024)