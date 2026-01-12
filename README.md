# 🎯 TalentHub - Authentication System

## 📋 Vue d'ensemble

TalentHub est une application web de recrutement avec un système d'authentification robuste basé sur une architecture MVC enrichie avec les patterns Repository et Service. Le projet implémente une séparation claire des responsabilités et utilise l'injection de dépendances pour une meilleure maintenabilité.

### 🏗️ Architecture

```
Router → Controller → Service → Repository → Model
```

## ✨ Fonctionnalités

### Authentification
- ✅ Inscription avec sélection de rôle (Candidate/Recruiter)
- ✅ Connexion sécurisée avec hashage de mot de passe
- ✅ Déconnexion
- ✅ Gestion des sessions
- ✅ Protection CSRF

### Gestion des Rôles
- 👤 **Candidate**: Accès au dashboard candidat
- 💼 **Recruiter**: Accès au dashboard recruteur
- 🔑 **Admin**: Accès au back-office d'administration

### Sécurité
- 🔒 Hashage des mots de passe avec `password_hash()`
- 🛡️ Requêtes SQL préparées (protection contre SQL injection)
- 🚫 Middleware d'authentification et de rôles
- ✔️ Validation côté serveur
- 🔐 Protection des routes sensibles

## 📁 Structure du Projet

```
talenthub/
├── app/
│   ├── Models/              # Entités métier
│   │   ├── User.php
│   │   └── Role.php
│   ├── Repositories/        # Accès aux données
│   │   ├── BaseRepository.php (interface)
│   │   ├── UserRepository.php
│   │   └── RoleRepository.php
│   ├── Services/            # Logique métier
│   │   ├── AuthService.php
│   │   ├── UserService.php
│   │   ├── RoleService.php
│   │   └── ValidatorService.php
│   ├── Controllers/         # Gestion des requêtes HTTP
│   │   ├── AuthController.php
│   │   ├── CandidateController.php
│   │   ├── RecruiterController.php
│   │   └── AdminController.php
│   └── Views/               # Interfaces utilisateur
│       ├── home.php
│       ├── auth/
│       │   ├── register.php
│       │   └── login.php
│       ├── candidate/
│       │   └── dashboard.php
│       ├── recruiter/
│       │   └── dashboard.php
│       ├── admin/
│       │   └── dashboard.php
│       └── errors/
│           ├── 403.php
│           └── 404.php
├── config/
│   ├── Database.php         # Connexion PDO (Singleton)
│   ├── Container.php        # IoC Container pour DI
│   └── dependencies.php     # Configuration des bindings
├── routes/
│   └── web.php              # Définition de toutes les routes
├── middleware/
│   ├── Middleware.php       # Interface
│   ├── AuthMiddleware.php   # Vérification connexion
│   └── RoleMiddleware.php   # Vérification rôles
├── public/
│   ├── index.php            # Point d'entrée unique
│   └── .htaccess            # Redirections
├── storage/
│   └── logs/                # Fichiers de logs
└── database/
    └── schema.sql           # Schéma de base de données
```

## 🗄️ Base de Données

### Tables

#### `roles`
```sql
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);
```

#### `users`
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);
```

### Seeds par défaut
```sql
INSERT INTO roles (name, description) VALUES
('admin', 'Administrateur système'),
('recruiter', 'Recruteur'),
('candidate', 'Candidat');
```

## 🚀 Installation

### Prérequis
- PHP 8.0 ou supérieur
- MySQL 5.7+ ou MariaDB 10.3+
- Serveur web (Apache/Nginx)
- Composer (optionnel)

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone https://github.com/votre-repo/talenthub.git
cd talenthub
```

2. **Créer la base de données**
```bash
mysql -u root -p
CREATE DATABASE talenthub;
exit;
```

3. **Importer le schéma**
```bash
mysql -u root -p talenthub < database/schema.sql
```

4. **Configurer les variables d'environnement**

