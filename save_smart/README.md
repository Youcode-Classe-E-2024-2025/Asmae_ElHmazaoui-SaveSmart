# Asmae_ElHamzaoui-savesmart
# Application de Gestion de Budget

## Description

Application web en Laravel permettant aux utilisateurs de saisir leurs revenus et dépenses, puis de bénéficier d’une répartition automatique du budget selon la règle logique 50/30/20.

---

## Fonctionnalités

1. **Authentification :**
   - **Inscription** : Les utilisateurs peuvent créer un compte avec un formulaire d'inscription.
   - **Connexion** : Les utilisateurs peuvent se connecter avec leurs identifiants.
   - **Déconnexion** : L'utilisateur peut se déconnecter de son compte.
   - **gestion des comptes familials** : L'utilisateur peut consulter son compte familial après connexion.
   - **gestion des comptes familials** : L'utilisateur peut inviter des membres de sa famille.

2. **Gestion des transactions :**
   - **Afficher la liste des transactions** : Une vue affiche tous les transactions .
   - **Ajouter de nouvelles transactions** : L'utilisateur peut ajouter des transactions en remplissant un formulaire.
   - **Modifier ou supprimer des transactions** : Les transactions peuvent être modifiés ou supprimés selon le choix de l'utilisateur.

3. **Gestion des objectifs d'epargnes :**
    - **Afficher la liste des objectifs** : Une vue affiche tous les objectifs .
   - **Ajouter de nouveaux objectifs** : L'utilisateur peut ajouter des objectifs en remplissant un formulaire.
   - **Modifier ou supprimer des objectifs** : Les objectifs peuvent être modifiés ou supprimés selon le choix de l'utilisateur.

---

## Choix Techniques

### 1. **Framework utilisé : Laravel**
Laravel a été choisi pour cette application pour ses avantages en termes de productivité et de sécurité. Voici quelques raisons :
   - **Système d'authentification intégré** : Laravel facilite la gestion des utilisateurs, l'inscription, la connexion et la déconnexion avec des méthodes simples à configurer.
   - **Migrations et Eloquent ORM** : Laravel offre un système de migrations facile à utiliser pour gérer la base de données et un ORM performant pour interagir avec celle-ci.
   - **Blade Templates** : Le moteur de templates Blade permet de séparer la logique du front-end de la logique back-end, rendant l'application facile à maintenir.
   - **Sécurité** : Laravel inclut des fonctionnalités de sécurité par défaut telles que la protection contre les injections SQL, le hachage des mots de passe, et la validation des entrées utilisateurs.

### 2. **Base de données : PostgreSQL**
PostgreSQL a été choisi comme système de gestion de base de données en raison de ses performances et de sa compatibilité avec Laravel.

   - **Tables principales** :
     - `users` : Contient les informations des utilisateurs (nom, email, mot de passe).
     - `categories` : Contient les informations des categories.
     - `transactions` : Contient les informations sur les transactions .
     - `saving_goals` : Contient les informations sur les saving_goals .
     - `family_accounts` : Contient les informations sur les family_accounts.

### 3. **Architecture MVC**
L'application suit le modèle **MVC (Modèle-Vue-Contrôleur)** pour organiser le code de manière structurée et maintenable. Les principales composantes sont :
   - **Modèles (Models)** : Représentent les données et la logique de l'application. Exemple : `User`, `Transaction`, `Invitation`.
   - **Vues (Views)** : Les pages HTML rendues par l'utilisateur. Exemple : `index.blade.php`...
   - **Contrôleurs (Controllers)** : Gèrent la logique d'application et l'interaction entre le modèle et la vue. Exemple : `SavingGoalController`.

### 4. **Gestion des erreurs et validation**
   - Utilisation de la **validation intégrée** de Laravel pour valider les formulaires d'inscription, de connexion et d'ajout de livres.
   - Gestion des erreurs avec des messages d'erreur clairs et appropriés pour l'utilisateur.
   - Sécurisation des formulaires avec **CSRF Tokens** et protection contre les attaques XSS et SQL injection.

### 5. **Tests**
Des tests ont été écrits pour valider les fonctionnalités de l'application, y compris :
   - Tests unitaires pour les fonctions critiques du backend.
   - Tests fonctionnels pour vérifier l'intégrité du processus d'emprunt et de retour de livres.

---

## Installation

### Prérequis

- **PHP** 8.x ou supérieur
- **Composer** (gestionnaire de dépendances PHP)
- **PostgreSQL** installé et configuré

### Étapes d'installation

1. **Cloner le projet** :

   ```bash
   git clone https://github.com/Youcode-Classe-E-2024-2025/Asmae_ElHamzaoui-gestionBibliotheque
   cd  Asmae_ElHamzaoui-gestionBibliotheque


