# IMA: ICORP Management App

## À propos
IMA (ICORP Management App) est une application de gestion développée avec le framework Laravel. Cette application permet de [description de l'application et ses fonctionnalités].

## Prérequis
- PHP >= 8.1
- Composer
- Node.js et NPM
- MySQL ou PostgreSQL
- Git

## Installation

### Cloner le dépôt
```bash
git clone https://github.com/NOMO-Gabriel/ima
cd ima-icorp-management-app
```

### Installer les dépendances
```bash
composer install
npm install
```

### Configuration de l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

Ouvrez le fichier `.env` et configurez les paramètres de votre base de données:

#### Option 1: MySQL / PostgreSQL
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ima_db
DB_USERNAME=root
DB_PASSWORD=
```

#### Option 2: SQLite (plus simple pour le développement)
```
DB_CONNECTION=sqlite
```
Et créez un fichier database.sqlite dans le dossier database:
```bash
touch database/database.sqlite
```

### Migration et seeding de la base de données
```bash
php artisan migrate
php artisan db:seed  # Si des seeders sont disponibles
```

### Compilation des assets
```bash
npm run dev  # Pour le développement
# ou
npm run build  # Pour la production
```
### Création du lien symbolique pour le stockage
```bash
php artisan storage:link
```
### Lancer l'application
```bash
php artisan serve
```
L'application sera accessible à l'adresse: `http://localhost:8000`

## Flux de travail Git (Git Flow)

### Vue d'ensemble du Git Flow

Le Git Flow est un modèle de branchement qui permet de travailler de manière organisée et collaborative sur un projet. Voici le flux de travail que nous suivrons:

![Git Flow Diagram](/public/git-flow.svg)

### Règles générales
- **Ne jamais travailler directement sur la branche main**
- **Documenter tout votre code**
- **Écrire des commentaires clairs et précis**
- **Suivre les standards PSR pour le code PHP**

### Flux de travail détaillé étape par étape

1. **Basculer sur la branche main**
   ```bash
   git checkout main
   ```

2. **Récupérer les dernières modifications**
   ```bash
   git pull origin main
   ```

3. **Créer et basculer sur une nouvelle branche**
   ```bash
   git checkout -b feature/nom-de-votre-fonctionnalite
   ```

4. **Travailler sur la fonctionnalité**
   - Développer les fonctionnalités
   - Tester votre code
   - Documenter votre code

5. **Ajouter les fichiers modifiés**
   ```bash
   git add .
   ```

6. **Créer un commit avec un message descriptif**
   ```bash
   git commit -m "Description détaillée de la fonctionnalité implémentée"
   ```

7. **Pousser la branche sur le dépôt distant**
   ```bash
   git push origin feature/nom-de-votre-fonctionnalite
   ```

8. **Créer une Pull Request (PR)**
   - Aller sur GitHub: https://github.com/NOMO-Gabriel/ima
   - Cliquer sur "Compare & pull request"
   - Remplir la description de la PR
   - Demander une revue de code
   - Attendre l'approbation avant de merger

9. **Après le merge de la PR**
   ```bash
   git checkout main
   git pull origin main
   git branch -d feature/nom-de-votre-fonctionnalite  # Supprimer la branche locale
   ```

### Création de branches

#### Créer une nouvelle branche basée sur main (cas standard)
```bash
git checkout main
git pull origin main
git checkout -b feature/nouvelle-fonctionnalite
```

#### Créer une nouvelle branche basée sur une autre branche
```bash
git checkout branche-existante
git pull origin branche-existante
git checkout -b feature/sous-fonctionnalite
```

#### Créer une branche vide (sans historique)
```bash
# Créer une branche orpheline (sans parent)
git checkout --orphan feature/branche-vide

# Supprimer tous les fichiers de la zone de staging
git rm -rf .

# Créer un premier commit vide
git commit --allow-empty -m "Initial commit for empty branch"

# Pousser la branche
git push origin feature/branche-vide
```

### Conventions de nommage des branches
- `feature/nom-de-la-fonctionnalite` - Pour les nouvelles fonctionnalités
- `bugfix/description-du-bug` - Pour les corrections de bugs
- `hotfix/description-du-probleme` - Pour les correctifs urgents
- `refactor/description` - Pour les refactorisations de code
- `docs/description` - Pour les mises à jour de documentation

### Conventions pour les messages de commit
- Utilisez l'impératif présent: "Add", "Fix", "Update", pas "Added", "Fixed", "Updated"
- Soyez spécifique et concis
- Structure recommandée:
  ```
  Type: Court résumé (moins de 50 caractères)

  Description plus détaillée si nécessaire.
  ```
- Types courants: feat, fix, docs, style, refactor, test, chore

## Standards de codage

### Documentation
- Tous les fichiers doivent commencer par un en-tête documentaire
- Toutes les classes doivent être documentées
- Toutes les méthodes et fonctions doivent avoir une description, des paramètres et des valeurs de retour documentés

### Exemple de documentation pour une classe
```php
/**
 * Class UserController
 * 
 * Gère les opérations CRUD pour les utilisateurs
 * 
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Code bien commenté
        return view('users.index');
    }
}
```

### Standards de code
- Suivre les normes PSR-1, PSR-2 et PSR-12
- Utiliser la casse StudlyCaps pour les noms de classes
- Utiliser la casse camelCase pour les noms de méthodes et variables
- Indentation: 4 espaces, pas de tabulations
- Fichiers encodés en UTF-8 sans BOM

## Modélisation de données

### Modèle logique

- ICOORP(id PK, name, acronym, description, address, email, phone, website, logo, createdAt, updatedAt)
- User(id PK, password, email, firstname, lastname, phone, gender, address, profil, hireDate, role, createdAt, updatedAt)
- Teacher(id PK, salary, cni, matricule, birthdate, birthplace, profession, department, academy_id FK -> Academy.id)
- Assignation(id PK, teacher_id -> Teacher.id, center_id -> Center.id)
- Student(id PK, establishment)
- Enrollment(id PK, student_id FK -> Student.id, entrance_exam_id FK -> EntranceExam.id)
- Absences(id PK, student_id FK -> Student.id, slot_id FK -> Slot.id)
- EntranceExamFormation(id PK, formation_id FK -> Formation.id, entrance_exam_id FK -> EntranceExam.id)
- Academy(id PK, name, code, description, ACAMEDY_LANG)
- Center(id PK, name, city, nb_students, academy_id FK -> Academy.id)
- Timetable(id PK)
- Slot(id PK, start_time, end_time, week_day, room, timetable_id FK -> Timetable.id, teacher_id FK -> Teacher.id, course_id FK -> Course.id)
- EntranceExam(id PK, code, name)
- Phase(id PK, start, end)
- Formation(id PK, name, description, phase_id FK -> Phase.id)
- Book(id PK, title, author, publisher, publicationYear, isbn, category, description, lang, nb_pages, coverImage, quantity)
- FormationBook(id PK, book_id FK -> Book.id, formation_id FK -> Formation.id)
- Course(id PK, code, title, description, formation_id FK -> Formation.id)
- Exam(id PK, date, duration, exam_type, formation_id FK -> Formation.id)
- ExamType(id PK, exam_id FK -> Exam.id, course_id FK -> Course.id)
- Note(id PK, value, student_id FK -> Student.id, course_id FK -> Course.id, exam_id FK -> Exam.id)
- Material(id PK, title, description, acquisition_date, quantity)
- Command(id PK, date, quantity, amount, admin_id FK -> Admin.id)
- CommandUnit(id PK, quantity, amount, material_id FK -> Material.id, command_id FK -> Command.id)
- Transaction(id PK, date, amount, TRANSACTION_TYPE, TRANSACTION_REASON, admin_id FK -> Admin.id)

## Maintenance et déploiement

### Tests
```bash
php artisan test
```

### Déploiement
[Instructions spécifiques pour le déploiement de l'application]

## Ressources utiles
- [Documentation Laravel](https://laravel.com/docs)
- [Laracasts](https://laracasts.com)
- [Laravel News](https://laravel-news.com)

## Contribuer
Merci de contribuer à IMA! Veuillez suivre le flux de travail Git décrit ci-dessus et vous assurer que votre code respecte nos standards de codage.

## Contact
Pour toute question ou problème, veuillez contacter [votre nom ou l'équipe].