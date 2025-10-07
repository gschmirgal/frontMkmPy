# frontMkmPy

![Symfony](https://img.shields.io/badge/symfony-7.3-000000.svg?style=for-the-badge&logo=symfony)
![PHP](https://img.shields.io/badge/php-8.2+-777BB4.svg?style=for-the-badge&logo=php)
![Doctrine](https://img.shields.io/badge/doctrine-3.5+-FC6F2B.svg?style=for-the-badge&logo=doctrine)
![Bootstrap](https://img.shields.io/badge/bootstrap-5.0-7952B3.svg?style=for-the-badge&logo=bootstrap)
![Chart.js](https://img.shields.io/badge/chart.js-4.0-FF6384.svg?style=for-the-badge&logo=chart.js)
![Turbo](https://img.shields.io/badge/turbo-SPA-00A8E6.svg?style=for-the-badge)
![License](https://img.shields.io/badge/license-MIT-green.svg?style=for-the-badge)

**frontMkmPy** est une application web Symfony moderne dédiée au suivi professionnel de l'évolution des prix des cartes Magic: The Gathering.

Elle sert d'interface front-end sophistiquée pour la base de données du projet [mkmpy](https://github.com/gschmirgal/mkmpy) et intègre l'intelligence artificielle de [MKMOraclePy](https://github.com/gschmirgal/MKMOraclePy) pour des prédictions de prix avancées.

## 📖 Table des matières

- [✨ Fonctionnalités](#-fonctionnalités)
- [🛠️ Stack technique](#️-stack-technique)
- [📋 Prérequis](#-prérequis)
- [🚀 Installation](#-installation)
- [🌐 Utilisation](#-utilisation)
- [📁 Structure du projet](#-structure-du-projet)
- [🔧 Configuration](#-configuration)
- [🤝 Contribution](#-contribution)
- [🔗 Liens utiles](#-liens-utiles)
- [📄 Licence](#-licence)

## ✨ Fonctionnalités

### 📊 Analytics & Visualisation
- **Graphiques interactifs** Chart.js avec évolution des prix et prédictions IA
- **Statistiques en temps réel** avec animations de compteurs sur la homepage
- **Comparaisons historiques** et analyse de tendances
- **Export de données** en CSV et autres formats

### 🌐 Interface utilisateur moderne
- **Design responsive** Bootstrap 5 avec support mobile complet
- **Thème adaptatif** clair/sombre avec détection automatique du système
- **Navigation SPA** ultra-rapide avec Turbo.js
- **Animations fluides** et transitions élégantes
- **Homepage impactante** avec sections modulaires

### 🔍 Recherche & Navigation
- **Recherche avancée** multi-critères avec filtres intelligents
- **Navigation fluide** avec URLs localisées (EN/FR)
- **Pagination optimisée** avec KnpPaginator
- **Tri dynamique** des tables avec localStorage

### 🌍 Internationalisation
- **Support multilingue** complet (Français/Anglais)
- **Sélecteur de langue** avec drapeaux et URLs localisées
- **Traductions dynamiques** dans les contrôleurs et templates
- **Interface adaptative** selon la locale

### 🎮 Fonctionnalités Magic: The Gathering
- **Intégration Scryfall** pour images et métadonnées
- **Hover d'images** avec prévisualisation des cartes
- **Gestion des extensions** avec comptage automatique des cartes
- **Support des cartes foil** et versions alternatives
- **Flip cards** avec animations CSS

## 🛠️ Stack technique

### Backend
- **Symfony 7.3** - Framework PHP moderne
- **Doctrine ORM 3.5+** - Mapping objet-relationnel
- **PHP 8.2+** - Dernières fonctionnalités du langage
- **MySQL/MariaDB** - Base de données relationnelle

### Frontend
- **Twig 3.x** - Moteur de templates modulaire
- **Bootstrap 5** - Framework CSS responsive
- **Turbo.js** - Navigation SPA sans JavaScript complexe
- **Chart.js 4.x** - Graphiques interactifs
- **Bootstrap Icons** - Iconographie cohérente

### Architecture
- **AssetMapper** - Gestion d'assets moderne sans Webpack
- **Symfony UX** - Composants réactifs (Turbo, ChartJS, TwigComponent)
- **Composants Twig** - Architecture modulaire et réutilisable
- **JavaScript modulaire** - Code organisé en modules ES6+

## 📋 Prérequis

- **PHP >= 8.2** avec extensions : `pdo_mysql`, `intl`, `opcache`
- **Composer 2.x** - Gestionnaire de dépendances PHP
- **MySQL 8.0+** ou **MariaDB 10.6+**
- **Symfony CLI** (recommandé pour le développement)
- **Git** pour le versioning

## 🚀 Installation

### 1. Cloner le dépôt
```bash
git clone https://github.com/gschmirgal/frontMkmPy.git
cd frontMkmPy
```

### 2. Installer les dépendances
```bash
composer install
```

### 3. Configuration
```bash
# Copier le fichier de configuration
cp .env .env.local

# Éditer .env.local et configurer DATABASE_URL
# DATABASE_URL="mysql://user:password@127.0.0.1:3306/frontmkmpy"
```

### 4. Base de données
```bash
# Créer la base de données
php bin/console doctrine:database:create

# Appliquer les migrations
php bin/console doctrine:migrations:migrate
```

### 5. Assets
```bash
# Compiler les assets
php bin/console asset-map:compile
```

### 6. Lancer l'application
```bash
# Avec Symfony CLI (recommandé)
symfony server:start

# Ou avec PHP built-in server
php -S 0.0.0.0:8000 -t public
```

## 🌐 Utilisation

### URLs principales
- **Homepage** : `/` (redirige vers `/en` ou `/fr`)
- **Extensions** : `/fr/expansions`
- **Cartes d'une extension** : `/fr/expansion/{id}`
- **Détail d'une carte** : `/fr/card/{cardid}/{expansionid}`
- **Recherche** : `/fr/search?search=motclef`
- **Administration** : `/fr/admin/logs/mkmpy`

### Fonctionnalités clés
- **Changement de langue** via le sélecteur dans la navbar
- **Thème sombre/clair** automatique ou manuel
- **Export CSV** depuis les tables de données
- **Graphiques interactifs** sur les pages de détail des cartes

## 📁 Structure du projet

```
frontMkmPy/
├── src/
│   ├── Controller/          # Contrôleurs avec logique métier
│   ├── Entity/              # Entités Doctrine ORM
│   ├── Repository/          # Requêtes optimisées
│   └── Twig/Components/     # Composants Twig réutilisables
├── templates/
│   ├── components/          # Composants UI modulaires
│   │   └── home/           # Composants de la homepage
│   ├── card/               # Pages des cartes
│   └── expansion/          # Pages des extensions
├── assets/
│   ├── js/                 # JavaScript modulaire
│   └── styles/             # Styles CSS personnalisés
├── config/
│   ├── packages/           # Configuration des bundles
│   └── routes.yaml         # Routes localisées
├── translations/           # Fichiers de traduction (EN/FR)
└── migrations/             # Migrations de base de données
```

## 🔧 Configuration

### Variables d'environnement (.env.local)
```env
DATABASE_URL="mysql://user:pass@host:3306/db"
APP_ENV=prod
APP_SECRET=your-secret-key
```

### Production
```bash
# Optimisation pour la production
php bin/console cache:clear --env=prod
php bin/console asset-map:compile

# Permissions (Linux/Unix)
sudo chown -R www-data:www-data var/
sudo chmod -R 775 var/
```

## 🤝 Contribution

1. Forkez le projet
2. Créez une branche feature (`git checkout -b feature/ma-feature`)
3. Commitez vos modifications (`git commit -m 'Ajout ma feature'`)
4. Poussez la branche (`git push origin feature/ma-feature`)
5. Ouvrez une Pull Request

## 🔗 Liens utiles

### Projets liés
- **[mkmpy](https://github.com/gschmirgal/mkmpy)** - Script Python de collecte de données CardMarket
- **[MKMOraclePy](https://github.com/gschmirgal/MKMOraclePy)** - Intelligence artificielle pour prédictions de prix
- **[Portfolio](https://gschmirgal.ovh)** - Portfolio du développeur

### Documentation
- [Symfony 7.3](https://symfony.com/doc/7.3/index.html)
- [Doctrine ORM](https://www.doctrine-project.org/projects/doctrine-orm/en/current/index.html)
- [Bootstrap 5](https://getbootstrap.com/docs/5.3/)
- [Chart.js](https://www.chartjs.org/)
- [Turbo](https://turbo.hotwired.dev/)

### APIs externes
- [Scryfall API](https://scryfall.com/docs/api) - Données et images Magic
- [CardMarket API](https://api.cardmarket.com/ws/documentation) - Prix et marketplace

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.