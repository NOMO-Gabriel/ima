<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Création des permissions par modules
        $this->createUserManagementPermissions();
        $this->createAcademyManagementPermissions();
        $this->createFinancialManagementPermissions();
        $this->createCourseManagementPermissions();
        $this->createDocumentManagementPermissions();
        $this->createCompetitionManagementPermissions();

        // Création des rôles selon la hiérarchie
        $this->createNationalRoles();
        $this->createCityRoles();
        $this->createCenterRoles();
        $this->createTeacherAndStudentRoles();
    }

    /**
     * Création des permissions pour la gestion des utilisateurs
     */
    private function createUserManagementPermissions()
    {
        $permissions = [
            'user.view.any' => 'Voir tous les utilisateurs',
            'user.view.own' => 'Voir son propre profil',
            'user.create' => 'Créer des utilisateurs',
            'user.update.any' => 'Modifier tous les utilisateurs',
            'user.update.own' => 'Modifier son propre profil',
            'user.delete.any' => 'Supprimer des utilisateurs',
            'user.validate' => 'Valider les inscriptions utilisateurs',
            'user.finalize' => 'Finaliser les comptes utilisateurs',
            'user.role.assign' => 'Assigner des rôles aux utilisateurs',
            'user.history.view.any' => 'Voir l\'historique de tous les utilisateurs',
            'user.history.view.own' => 'Voir son propre historique',
        ];

        $this->createPermissions($permissions, 'User Management');
    }

    /**
     * Création des permissions pour la gestion des académies et départements
     */
    private function createAcademyManagementPermissions()
    {
        $permissions = [
            'academy.view' => 'Voir les académies',
            'academy.create' => 'Créer des académies',
            'academy.update' => 'Modifier des académies',
            'academy.delete' => 'Supprimer des académies',
            'department.view' => 'Voir les départements',
            'department.create' => 'Créer des départements',
            'department.update' => 'Modifier des départements',
            'department.delete' => 'Supprimer des départements',
            'center.view' => 'Voir les centres',
            'center.create' => 'Créer des centres',
            'center.update' => 'Modifier des centres',
            'center.delete' => 'Supprimer des centres',
            'staff.assign' => 'Assigner du personnel aux académies/centres',
        ];

        $this->createPermissions($permissions, 'Academy Management');
    }

    /**
     * Création des permissions pour la gestion financière
     */
    private function createFinancialManagementPermissions()
    {
        $permissions = [
            'finance.transaction.view' => 'Voir les transactions financières',
            'finance.transaction.create' => 'Créer des transactions financières',
            'finance.payment.student.view' => 'Voir les paiements des élèves',
            'finance.payment.student.create' => 'Enregistrer les paiements des élèves',
            'finance.payment.teacher.view' => 'Voir les paiements des enseignants',
            'finance.payment.teacher.create' => 'Créer les paiements des enseignants',
            'finance.expense.view' => 'Voir les dépenses',
            'finance.expense.create' => 'Créer des dépenses',
            'finance.revenue.view' => 'Voir les revenus',
            'finance.revenue.create' => 'Enregistrer des revenus',
            'finance.report.view' => 'Voir les rapports financiers',
            'finance.report.generate' => 'Générer des rapports financiers',
        ];

        $this->createPermissions($permissions, 'Financial Management');
    }

    /**
     * Création des permissions pour la gestion des cours
     */
    private function createCourseManagementPermissions()
    {
        $permissions = [
            'course.view' => 'Voir les cours',
            'course.create' => 'Créer des cours',
            'course.update' => 'Modifier des cours',
            'course.delete' => 'Supprimer des cours',
            'schedule.view' => 'Voir les plannings',
            'schedule.create' => 'Créer des plannings',
            'schedule.update' => 'Modifier des plannings',
            'schedule.delete' => 'Supprimer des plannings',
            'schedule.lock' => 'Verrouiller/déverrouiller les plannings',
            'teacher.assign' => 'Assigner des enseignants aux cours',
            'course.validate' => 'Valider la réalisation des cours',
            'attendance.view' => 'Voir les présences',
            'attendance.record' => 'Enregistrer les présences',
        ];

        $this->createPermissions($permissions, 'Course Management');
    }

    /**
     * Création des permissions pour la gestion des documents
     */
    private function createDocumentManagementPermissions()
    {
        $permissions = [
            'document.view' => 'Voir les documents',
            'document.create' => 'Créer des documents',
            'document.update' => 'Modifier des documents',
            'document.delete' => 'Supprimer des documents',
            'book.view' => 'Voir les livres',
            'book.create' => 'Ajouter des livres',
            'book.update' => 'Modifier des livres',
            'book.delete' => 'Supprimer des livres',
            'book.sale.validate' => 'Valider les ventes de livres',
        ];

        $this->createPermissions($permissions, 'Document Management');
    }

    /**
     * Création des permissions pour la gestion des concours
     */
    private function createCompetitionManagementPermissions()
    {
        $permissions = [
            'competition.view' => 'Voir les concours',
            'competition.create' => 'Créer des concours',
            'competition.update' => 'Modifier des concours',
            'competition.delete' => 'Supprimer des concours',
            'competition.supervise' => 'Superviser les concours',
            'competition.grade' => 'Noter les concours',
            'competition.publish' => 'Publier les résultats des concours',
        ];

        $this->createPermissions($permissions, 'Competition Management');
    }

    /**
     * Helper pour créer des permissions
     */
    private function createPermissions($permissions, $module)
    {
        foreach ($permissions as $name => $description) {
            Permission::create([
                'name' => $name,
                'guard_name' => 'web',
                'description' => $description,
                'module' => $module,
            ]);
        }
    }

    /**
     * Création des rôles nationaux
     */
    private function createNationalRoles()
    {
        // PCA - Administrateur suprême
        $pca = Role::create([
            'name' => 'PCA',
            'description' => 'Président du Conseil d\'Administration',
            'guard_name' => 'web',
        ]);
        
        // Donner toutes les permissions au PCA
        $pca->givePermissionTo(Permission::all());

        // DG-PREPAS - Direction générale
        $dgPrepas = Role::create([
            'name' => 'DG-PREPAS',
            'description' => 'Directeur Général des PREPAS',
            'guard_name' => 'web',
        ]);
        
        // Permissions exclues pour DG-PREPAS (exemple)
        $dgPrepas->givePermissionTo(Permission::all());

        // SG - Secrétaire Général
        $sg = Role::create([
            'name' => 'SG',
            'description' => 'Secrétaire Général',
            'guard_name' => 'web',
        ]);
        
        // Permissions pour SG (exclure certaines permissions financières)
        $sgPermissions = Permission::whereNotIn('name', [
            'finance.expense.create',
            'finance.revenue.create',
        ])->get();
        $sg->givePermissionTo($sgPermissions);

        // DA - Directeur Académique
        $da = Role::create([
            'name' => 'DA',
            'description' => 'Directeur Académique',
            'guard_name' => 'web',
        ]);
        
        // Permissions pour DA (focalisation sur les aspects académiques)
        $daPermissions = Permission::where('module', 'Academy Management')
            ->orWhere('module', 'Course Management')
            ->orWhere('module', 'Competition Management')
            ->orWhere('name', 'like', 'user.view%')
            ->orWhere('name', 'like', 'user.validate')
            ->get();
        $da->givePermissionTo($daPermissions);

        // DF Nationale - Direction Financière Nationale
        $dfNationale = Role::create([
            'name' => 'DF-Nationale',
            'description' => 'Directrice Financière Nationale',
            'guard_name' => 'web',
        ]);
        
        // Permissions pour DF Nationale (focalisation sur les finances)
        $dfPermissions = Permission::where('module', 'Financial Management')
            ->orWhere('name', 'like', 'user.view%')
            ->get();
        $dfNationale->givePermissionTo($dfPermissions);

        // DLN - Directeur Logistique National
        $dln = Role::create([
            'name' => 'DLN',
            'description' => 'Directeur Logistique National',
            'guard_name' => 'web',
        ]);
        
        // Permissions pour DLN (focalisation sur la logistique)
        $dlnPermissions = Permission::where('name', 'like', 'document%')
            ->orWhere('name', 'like', 'book%')
            ->orWhere('name', 'like', 'user.view%')
            ->get();
        $dln->givePermissionTo($dlnPermissions);
    }

    /**
     * Création des rôles au niveau de la ville
     */
    private function createCityRoles()
    {
        // DF de la Ville
        $dfVille = Role::create([
            'name' => 'DF-Ville',
            'description' => 'Directeur Financier de la Ville',
            'guard_name' => 'web',
        ]);
        
        // Permissions limitées à la ville
        $dfVillePermissions = Permission::where('module', 'Financial Management')
            ->where('name', 'not like', '%report.generate')
            ->orWhere('name', 'like', 'user.view%')
            ->get();
        $dfVille->givePermissionTo($dfVillePermissions);

        // Agent Financier
        $agentFinancier = Role::create([
            'name' => 'Agent-Financier',
            'description' => 'Agent Financier',
            'guard_name' => 'web',
        ]);
        
        // Permissions opérationnelles (transactions quotidiennes)
        $agentPermissions = Permission::whereIn('name', [
            'finance.payment.student.create',
            'finance.payment.student.view',
            'finance.transaction.view',
            'user.view.any',
            'book.sale.validate'
        ])->get();
        $agentFinancier->givePermissionTo($agentPermissions);

        // Directeur Logistique de la Ville
        $dlVille = Role::create([
            'name' => 'DL-Ville',
            'description' => 'Directeur Logistique de la Ville',
            'guard_name' => 'web',
        ]);
        
        // Permissions limitées à la logistique de la ville
        $dlVillePermissions = Permission::where('name', 'like', 'document%')
            ->orWhere('name', 'like', 'book%')
            ->orWhere('name', 'like', 'user.view%')
            ->get();
        $dlVille->givePermissionTo($dlVillePermissions);

        // Chef de Département
        $chefDepartement = Role::create([
            'name' => 'Chef-Departement',
            'description' => 'Chef de Département',
            'guard_name' => 'web',
        ]);
        
        // Permissions académiques départementales
        $chefDepPermissions = Permission::where('module', 'Course Management')
            ->orWhere('name', 'like', 'user.validate')
            ->orWhere('name', 'like', 'teacher.%')
            ->orWhere('name', 'like', 'user.view%')
            ->get();
        $chefDepartement->givePermissionTo($chefDepPermissions);
    }

    /**
     * Création des rôles au niveau du centre
     */
    private function createCenterRoles()
    {
        // Chef de Centre
        $chefCentre = Role::create([
            'name' => 'Chef-Centre',
            'description' => 'Chef de Centre',
            'guard_name' => 'web',
        ]);
        
        // Permissions de gestion de centre
        $chefCentrePermissions = Permission::where('name', 'like', 'center.%')
            ->orWhere('name', 'like', 'course.%')
            ->orWhere('name', 'like', 'schedule.%')
            ->orWhere('name', 'like', 'user.view%')
            ->orWhere('name', 'like', 'staff.assign')
            ->get();
        $chefCentre->givePermissionTo($chefCentrePermissions);

        // Responsable Académique du Centre
        $respAcademique = Role::create([
            'name' => 'Resp-Academique',
            'description' => 'Responsable Académique du Centre',
            'guard_name' => 'web',
        ]);
        
        // Permissions académiques de centre
        $respAcadPermissions = Permission::where('name', 'like', 'course.%')
            ->orWhere('name', 'like', 'schedule.view')
            ->orWhere('name', 'like', 'attendance.%')
            ->orWhere('name', 'like', 'user.view%')
            ->get();
        $respAcademique->givePermissionTo($respAcadPermissions);

        // Responsable Financier de Centre
        $respFinancier = Role::create([
            'name' => 'Resp-Financier',
            'description' => 'Responsable Financier du Centre',
            'guard_name' => 'web',
        ]);
        
        // Permissions financières limitées au centre
        $respFinPermissions = Permission::whereIn('name', [
            'finance.payment.student.create',
            'finance.payment.student.view',
            'finance.transaction.view',
            'book.sale.validate',
            'user.view.any'
        ])->get();
        $respFinancier->givePermissionTo($respFinPermissions);

        // Responsable Logistique du Centre
        $respLogistique = Role::create([
            'name' => 'Resp-Logistique',
            'description' => 'Responsable Logistique du Centre',
            'guard_name' => 'web',
        ]);
        
        // Permissions logistiques de centre
        $respLogPermissions = Permission::where('name', 'like', 'document.%')
            ->orWhere('name', 'like', 'book.%')
            ->where('name', 'not like', '%.delete')
            ->orWhere('name', 'like', 'user.view%')
            ->get();
        $respLogistique->givePermissionTo($respLogPermissions);

        // Personnel de Centre
        $personnel = Role::create([
            'name' => 'Personnel-Centre',
            'description' => 'Personnel de Centre',
            'guard_name' => 'web',
        ]);
        
        // Permissions basiques pour le personnel
        $personnelPermissions = Permission::whereIn('name', [
            'user.view.own',
            'user.update.own',
            'document.view',
            'book.view',
            'course.view',
            'schedule.view'
        ])->get();
        $personnel->givePermissionTo($personnelPermissions);
    }

    /**
     * Création des rôles pour les enseignants et élèves
     */
    private function createTeacherAndStudentRoles()
    {
        // Enseignant
        $enseignant = Role::create([
            'name' => 'Enseignant',
            'description' => 'Enseignant',
            'guard_name' => 'web',
        ]);
        
        // Permissions pour enseignants
        $enseignantPermissions = Permission::whereIn('name', [
            'user.view.own',
            'user.update.own',
            'user.history.view.own',
            'course.view',
            'schedule.view',
            'attendance.record',
            'document.view'
        ])->get();
        $enseignant->givePermissionTo($enseignantPermissions);

        // Élève
        $eleve = Role::create([
            'name' => 'Eleve',
            'description' => 'Élève',
            'guard_name' => 'web',
        ]);
        
        // Permissions pour élèves
        $elevePermissions = Permission::whereIn('name', [
            'user.view.own',
            'user.update.own',
            'user.history.view.own',
            'course.view',
            'schedule.view',
            'document.view',
            'book.view'
        ])->get();
        $eleve->givePermissionTo($elevePermissions);

        // Parent
        $parent = Role::create([
            'name' => 'Parent',
            'description' => 'Parent d\'élève',
            'guard_name' => 'web',
        ]);
        
        // Permissions pour parents
        $parentPermissions = Permission::whereIn('name', [
            'user.view.own',
            'user.update.own',
            'schedule.view'
        ])->get();
        $parent->givePermissionTo($parentPermissions);
    }
}