liste table :
- users
    - id (int A.I)
    - username (varchar 255)
    - email (varchar 255)
    - password (varchar 255)
    - role (varchar 255)


- depenses
    - categorie (foreign key --> categorie.id)
    - montant (int)
    - auteur ((foreign key --> users.id))
    - date (datetime)
    - motif (varchar 1024)
    - id (int A.I)

- categorie
    - id (int A.I)
    - nom (varchar 255)
    - id (int A.I)


- remboursement
    - id (int A.I)
    - montant (int)
    - date (datetime)
    - auteur (foreign key --> users.id)
    - receveur (foreign key --> users.id)
    - motif (varchar 1024)
    - id (int A.I)