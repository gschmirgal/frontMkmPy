

# frontMkmPy

Application Symfony pour la gestion de cartes à collectionner, extensions et prix, utilisant Doctrine ORM, Twig et AssetMapper.

Ce projet permet de gérer des produits (cartes), leurs extensions, les prix associés, et propose une interface de recherche et de visualisation moderne.


## Prérequis

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Extensions PHP : pdo_mysql
- Navigateur web moderne


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
   - Exemple de `DATABASE_URL` pour MySQL :
     ```
     DATABASE_URL="mysql://user:motdepasse@127.0.0.1:3306/nomdelabase?serverVersion=8.0&charset=utf8mb4"
     ```

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

- `src/Entity/` : Entités Doctrine (`Products`, `Prices`, `Logs`, `Logsteps`, `Expansions`)
- `src/Repository/` : Repositories Doctrine
- `src/Controller/` : Contrôleurs Symfony (ex : `CardController`)
- `templates/` : Templates Twig (ex : `cardList.html.twig`, `searchList.html.twig`)


# frontMkmPy

frontMkmPy est une application web développée avec Symfony, Doctrine ORM et Twig, servant de front-end pour la base de données du projet [mkmpy](https://github.com/gschmirgal/mkmpy) (présent également sur mon GitHub). Elle permet de gérer des cartes à collectionner, leurs extensions, et d'afficher des statistiques de prix.

## Fonctionnalités principales

- Gestion des entités : cartes (produits), extensions, prix, logs, etc.
- Affichage de listes et de détails de cartes/extensions
- Recherche multi-critères
- Visualisation de l'évolution des prix avec des graphiques dynamiques (Chart.js)
- Interface responsive avec Bootstrap 5
- Thème clair/sombre dynamique

## Prérequis

- PHP >= 8.1
- Composer
- MySQL ou MariaDB
- Node.js (optionnel, pour certains assets)

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
3. **Configurer l'environnement**
  - Copier `.env` en `.env.local` et adapter les variables (notamment `DATABASE_URL`).
4. **Créer la base de données et lancer les migrations**
  ```bash
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
  ```
5. **Compiler les assets (si besoin)**
  ```bash
  php bin/console asset-map:compile
  ```
6. **Lancer le serveur de développement**
  ```bash
  symfony server:start
  # ou
  php -S localhost:8000 -t public
  ```

## Structure du projet

- `src/Entity/` : Entités Doctrine (Products, Expansions, Prices, etc.)
- `src/Controller/` : Contrôleurs Symfony
- `src/Repository/` : Repositories Doctrine
- `templates/` : Templates Twig
- `assets/` : Fichiers JS/CSS (AssetMapper)
- `migrations/` : Migrations Doctrine
- `public/` : Fichiers accessibles publiquement

## Exemples d'utilisation

- Accéder à la liste des extensions : `/expansions`
- Voir les cartes d'une extension : `/expansion/{id}`
- Voir le détail d'une carte : `/expansion/{expansionid}/{cardid}`
- Rechercher une carte ou une extension : `/search?search=motclef`

## Technologies utilisées

- Symfony 6+
- Doctrine ORM
- Twig
- Bootstrap 5
- Chart.js (via Symfony UX Chart.js)
- AssetMapper (importmap)

## Conseils

- Les relations entre entités sont gérées par Doctrine (attributs PHP).
- Les assets JS/CSS sont gérés par AssetMapper, pas besoin de Webpack.
- Pour ajouter un graphique, utilise le composant Chart.js (`composer require symfony/ux-chartjs`).
- Pour personnaliser le thème, modifie les fichiers dans `assets/` et les templates Twig.

## Licence

MIT (à adapter selon votre projet)
## Contribution
