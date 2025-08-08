

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
- `assets/` : Fichiers JS/CSS (gérés par AssetMapper)
- `migrations/` : Migrations Doctrine
- `.env` : Variables d’environnement
- `public/` : Fichiers accessibles publiquement (index.php, assets compilés)


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

### Exemple d’utilisation

- Accéder à la liste des cartes : http://localhost:8000/cards
- Accéder à la recherche : http://localhost:8000/search?query=nom
- Voir le détail d’une carte : http://localhost:8000/card/{cardid}/{expansionid}/



## Fonctionnalités principales

- Affichage de la liste des cartes et extensions
- Recherche multi-critères sur les cartes et extensions avec affichage des résultats groupés (voir `templates/searchList.html.twig`)
- Détail d’une carte et de ses prix
- Gestion des relations entre entités (produits, extensions, logs, etc.)
- Utilisation de Twig pour le rendu HTML
- Gestion des assets JS/CSS avec AssetMapper (pas de Webpack nécessaire)
- Utilisation de Bootstrap et Bootstrap Icons pour le style


## Conseils & Astuces

- Les relations entre entités sont gérées par Doctrine via les attributs PHP.
- Les données initiales peuvent être insérées dans les fichiers de migration si besoin.
- Ne jamais committer de secrets de production dans `.env`.
- Pour utiliser Bootstrap Icons, ajoute dans `base.html.twig` :
  ```html
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  ```
- Pour ajouter un asset JS/CSS, place-le dans `assets/` et référence-le dans `app.js` ou via `importmap()` dans Twig.
- Pour des requêtes Doctrine avancées (distinct, group by, min/max), voir les méthodes du repository `ProductsRepository`.


## Structure de la base de données (exemple)

- Table `products` : id, name, expansion_id, ...
- Table `expansions` : id, name, ...
- Table `prices` : id, product_id, log_id, ...
- Table `logs` : id, dateImport, dateImportFile, step_id, ...
- Table `logsteps` : id, step

Les relations sont gérées par Doctrine (ManyToOne, etc.) et les clés étrangères sont créées via les migrations.

## FAQ

**Q : Comment ajouter une nouvelle entité ?**
A : Utilise la commande `php bin/console make:entity` puis crée une migration.

**Q : Comment ajouter un champ ou une relation ?**
A : Modifie l’entité, puis `php bin/console make:migration` et `php bin/console doctrine:migrations:migrate`.

**Q : Comment personnaliser le style ?**
A : Modifie les fichiers dans `assets/` et les templates Twig.

## Liens utiles

- [Documentation Symfony](https://symfony.com/doc/current/index.html)
- [Documentation Doctrine](https://www.doctrine-project.org/projects/doctrine-orm/en/current/index.html)
- [Twig](https://twig.symfony.com/doc/3.x/)
- [AssetMapper](https://symfony.com/doc/current/frontend/asset_mapper.html)
- [Bootstrap Icons](https://icons.getbootstrap.com/)

## Contribution

Les contributions sont les bienvenues !
1. Forkez le projet
2. Créez une branche (`git checkout -b feature/ma-feature`)
3. Commitez vos modifications (`git commit -am 'Ajout d\'une feature'`)
4. Poussez la branche (`git push origin feature/ma-feature`)
5. Ouvrez une Pull Request

## Licence

MIT
