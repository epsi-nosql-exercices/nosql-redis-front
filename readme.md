# Installation

#### Pré-requis :

Générer le fichier `.env` et la clé d'application :

```
cp .env.example .env
php artisan key:generate
```

Dans le fichier `.env`, spécifier le chemin d'accès de la base de donnée SQLite et la clé d'API Dropbox. Créer un fichier `database.sqlite` vide si nécessaire dans le répertoire `/database`.

```
DROPBOX_API_KEY="key"
```

(Optionnel) Pour spécifier manuellement le chemin de la base, utiliser la variable suivante :

```
DB_DATABASE="path/to/database.sqlite"
```

Installation des composants nécessaires :

```
composer install
```

Installation de la base de données :

```
php artisan migrate
```

#### (Optionnel) Développement front-end :

Installation des packages :

```
npm install
```

Compilation des assets :

```
 run dev
 ```

#### Lancement de l'application

Utiliser le serveur built-in :

```
php artisan serve
```