Créer un fichier `.env` à la racine :
```env
DB_HOST=localhost
DB_NAME=talenthub
DB_USER=root
DB_PASSWORD=votre_mot_de_passe
DB_CHARSET=utf8mb4
```

5. **Configurer le serveur web**

**Apache (.htaccess déjà fourni)**
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

**Nginx**
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

6. **Installer les dépendances (si Composer est utilisé)**
```bash
composer install
```

7. **Configurer les permissions**
```bash
chmod -R 755 storage/
chmod -R 755 public/
```

## 🎯 Utilisation

### Démarrer le serveur de développement
```bash
php -S localhost:8000 -t public
```

Accéder à l'application : `http://localhost:8000`

### Routes disponibles

#### Routes publiques
- `GET /` - Page d'accueil
- `GET /register` - Formulaire d'inscription
- `POST /register` - Traitement inscription
- `GET /login` - Formulaire de connexion
- `POST /login` - Traitement connexion
- `POST /logout` - Déconnexion

#### Routes protégées - Candidate
- `GET /candidate/dashboard` - Dashboard candidat

#### Routes protégées - Recruiter
- `GET /recruiter/dashboard` - Dashboard recruteur

#### Routes protégées - Admin
- `GET /admin/dashboard` - Dashboard admin
- `GET /admin/users` - Liste des utilisateurs

## 🏛️ Architecture Détaillée

### 1. Router
Gère le routage centralisé et l'application des middlewares.

```php
// Exemple dans routes/web.php
$router->get('/', 'HomeController@index');
$router->get('/login', 'AuthController@showLoginForm');
$router->post('/login', 'AuthController@login');
$router->get('/candidate/dashboard', 'CandidateController@dashboard', 
    [AuthMiddleware::class, new RoleMiddleware(['candidate'])]);
```

### 2. Controller
Reçoit les requêtes HTTP et délègue au Service.

```php
class AuthController {
    private AuthService $authService;
    
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }
    
    public function login() {
        $user = $this->authService->login($_POST['email'], $_POST['password']);
        // Redirection selon rôle
    }
}
```

### 3. Service
Contient la logique métier et utilise les Repositories.

```php
class AuthService {
    private UserRepository $userRepo;
    private RoleRepository $roleRepo;
    
    public function __construct(UserRepository $userRepo, RoleRepository $roleRepo) {
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
    }
    
    public function register(array $data): User {
        // Validation
        // Hashage password
        // Création via repository
        return $this->userRepo->create($data);
    }
}
```

### 4. Repository
Gère l'accès aux données et retourne des Models.

```php
class UserRepository implements BaseRepository {
    public function findByEmail(string $email): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetch();
        return $data ? new User($data) : null;
    }
}
```

### 5. Model
Représente une entité métier sans logique d'accès aux données.

```php
class User {
    private int $id;
    private string $name;
    private string $email;
    private Role $role;
    
    public function hasRole(string $roleName): bool {
        return $this->role->getName() === $roleName;
    }
}
```

## 🔧 Dependency Injection

### Configuration du Container

```php
// config/dependencies.php
$container = new Container();

// Singletons
$container->singleton(Database::class, function() {
    return Database::getInstance();
});

$container->singleton(UserRepository::class, function($c) {
    return new UserRepository($c->resolve(Database::class));
});

// Services
$container->bind(AuthService::class, function($c) {
    return new AuthService(
        $c->resolve(UserRepository::class),
        $c->resolve(RoleRepository::class)
    );
});
```

### Utilisation

```php
// Le container résout automatiquement les dépendances
$authController = $container->resolve(AuthController::class);
```

## 🧪 Tests

### Tests manuels recommandés

1. **Test d'inscription**
   - Inscription en tant que Candidate
   - Inscription en tant que Recruiter
   - Tentative avec email déjà existant
   - Validation des champs requis

