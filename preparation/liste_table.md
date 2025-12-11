liste table :
- users
    - username (varchar 255)
    - email (varchar 255)
    - password (varchar 255)
    - role (varchar 255)
    - id (int A.I)

- depenses
    - categorie (foreign key --> categorie.id)
    - montant (int)
    - auteur ((foreign key --> users.id))
    - date (datetime)
    - motif (varchar 1024)
    - id (int A.I)

- categorie
    - nom (varchar 255)
    - id (int A.I)


- remboursement
    - montant (int)
    - date (datetime)
    - auteur (foreign key --> users.id)
    - receveur (foreign key --> users.id)
    - motif (varchar 1024)
    - id (int A.I)