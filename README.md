# WR506D-BACK 📄

## Microservice - WebApp 🌐

### Description ℹ️
WR506D-BACK est un microservice développé pour gérer la génération et la gestion de PDF dans le cadre d'une application web. Il permet aux utilisateurs de créer des PDF à partir d'URL ou de fichiers HTML et de gérer leurs PDF générés précédemment.

### Fonctionnalités 🚀

1. **Génération de PDF :** Les utilisateurs peuvent générer des PDF à partir d'URL ou de fichiers HTML.
2. **Gestion des utilisateurs :** Le microservice est intégré à un système d'authentification qui restreint l'accès aux fonctionnalités aux utilisateurs connectés.
3. **Gestion des abonnements :** Les utilisateurs disposant d'un abonnement peuvent avoir des limites sur le nombre de PDF qu'ils peuvent générer.
4. **Historique des PDF :** Le microservice permet aux utilisateurs de consulter l'historique de leurs PDF générés précédemment.
5. **Suppression de PDF :** Les utilisateurs peuvent supprimer des PDF de leur historique.

### Installation ⚙️

1. **Prérequis :**
   - PHP 7.4 ou supérieur
   - Composer
   - Symfony CLI
   - MySQL ou autre système de gestion de base de données

2. **Clonage du dépôt :**
git clone https://github.com/Camelllll/WR602D-WEBAPP.git

3. **Installation des dépendances :**
cd WR506D-BACK
composer install

4. **Configuration de la base de données :**
- Créez une base de données MySQL nommée wr506d_back
- Copiez le fichier .env.example et renommez-le en .env
- Modifiez le fichier .env pour ajouter vos informations de base de données

5. **Migration de la base de données :**
php bin/console doctrine:migrations

6. **Démarrage du serveur :**
symfony serve


7. **Accès à l'application :**
Ouvrez votre navigateur et accédez à http://localhost:8000 pour utiliser l'application.

### Structure du projet 📁

- **config/** : Contient les fichiers de configuration Symfony.
- **public/** : Contient le point d'entrée de l'application et les ressources publiques.
- **src/** : Contient le code source de l'application.
- **Controller/** : Contient les contrôleurs Symfony.
- **Entity/** : Contient les entités Doctrine représentant les tables de la base de données.
- **Form/** : Contient les classes de formulaire Symfony.
- **HttpClient/** : Contient les clients HTTP utilisés pour communiquer avec d'autres services.
- **templates/** : Contient les fichiers de modèle Twig pour les vues.
- **tests/** : Contient les tests unitaires et fonctionnels.
- **translations/** : Contient les fichiers de traduction.
- **var/** : Contient les données variables, comme les fichiers journaux et les fichiers caches.

### Utilisation 🖥️

1. **Génération de PDF :**
- Connectez-vous à l'application.
- Accédez à la page de génération de PDF.
- Remplissez le formulaire avec l'URL ou le fichier HTML.
- Soumettez le formulaire pour générer le PDF.

2. **Consultation de l'historique :**
- Connectez-vous à l'application.
- Accédez à la page de votre compte.
- Consultez l'historique des PDF générés précédemment.

3. **Suppression de PDF :**
- Connectez-vous à l'application.
- Accédez à la page de votre compte.
- Trouvez le PDF que vous souhaitez supprimer dans l'historique.
- Supprimez le PDF en cliquant sur le bouton correspondant.

