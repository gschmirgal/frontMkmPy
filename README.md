# frontMkmPy

frontMkmPy est une application web Symfony dédiée au suivi de l’évolution des prix des cartes à collectionner.
Elle sert d’interface front-end pour la base de données du projet [mkmpy](https://github.com/gschmirgal/mkmpy) : elle permet de visualiser, rechercher et analyser l’évolution des prix, extensions et informations associées, avec une interface moderne et responsive.

## Fonctionnalités principales

- Suivi graphique de l’évolution des prix des cartes (historique, comparaisons)
- Affichage des listes de cartes, extensions, prix
- Recherche multi-critères et navigation rapide
- Thème clair/sombre, hover image, responsive Bootstrap
- Pagination (KnpPaginator)

## Captures d'écran

Quelques aperçus de l'application :

![Accueil](.screenshots/accueil.png)
![Liste des cartes](.screenshots/cardlist.png)
![Détail carte](.screenshots/carddetails.png)
![Carte dans extension](.screenshots/cardinext.png)
![Versions carte](.screenshots/cardversion.png)
![Liste extensions](.screenshots/extlist.png)
![Recherche](.screenshots/search.png)
![Import log](.screenshots/importlog.png)
![Thème clair](.screenshots/lighttheme.png)

## Stack technique

- Symfony 6+
- Doctrine ORM
- Twig
- Bootstrap 5
- Chart.js (Symfony UX)
- AssetMapper (importmap)
- KnpPaginatorBundle

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
3. **Configurer l’environnement**
  - Copier `.env` en `.env.local` et adapter `DATABASE_URL`.
4. **Créer la base et lancer les migrations**
  ```bash
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
  ```
5. **Compiler les assets**
  ```bash
  php bin/console asset-map:compile
  ```
6. **Lancer le serveur**
  ```bash
  symfony server:start
  # ou
  php -S localhost:8000 -t public
  ```

## Structure du projet

- `src/Entity/` : Entités Doctrine (Products, Expansions, Prices, Logs...)
- `src/Controller/` : Contrôleurs Symfony
- `src/Repository/` : Repositories Doctrine
- `templates/` : Templates Twig (pages, composants)
- `assets/` : JS/CSS (AssetMapper)
- `migrations/` : Migrations Doctrine
- `public/` : Fichiers publics

## Exemples d’utilisation

- Liste des extensions : `/expansions`
- Détail d’une carte : `/card/{cardid}/{expansionid}`
- Recherche : `/search?search=motclef`

## Contribution

1. Forkez le projet
2. Créez une branche (`git checkout -b feature/ma-feature`)
3. Commitez vos modifications
4. Poussez la branche (`git push origin feature/ma-feature`)
5. Ouvrez une Pull Request

## Liens utiles

- [Symfony](https://symfony.com/doc/current/index.html)
- [Doctrine](https://www.doctrine-project.org/projects/doctrine-orm/en/current/index.html)
- [Twig](https://twig.symfony.com/doc/3.x/)
- [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle)
- [Chart.js](https://www.chartjs.org/)

## Licence

MIT