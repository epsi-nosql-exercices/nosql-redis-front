# Installation

#### Pré-requis :

Générer le fichier `.env` et la clé d'application :

```
cp .env.example .env
php artisan key:generate
```

Installation des composants nécessaires :

```
composer install
```

#### (Optionnel) Développement front-end :

Installation des packages :

```
npm install
```

Compilation des assets :

```
npm run dev
 ```

#### Lancement de l'application

Utiliser le serveur built-in :

```
php artisan serve
```