
# frontMkmPy

Application Symfony pour la gestion de cartes, extensions et prix, utilisant Doctrine ORM, Twig et AssetMapper.

## Prérequis

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Extensions PHP : pdo_mysql

## Installation

1. **Cloner le dépôt**
   ```bash
   git clone <url-du-repo>
   cd frontMkmPy
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Configurer l’environnement**
   - Copier `.env` en `.env.local` si besoin et adapter les variables (notamment `DATABASE_URL`).

4. **Créer la base de données et lancer les migrations**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **(Optionnel) Charger des données de test**
   - Si des fixtures sont disponibles :
     ```bash
     php bin/console doctrine:fixtures:load
     ```

## Structure du projet

- `src/Entity/` : Entités Doctrine (Products, Prices, Logs, Logsteps, Expansions)
- `src/Repository/` : Repositories Doctrine
- `src/Controller/` : Contrôleurs Symfony
- `templates/` : Templates Twig
- `assets/` : Fichiers JS/CSS (gérés par AssetMapper)
- `migrations/` : Migrations Doctrine
- `.env` : Variables d’environnement

## Utilisation

- Lancer le serveur de développement :
  ```bash
  symfony server:start
  ```
- Générer une nouvelle migration :
  ```bash
  php bin/console make:migration
  ```
- Appliquer les migrations :
  ```bash
  php bin/console doctrine:migrations:migrate
  ```
- Compiler les assets (si besoin) :
  ```bash
  php bin/console asset-map:compile
  ```

## Fonctionnalités principales

- Affichage de la liste des cartes et extensions
- Détail d’une carte et de ses prix
- Gestion des relations entre entités (produits, extensions, logs, etc.)
- Utilisation de Twig pour le rendu HTML
- Gestion des assets JS/CSS avec AssetMapper (pas de Webpack nécessaire)

## Conseils

- Les relations entre entités sont gérées par Doctrine via les attributs PHP.
- Les données initiales peuvent être insérées dans les fichiers de migration si besoin.
- Ne jamais committer de secrets de production dans `.env`.
- Pour utiliser Bootstrap Icons, ajoute dans `base.html.twig` :
  ```html
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  ```

## Licence

MIT (à adapter selon votre projet)
