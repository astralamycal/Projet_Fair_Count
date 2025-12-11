un user peut:
- créer un compte
- se connecter
- créer une dépense
- catégoriser une dépense (categorie dépense)
- indiquer qui est concerné par dépense (dépense a un attribut auteur)
- indiquer remboursement (objet qui contient au moins auteur, receveur et montant)
- savoir qui doit combien à qui

liste des catégories:
- Transport
- Logement
- Nourriture
- Sorties

il faut avoir un export de la base dans les fichiers (dossier data)

faire un schéma de la base (capture d'écran my sql)

css en dernier (un fichier css par page + un fichier commun)

se référer au cours mvc / page de projet pour respecter la MVC

un fichier répartition des taches .md

un fichier .env pour les infos de base de données 

utiliser l'autoload de composer

chacun travaille sur les quatres languages

if dans le html pour accèder au page admin si compte admin

page 404

findById et findByEmail → UserManager (utile pour les controllers)


Liste des pages du site :

Admin :

- index
- create
- update
- show → show_depense / show_refund

User :

- home
- profile
- login
- register
- create_depense
- create_refund
- show_depense
- show_refund
- 404