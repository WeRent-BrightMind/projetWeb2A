Site de Location – Projet WeRent

Ce projet est un site web complet de location développé en HTML, CSS, JavaScript, PHP et MySQL, destiné à simuler une plateforme où des utilisateurs peuvent publier, gérer et interagir autour d’annonces de location. Il a été réalisé dans le cadre d’un travail de groupe, chaque membre étant responsable d’un module de gestion différent. Le projet est hébergé et testé localement à l’aide de XAMPP (Apache + MySQL) et géré sous Visual Studio Code.

---

Modules du projet

Le site est structuré autour de 5 modules principaux, chacun développé par un membre du groupe :

1. Gestion des Annonces
- Les utilisateurs connectés peuvent créer, modifier et supprimer leurs propres annonces.
- Les administrateurs peuvent gérer toutes les annonces (suppression, vérification).
- Chaque annonce contient : titre, description, numéro de téléphone, localisation, type, image, catégorie.
- Jointure entre `annonce` et `categorie` via `id_categorie`.
- CRUD complet avec interface.
- Contrôle de saisie effectué en PHP.
- Actuellement, seuls les admins peuvent ajouter des images (fonctionnalité en développement pour les utilisateurs).

2. Gestion de Blog
- Les utilisateurs connectés peuvent poster des articles, commenter et liker.
- Les admins peuvent publier, surveiller ou supprimer des posts.
- Chaque post inclut : titre, description, contenu, date, image.
- Jointure entre `post` et `commentaire` via `id_post`.
- Pas de catégories : tous les posts sont affichés en liste.
- Interface fonctionnelle avec contrôle de saisie PHP.
- Images supportées (avec quelques bugs côté admin en cours de correction).

 3. Gestion d'Événements
- Permet de créer et promouvoir des événements physiques (ex: Halloween, Journées location...).
- Les admins et utilisateurs peuvent publier des événements.
- Les utilisateurs peuvent réserver une place à un événement.
- CRUD complet, interface fluide.
- Affichage des événements avec distinction entre futurs et passés.
- Jointure entre `evenement` et `reservation` via `id_evenement`.

4. Gestion des Utilisateurs
- Système d’inscription et de connexion sécurisé.
- Interface simple pour afficher et gérer les utilisateurs (côté admin).
- Authentification nécessaire pour accéder aux modules (annonce, blog, événements, etc.).
- Les données utilisateur sont protégées avec des vérifications côté serveur.
- Fonctionnalités de modification/suppression disponibles pour l’administrateur.

 5. Gestion des Réclamations
- Permet aux utilisateurs d’envoyer des réclamations.
- Chaque réclamation peut recevoir une réponse de l’administrateur.
- Jointure entre `reclamation` et `reponse` via `id_reclamation`.
- CRUD classique avec formulaire de réclamation simple et gestion par l’admin.
- Utilisé pour signaler un problème ou donner un avis sur une annonce ou un service.

---

Technologies Utilisées

- Frontend : HTML, CSS, JavaScript (sans framework)
- Backend : PHP (sans framework)
- Base de données : MySQL (via PHPMyAdmin)
- Serveur local : XAMPP (Apache & MySQL)
- Éditeur de code : Visual Studio Code

---

Sécurité et Validation

- Contrôles de saisie en PHP sur tous les formulaires.
- Authentification obligatoire pour accéder à certaines fonctionnalités.
- Gestion des sessions utilisateur.
- Le projet est fonctionnel et testé localement.

---

Membres de l’équipe

Chaque membre du groupe a développé un module spécifique :

- Med Aziz Landoulsi: Gestion des Annonces  
- Eya Barkia: Gestion de Blog  
- Sinda Dhaou : Gestion des Événements  
- Ayoub Hajri: Gestion des Utilisateurs  
- Islem Sekrani: Gestion des Réclamations


---

Statut du Projet

- [x] Développement terminé
- [x] Tests terminés localement



Installation locale

1. Cloner le projet ou le télécharger en `.zip`
2. Copier le dossier dans `htdocs` de XAMPP
3. Démarrer Apache et MySQL via le panneau de contrôle XAMPP
4. Importer la base de données via `phpMyAdmin`
5. Accéder au site via `http://localhost/andolsi2-copy/views/front`


# projetWeb2A