2. **Test de connexion**
   - Connexion réussie pour chaque rôle
   - Connexion avec mauvais mot de passe
   - Connexion avec email inexistant

3. **Test de protection des routes**
   - Accès à `/candidate/dashboard` sans connexion → Redirection vers login
   - Accès à `/admin/dashboard` en tant que Candidate → Erreur 403
   - Accès à `/recruiter/dashboard` en tant que Recruiter → Succès

4. **Test de déconnexion**
   - Session détruite après logout
   - Impossibilité d'accéder aux pages protégées après logout

## 🔒 Sécurité

### Checklist de sécurité

- ✅ **Passwords**: Hashés avec `password_hash()` (bcrypt)
- ✅ **SQL Injection**: Requêtes préparées partout
- ✅ **XSS**: Échappement avec `htmlspecialchars()`
- ✅ **CSRF**: Tokens CSRF sur formulaires
- ✅ **Sessions**: Régénération d'ID après login
- ✅ **Validation**: Toutes les entrées validées côté serveur
- ✅ **Accès fichiers**: Pas d'accès direct aux fichiers sensibles
- ✅ **Erreurs**: Messages d'erreur génériques pour l'utilisateur

### Bonnes pratiques implémentées

```php
// Hashage sécurisé
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Vérification
if (password_verify($inputPassword, $hashedPassword)) {
    // OK
}

// Requête préparée
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);

// Échappement XSS
echo htmlspecialchars($user->getName(), ENT_QUOTES, 'UTF-8');
```

## 🌟 Fonctionnalités Bonus (Optionnelles)

### Remember Me
```php
// AuthService
public function rememberUser(User $user): void {
    $token = bin2hex(random_bytes(32));
    // Stocker token en BDD
    setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
}
```

### Logs des connexions
```php
// Table login_attempts
CREATE TABLE login_attempts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    ip_address VARCHAR(45),
    success BOOLEAN,
    attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Système de logs
```php
// LogService
$logService->info('User logged in', ['user_id' => $user->getId()]);
$logService->error('Login failed', ['email' => $email, 'ip' => $ip]);
```

## 📊 Métriques du Projet

- **12 Epics**
- **37 User Stories**
- **133 Story Points**
- **4 Sprints**

### Répartition par Sprint
- **Sprint 1**: Conception, Infrastructure, Routage (8 stories, 30 SP)
- **Sprint 2**: Repository, Models, Services, Controllers (13 stories, 45 SP)
- **Sprint 3**: UI, DI, Sécurité, Tests, Documentation (14 stories, 44 SP)
- **Sprint 4**: Fonctionnalités bonus (4 stories, 15 SP)

## 🤝 Contribution

### Ajouter une nouvelle route protégée

1. **Définir la route** dans `routes/web.php`
```php
$router->get('/new-feature', 'NewController@index', [
    AuthMiddleware::class,
    new RoleMiddleware(['admin'])
]);
```

2. **Créer le Controller**
```php
class NewController {
    public function index() {
        // Logique
    }
}
```

3. **Créer la vue** dans `app/Views/`

### Ajouter un nouveau rôle

1. **Insérer en BDD**
```sql
INSERT INTO roles (name, description) VALUES ('manager', 'Manager');
```

2. **Mettre à jour les middlewares** si nécessaire

3. **Créer le controller et les vues** spécifiques

## 📝 Documentation Complémentaire

- [Guide d'architecture](docs/architecture.md)
- [API Documentation](docs/api.md)
- [Guide de contribution](docs/contributing.md)
- [Changelog](CHANGELOG.md)

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 👥 Auteurs

- **Votre Nom** - Développeur principal
- **Équipe TalentHub** - Contributors

## 🙏 Remerciements

- Inspiré par les meilleures pratiques de Laravel et Symfony
- Architecture basée sur les principes SOLID
- Patterns Repository et Service pour une meilleure séparation des responsabilités

---

**TalentHub** - Système d'authentification professionnel avec architecture en couches 🚀