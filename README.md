# Second Chance

Second Chance est une application web Laravel destinée à accompagner des patients dans un parcours de suivi, avec des médecins, des associations et un espace d'administration.

Le projet permet de gérer les rendez-vous médicaux, les activités associatives, les participations, les messages, les notifications et un système de points lié au parcours des patients et des médecins.

## Fonctionnalités

- Authentification classique avec Laravel Breeze.
- Connexion Google via Laravel Socialite.
- Gestion des rôles avec Spatie Laravel Permission : `patient`, `medecin`, `association`, `admin`.
- Tableau de bord adapté selon le rôle connecté.
- Gestion des rendez-vous entre patients et médecins.
- Validation des rendez-vous, envoi d'e-mail de confirmation et attribution/dépense de points.
- Gestion des activités créées par les associations.
- Demandes de participation aux activités par les patients.
- Notifications lors de la création de nouvelles activités.
- Messagerie entre patients et associations.
- Gestion des profils patients, médecins et associations.
- Espace admin avec suivi des utilisateurs et validations en attente.

## Stack technique

- PHP 8.2+
- Laravel 12
- Laravel Breeze
- Laravel Sanctum
- Laravel Socialite
- Laravel Reverb
- Spatie Laravel Permission
- Pest / PHPUnit
- Vite
- Tailwind CSS
- Alpine.js
- SQLite par défaut, configurable vers MySQL ou un autre SGBD supporté par Laravel

## Installation

Clonez le projet puis installez les dépendances :

```bash
composer install
npm install
```

Créez le fichier d'environnement :

```bash
cp .env.example .env
php artisan key:generate
```

Si vous utilisez SQLite, créez le fichier de base de données :

```bash
touch database/database.sqlite
```

Lancez les migrations et le seeder admin :

```bash
php artisan migrate --seed
```

Compilez les assets :

```bash
npm run build
```

## Configuration `.env`

Exemple de configuration minimale :

```env
APP_NAME="Second Chance"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite

SESSION_DRIVER=database
QUEUE_CONNECTION=database
MAIL_MAILER=log
```

Le seeder `AdminUserSeeder` utilise ces variables pour créer ou mettre à jour le compte administrateur :

```env
ADMIN_EMAIL=admin@example.com
ADMIN_NOM=Admin
ADMIN_PRENOM=SecondChance
ADMIN_TELEPHONE=0600000000
ADMIN_VILLE=Casablanca
ADMIN_GENRE=Homme
ADMIN_PASSWORD=password
```

Pour activer la connexion Google, ajoutez aussi :

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

## Lancement en développement

Vous pouvez lancer Laravel et Vite séparément :

```bash
php artisan serve
npm run dev
```

Ou utiliser le script Composer qui démarre le serveur, la queue, les logs et Vite :

```bash
composer run dev
```

L'application sera généralement disponible sur :

```text
http://127.0.0.1:8000
```

## Commandes utiles

```bash
php artisan migrate
php artisan migrate:fresh --seed
php artisan queue:listen
php artisan test
npm run dev
npm run build
```

Le projet définit aussi un script de setup complet :

```bash
composer run setup
```

## Structure principale

- `app/Http/Controllers` : contrôleurs Laravel.
- `app/Models` : modèles Eloquent.
- `app/Repositories` : abstraction d'accès aux rendez-vous.
- `app/Notifications` : notifications de l'application.
- `app/Mail` : e-mails envoyés par l'application.
- `database/migrations` : structure de la base de données.
- `database/seeders` : données initiales, dont le compte admin.
- `resources/views` : vues Blade.
- `resources/js` : scripts front-end.
- `resources/css` : styles de l'application.
- `routes/web.php` : routes web principales.
- `routes/auth.php` : routes d'authentification.

## Rôles

### Patient

- Consulte son tableau de bord.
- Recherche les médecins validés.
- Demande des rendez-vous.
- Participe aux activités associatives.
- Consulte ses points, transactions, notifications et messages.

### Médecin

- Consulte et gère ses rendez-vous.
- Confirme ou annule les demandes.
- Définit le coût en points d'un rendez-vous.
- Gagne des points lors des rendez-vous confirmés.

### Association

- Crée des activités.
- Consulte les demandes de participation.
- Accepte ou refuse les participations.
- Echange des messages avec les patients.

### Admin

- Consulte les statistiques globales.
- Suit les utilisateurs récents.
- Gère les médecins et associations en attente de validation.
- Peut accéder aux ressources principales de gestion.

## Tests

Pour lancer la suite de tests :

```bash
php artisan test
```

Ou via Composer :

```bash
composer run test
```

## Notes

- Les e-mails sont configurés en `log` par défaut dans `.env.example`.
- Les notifications Laravel utilisent la table `notifications`.
- Les files d'attente utilisent la base de données par défaut avec `QUEUE_CONNECTION=database`.
- Après modification des assets front-end, lancez `npm run dev` en développement ou `npm run build` avant un déploiement.
