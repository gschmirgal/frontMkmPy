# frontMkmPy

![Symfony](https://img.shields.io/badge/symfony-7.3-000000.svg?style=for-the-bsymfony)
![PHP](https://img.shields.io/badge/php-8.2+-777BB4.svg?style=for-the-badge&logo=php)
![Doctrine](h## 🚀 Fonctionnalités avancées

### **Analytics & Reporting**
- **Graphiques de prix** avec prédictions IA intégrées
- **Export CSV** de toutes les données avec filtres
- **Statistiques temps réel** sur la homepage
- **Historique des imports** avec logs détaillés

### **Interface utilisateur**
- **Mode sombre/clair** automatique selon les préférences système
- **Animations CSS** pour les interactions (hover, transitions)
- **Navigation Turbo** pour une expérience SPA fluide
- **Design mobile-first** avec breakpoints optimisés

### **Développement**
- **Architecture modulaire** avec composants réutilisables
- **Code propre** avec séparation des responsabilités
- **Performance optimisée** avec requêtes Doctrine efficaces
- **SEO-friendly** avec URLs sémantiques

## 🌐 Exemples d'URLs

### **Interface multilingue**
- Homepage : `/` (redirige vers `/en` ou `/fr`)
- Homepage anglaise : `/en`
- Homepage française : `/fr`

### **Navigation principale**
- Liste des extensions : `/fr/expansions` ou `/en/expansions`
- Cartes d'une extension : `/fr/expansion/{id}`
- Détail d'une carte : `/fr/card/{cardid}/{expansionid}`
- Recherche : `/fr/search?search=motclef`

### **Administration**
- Logs MKM.py : `/fr/admin/logs/mkmpy`
- Logs Oracle : `/fr/admin/logs/mkmoraclepy`//img.shields.io/badge/doctrine-3.5+-FC6F2B.svg?style=for-the-badge&logo=doctrine)
![Bootstrap](https://img.shields.io/badge/bootstrap-5.0-7952B3.svg?style=for-the-badge&logo=bootstrap)
![Chart.js](https://img.shields.io/badge/chart.js-4.0-FF6384.svg?style=for-the-badge&logo=chart.js)
![License](https://img.shields.io/badge/license-MIT-green.svg?style=for-the-badge)

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

## ✨ Fonctionnalités principales

### 📊 **Analytics & Visualisation**
- **Graphiques interactifs** Chart.js avec évolution des prix et prédictions IA
- **Statistiques en temps réel** avec animations de compteurs sur la homepage
- **Comparaisons historiques** et analyse de tendances
- **Export de données** en CSV et autres formats

### 🌐 **Interface utilisateur moderne**
- **Design responsive** Bootstrap 5 avec support mobile complet
- **Thème adaptatif** clair/sombre avec détection automatique du système
- **Navigation SPA** ultra-rapide avec Turbo.js
- **Animations fluides** et transitions élégantes
- **Homepage impactante** avec sections modulaires

### 🔍 **Recherche & Navigation**
- **Recherche avancée** multi-critères avec filtres intelligents
- **Navigation fluide** avec URLs localisées (EN/FR)
- **Pagination optimisée** avec KnpPaginator
- **Tri dynamique** des tables avec localStorage

### 🌍 **Internationalisation**
- **Support multilingue** complet (Français/Anglais)
- **Sélecteur de langue** avec drapeaux et URLs localisées
- **Traductions dynamiques** dans les contrôleurs et templates
- **Interface adaptative** selon la locale

### 🎮 **Fonctionnalités Magic: The Gathering**
- **Intégration Scryfall** pour images et métadonnées
- **Hover d'images** avec prévisualisation des cartes
- **Gestion des extensions** avec comptage automatique des cartes
- **Support des cartes foil** et versions alternatives
- **Flip cards** avec animations CSS

frontMkmPy est une application web Symfony dédiée au suivi de l’évolution des prix des cartes à collectionner.
Elle sert d’interface front-end pour la base de données du projet [mkmpy](https://github.com/gschmirgal/mkmpy) : elle permet de visualiser, rechercher et analyser l’évolution des prix, extensions et informations associées, avec une interface moderne et responsive.

## Fonctionnalités principales

- Suivi graphique de l’évolution des prix des cartes (historique, comparaisons)
- Affichage des listes de cartes, extensions, prix
- Recherche multi-critères et navigation rapide
- Thème clair/sombre, hover image, responsive Bootstrap
- Pagination (KnpPaginator)

## 🛠️ Stack technique

### **Backend**
- **Symfony 7.3** - Framework PHP moderne avec les dernières fonctionnalités
- **Doctrine ORM 3.5+** - Mapping objet-relationnel avec migrations avancées
- **PHP 8.2+** - Dernières fonctionnalités du langage
- **MySQL/MariaDB** - Base de données relationnelle optimisée

### **Frontend & UI**
- **Twig 3.x** - Moteur de templates modulaire avec composants réutilisables
- **Bootstrap 5** - Framework CSS responsive avec thème adaptatif
- **Turbo.js** - Navigation SPA sans JavaScript complexe
- **Chart.js 4.x** - Graphiques interactifs et animations
- **Bootstrap Icons** - Iconographie cohérente

### **Architecture moderne**
- **AssetMapper** - Gestion d'assets moderne sans Webpack
- **Symfony UX** - Composants réactifs (Turbo, ChartJS, TwigComponent)
- **Composants Twig** - Architecture modulaire et réutilisable
- **JavaScript modulaire** - Code organisé en modules ES6+

### **Qualité & Performance**
- **KnpPaginatorBundle** - Pagination optimisée
- **Symfony Translation** - Internationalisation complète
- **Responsive Design** - Support mobile natif
- **SEO-friendly** - URLs propres et référencement

## 📋 Prérequis

- **PHP >= 8.2** avec extensions : `pdo_mysql`, `intl`, `opcache`
- **Composer 2.x** - Gestionnaire de dépendances PHP
- **MySQL 8.0+** ou **MariaDB 10.6+**
- **Symfony CLI** (recommandé pour le développement)
- **Git** pour le versioning
- **Node.js 16+** (optionnel, pour certains outils de développement)

## 🚀 Installation

### **1. Cloner le dépôt**
```bash
git clone https://github.com/gschmirgal/frontMkmPy.git
cd frontMkmPy
```

### **2. Installer les dépendances**
```bash
# Dépendances PHP
composer install

# Vérifier les prérequis
composer check-platform-reqs
```

### **3. Configuration de l'environnement**
```bash
# Copier le fichier de configuration
cp .env .env.local

# Éditer .env.local et configurer :
# DATABASE_URL="mysql://user:password@127.0.0.1:3306/frontmkmpy"
# APP_ENV=prod (pour la production)
```

### **4. Base de données**
```bash
# Créer la base de données
php bin/console doctrine:database:create

# Appliquer les migrations
php bin/console doctrine:migrations:migrate

# (Optionnel) Charger des données de test
php bin/console doctrine:fixtures:load
```

### **5. Assets et cache**
```bash
# Compiler les assets
php bin/console asset-map:compile

# Optimiser pour la production
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod
```

### **6. Lancer l'application**
```bash
# Développement avec Symfony CLI (recommandé)
symfony server:start

# Ou avec PHP built-in server
php -S 0.0.0.0:8000 -t public

# Production avec Apache/Nginx
# Pointer DocumentRoot vers /public
```

### **🔧 Configuration avancée**

#### **Permissions (Linux/Unix)**
```bash
# Permissions pour les dossiers de cache et logs
sudo chown -R www-data:www-data var/
sudo chmod -R 775 var/
```

#### **Variables d'environnement importantes**
```env
# .env.local
DATABASE_URL="mysql://user:pass@host:3306/db"
APP_ENV=prod
APP_SECRET=your-secret-key
MAILER_DSN=smtp://localhost

# Optionnel : intégration Scryfall
SCRYFALL_API_DELAY=100
```

## 🔄 Installation

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
  # ou pour un accès réseau
  php -S 0.0.0.0:8000 -t public
  ```

## Mise à jour

Pour mettre à jour le projet vers les dernières versions :

```bash
# Mettre à jour les dépendances
composer update

# Appliquer les nouvelles migrations
php bin/console doctrine:migrations:migrate

# Recompiler les assets
php bin/console asset-map:compile

# Vider le cache
php bin/console cache:clear
```

## 📁 Structure du projet

### **Architecture backend**
```
src/
├── Controller/          # Contrôleurs avec logique métier
│   ├── HomeController.php      # Page d'accueil avec statistiques
│   ├── CardController.php      # Détails et graphiques des cartes
│   ├── ExpansionController.php # Gestion des extensions
│   ├── AdminController.php     # Interface d'administration
│   └── SearchController.php    # Recherche avancée
├── Entity/              # Entités Doctrine ORM
│   ├── Products.php            # Cartes Magic
│   ├── Expansions.php          # Extensions/Sets
│   ├── Prices.php              # Historique des prix
│   └── ScryfallProducts.php    # Données Scryfall
├── Repository/          # Requêtes optimisées
│   └── avec méthodes personnalisées pour analytics
└── Twig/Components/     # Composants Twig réutilisables
    └── TableComponent.php      # Tables responsive exportables
```

### **Architecture frontend**
```
templates/
├── base.html.twig              # Template de base
├── home.html.twig              # Homepage modulaire
├── components/                 # Composants UI
│   ├── home/                   # Composants de la homepage
│   │   ├── _hero.html.twig        # Section principale
│   │   ├── _features.html.twig    # Fonctionnalités
│   │   ├── _stats.html.twig       # Statistiques animées
│   │   └── _*.html.twig           # Autres composants
│   ├── _navbar.html.twig       # Navigation responsive
│   └── table.html.twig         # Tables exportables
└── card/, expansion/           # Pages spécialisées

assets/
├── js/                         # JavaScript modulaire
│   ├── cardSorting.js             # Tri des cartes
│   └── cardFlip.js                # Animations de cartes
├── styles/
│   └── app.css                    # Styles personnalisés
└── vendor/                     # Dépendances externes
```

### **Configuration**
```
config/
├── packages/               # Configuration des bundles
│   ├── translation.yaml       # Support multilingue
│   └── doctrine.yaml          # ORM et base de données
├── routes.yaml            # Routes localisées
└── services.yaml          # Services personnalisés

translations/              # Fichiers de traduction
├── messages.en.yaml          # Anglais
└── messages.fr.yaml          # Français
```

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

## 🔗 Écosystème de projets

### **Projets liés**
- **[mkmpy](https://github.com/gschmirgal/mkmpy)** - Script Python de collecte de données CardMarket
- **[MKMOraclePy](https://github.com/gschmirgal/MKMOraclePy)** - Intelligence artificielle pour prédictions de prix
- **[gschmirgal.ovh](https://gschmirgal.ovh)** - Portfolio du développeur

### **Documentation technique**
- [Symfony 7.3](https://symfony.com/doc/7.3/index.html) - Framework principal
- [Doctrine ORM](https://www.doctrine-project.org/projects/doctrine-orm/en/current/index.html) - Mapping objet-relationnel
- [Twig 3.x](https://twig.symfony.com/doc/3.x/) - Moteur de templates
- [Bootstrap 5](https://getbootstrap.com/docs/5.3/) - Framework CSS
- [Turbo](https://turbo.hotwired.dev/) - Navigation SPA
- [Chart.js](https://www.chartjs.org/) - Graphiques interactifs
- [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) - Pagination

### **APIs externes**
- [Scryfall API](https://scryfall.com/docs/api) - Données et images Magic
- [CardMarket API](https://api.cardmarket.com/ws/documentation) - Prix et marketplace

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

## Licence

MIT