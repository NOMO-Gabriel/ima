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

        // Création de toutes les permissions
        $this->createAllPermissions();

        // Création des rôles et attribution des permissions
        $this->createAllRoles();
    }

    /**
     * Création de toutes les permissions de l'application
     */
    private function createAllPermissions()
    {
        // Module Administration des Utilisateurs
        $this->createPermissions([
            'admin.user.create' => 'Créer des utilisateurs',
            'admin.user.read' => 'Consulter les utilisateurs',
            'admin.user.update' => 'Modifier les utilisateurs',
            'admin.user.delete' => 'Supprimer des utilisateurs',
            'admin.teacher.create' => 'Créer des enseignants',
            'admin.teacher.read' => 'Consulter les enseignants',
            'admin.teacher.update' => 'Modifier les enseignants',
            'admin.teacher.delete' => 'Supprimer des enseignants',
            'admin.student.create' => 'Créer des élèves',
            'admin.student.read' => 'Consulter les élèves',
            'admin.student.update' => 'Modifier les élèves',
            'admin.student.delete' => 'Supprimer des élèves',
        ], 'User Administration');

        // Module Gestion des Structures
        $this->createPermissions([
            'gestion.academy.create' => 'Créer des académies',
            'gestion.academy.read' => 'Consulter les académies',
            'gestion.academy.update' => 'Modifier les académies',
            'gestion.academy.delete' => 'Supprimer des académies',
            'gestion.city.create' => 'Créer des villes',
            'gestion.city.read' => 'Consulter les villes',
            'gestion.city.update' => 'Modifier les villes',
            'gestion.city.delete' => 'Supprimer des villes',
            'gestion.center.create' => 'Créer des centres',
            'gestion.center.read' => 'Consulter les centres',
            'gestion.center.update' => 'Modifier les centres',
            'gestion.center.delete' => 'Supprimer des centres',
            'gestion.department.create' => 'Créer des départements',
            'gestion.department.read' => 'Consulter les départements',
            'gestion.department.update' => 'Modifier les départements',
            'gestiondepartment.delete' => 'Supprimer des départements',
            'gestion.phase.create' => 'Créer des phases',
            'gestion.phase.read' => 'Consulter les phases',
            'gestion.phase.update' => 'Modifier les phases',
            'gestion.phase.delete' => 'Supprimer des phases',
            'gestion.formation.create' => 'Créer des formations',
            'gestion.formation.read' => 'Consulter les formations',
            'gestion.formation.update' => 'Modifier les formations',
            'gestion.formation.delete' => 'Supprimer des formations',
            'gestion.course.create' => 'Créer des cours',
            'gestion.course.read' => 'Consulter les cours',
            'gestion.course.update' => 'Modifier les cours',
            'gestion.course.delete' => 'Supprimer des cours',
            'gestion.class.create' => 'Créer des classes',
            'gestion.class.read' => 'Consulter les classes',
            'gestion.class.update' => 'Modifier les classes',
            'gestion.class.delete' => 'Supprimer des classes',
            'gestion.exam.create' => 'Créer des examens',
            'gestion.exam.read' => 'Consulter les examens',
            'gestion.exam.update' => 'Modifier les examens',
            'gestion.exam.delete' => 'Supprimer des examens',
            'gestion.entrance-exam.create' => 'Créer des examens d\'entrée',
            'gestion.entrance-exam.read' => 'Consulter les examens d\'entrée',
            'gestion.entrance-exam.update' => 'Modifier les examens d\'entrée',
            'gestion.entrance-exam.delete' => 'Supprimer les examens d\'entrée',
        ], 'Structure Management');

        // Module Planification
        $this->createPermissions([
            'plannification.planning.create' => 'Créer des plannings',
            'plannification.planning.read' => 'Consulter les plannings',
            'plannification.planning.update' => 'Modifier les plannings',
            'plannification.planning.delete' => 'Supprimer des plannings',
            'plannification.slot.create' => 'Créer des créneaux',
            'plannification.slot.read' => 'Consulter les créneaux',
            'plannification.slot.update' => 'Modifier les créneaux',
            'plannification.slot.delete' => 'Supprimer des créneaux',
            'plannification.absence.create' => 'Créer des absences',
            'plannification.absence.read' => 'Consulter les absences',
            'plannification.absence.update' => 'Modifier les absences',
            'plannification.absence.delete' => 'Supprimer des absences',
        ], 'Planning Management');

        // Module Financier
        $this->createPermissions([
            'finance.registration.create' => 'Créer des inscriptions financières',
            'finance.registration.read' => 'Consulter les inscriptions financières',
            'finance.registration.update' => 'Modifier les inscriptions financières',
            'finance.registration.delete' => 'Supprimer les inscriptions financières',
            'finance.transaction.create' => 'Créer des transactions',
            'finance.transaction.read' => 'Consulter les transactions',
            'finance.transaction.update' => 'Modifier les transactions',
            'finance.transaction.delete' => 'Supprimer des transactions',
            'finance.histrory.create' => 'Créer des historiques financiers',
            'finance.histrory.update' => 'Modifier les historiques financiers',
            'finance.histrory.read' => 'Consulter les historiques financiers',
            'finance.histrory.delete' => 'Supprimer les historiques financiers',
        ], 'Financial Management');

        // Module Ressources
        $this->createPermissions([
            'ressource.book.create' => 'Créer des livres',
            'ressource.book.read' => 'Consulter les livres',
            'ressource.book.update' => 'Modifier les livres',
            'ressource.book.delete' => 'Supprimer des livres',
            'ressource.booklets.create' => 'Créer des fascicules',
            'ressource.booklets.read' => 'Consulter les fascicules',
            'ressource.booklets.update' => 'Modifier les fascicules',
            'ressource.booklets.delete' => 'Supprimer des fascicules',
            'ressource.material.create' => 'Créer du matériel',
            'ressource.material.read' => 'Consulter le matériel',
            'ressource.material.update' => 'Modifier le matériel',
            'ressource.material.delete' => 'Supprimer du matériel',
        ], 'Resource Management');

        // Module Profil et Historique
        $this->createPermissions([
            'profile.update' => 'Modifier son profil',
            'history.read' => 'Consulter l\'historique',
        ], 'Profile Management');
    }

    /**
     * Création des rôles et attribution des permissions
     */
    private function createAllRoles()
    {
        $this->createNationalRoles();
        $this->createCityRoles();
        $this->createCenterRoles();
        $this->createBasicRoles();
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
     * Création des rôles de niveau national
     */
    private function createNationalRoles()
    {
        // PCA - Président du Conseil d'Administration
        $pca = Role::create([
            'name' => 'pca',
            'description' => 'Président du Conseil d\'Administration',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        // Le PCA a toutes les permissions
        $pca->givePermissionTo(Permission::all());

        // Contrôleur
        $controleur = Role::create([
            'name' => 'controleur',
            'description' => 'Contrôleur',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        $controleur->givePermissionTo([
            'admin.user.read', 'admin.teacher.read', 'admin.student.read',
            'gestion.academy.read', 'gestion.city.read', 'gestion.center.read',
            'gestion.department.read', 'gestion.phase.read', 'gestion.formation.read',
            'gestion.course.read', 'gestion.class.read', 'gestion.exam.read',
            'gestion.entrance-exam.read', 'plannification.planning.read',
            'plannification.slot.read', 'plannification.absence.read',
            'finance.registration.read', 'finance.transaction.read',
            'finance.histrory.read', 'ressource.book.read', 'ressource.booklets.read',
            'ressource.material.read', 'profile.update', 'history.read'
        ]);

        // DG - Directeur Général
        $dg = Role::create([
            'name' => 'dg',
            'description' => 'Directeur Général',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        $dg->givePermissionTo([
            'admin.user.read', 'admin.user.update', 'admin.teacher.read',
            'admin.student.read', 'gestion.academy.read', 'gestion.academy.update',
            'gestion.city.read', 'gestion.city.update', 'gestion.center.read',
            'gestion.center.update', 'gestion.department.read', 'gestion.department.update',
            'gestion.phase.read', 'gestion.phase.update', 'gestion.formation.read',
            'gestion.formation.update', 'gestion.course.read', 'gestion.course.update',
            'gestion.class.read', 'gestion.class.update', 'gestion.exam.read',
            'gestion.exam.update', 'gestion.entrance-exam.read', 'gestion.entrance-exam.update',
            'plannification.planning.read', 'plannification.planning.update',
            'plannification.slot.read', 'plannification.slot.update',
            'plannification.absence.read', 'plannification.absence.update',
            'finance.registration.read', 'finance.registration.update',
            'finance.transaction.read', 'finance.transaction.update',
            'finance.histrory.read', 'finance.histrory.update',
            'ressource.book.read', 'ressource.book.update',
            'ressource.booklets.read', 'ressource.booklets.update',
            'ressource.material.read', 'ressource.material.update',
            'profile.update', 'history.read'
        ]);

        // SG - Secrétaire Général
        $sg = Role::create([
            'name' => 'sg',
            'description' => 'Secrétaire Général',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        $sg->givePermissionTo([
            'admin.user.create', 'admin.user.read', 'admin.user.update',
            'admin.teacher.read', 'admin.student.read',
            'gestion.academy.create', 'gestion.academy.read', 'gestion.academy.update',
            'gestion.city.create', 'gestion.city.read', 'gestion.city.update',
            'gestion.center.create', 'gestion.center.read', 'gestion.center.update',
            'gestion.department.create', 'gestion.department.read', 'gestion.department.update',
            'gestion.phase.create', 'gestion.phase.read', 'gestion.phase.update',
            'gestion.formation.create', 'gestion.formation.read', 'gestion.formation.update',
            'gestion.course.create', 'gestion.course.read', 'gestion.course.update',
            'gestion.class.create', 'gestion.class.read', 'gestion.class.update',
            'gestion.exam.create', 'gestion.exam.read', 'gestion.exam.update',
            'gestion.entrance-exam.create', 'gestion.entrance-exam.read', 'gestion.entrance-exam.update',
            'plannification.planning.create', 'plannification.planning.read', 'plannification.planning.update',
            'plannification.slot.create', 'plannification.slot.read', 'plannification.slot.update',
            'plannification.absence.create', 'plannification.absence.read', 'plannification.absence.update',
            'ressource.book.create', 'ressource.book.read', 'ressource.book.update',
            'ressource.booklets.create', 'ressource.booklets.read', 'ressource.booklets.update',
            'ressource.material.create', 'ressource.material.read', 'ressource.material.update',
            'profile.update', 'history.read'
        ]);

        // DA - Directeur Académique
        $da = Role::create([
            'name' => 'da',
            'description' => 'Directeur Académique',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        $da->givePermissionTo([
            'admin.user.create', 'admin.user.read', 'admin.user.update', 'admin.user.delete',
            'admin.teacher.create', 'admin.teacher.read', 'admin.teacher.update', 'admin.teacher.delete',
            'admin.student.read', 'gestion.academy.read', 'gestion.city.read',
            'gestion.center.read', 'gestion.department.read', 'gestion.phase.read',
            'gestion.formation.read', 'gestion.course.read', 'gestion.class.read',
            'gestion.exam.read', 'gestion.entrance-exam.read',
            'plannification.planning.read', 'plannification.slot.read',
            'plannification.absence.read', 'profile.update', 'history.read'
        ]);

        // Responsable Livres National
        $responsable_livres = Role::create([
            'name' => 'responsable-livres',
            'description' => 'Responsable Livres',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        $responsable_livres->givePermissionTo([
            'admin.student.read', 'gestion.academy.read', 'gestion.city.read',
            'gestion.center.read', 'gestion.department.read', 'gestion.phase.read',
            'gestion.formation.read', 'gestion.course.read', 'gestion.class.read',
            'gestion.exam.read', 'gestion.entrance-exam.read',
            'ressource.book.create', 'ressource.book.read', 'ressource.book.update', 'ressource.book.delete',
            'ressource.booklets.create', 'ressource.booklets.read', 'ressource.booklets.update', 'ressource.booklets.delete',
            'ressource.material.create', 'ressource.material.read', 'ressource.material.update', 'ressource.material.delete',
            'profile.update', 'history.read'
        ]);

        // DF National - Directeur Financier National
        $df_national = Role::create([
            'name' => 'df-national',
            'description' => 'Directeur Financier National',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        $df_national->givePermissionTo([
            'admin.user.read', 'admin.teacher.read', 'admin.student.read',
            'gestion.academy.read', 'gestion.city.read', 'gestion.center.read',
            'gestion.department.read', 'gestion.phase.read', 'gestion.formation.read',
            'gestion.course.read', 'gestion.class.read', 'gestion.exam.read',
            'gestion.entrance-exam.read', 'finance.registration.create',
            'finance.registration.read', 'finance.registration.update', 'finance.registration.delete',
            'finance.transaction.create', 'finance.transaction.read',
            'finance.transaction.update', 'finance.transaction.delete',
            'finance.histrory.create', 'finance.histrory.update',
            'finance.histrory.read', 'finance.histrory.delete',
            'profile.update', 'history.read'
        ]);

        // DL National - Directeur Logistique National
        $dl_national = Role::create([
            'name' => 'dl-national',
            'description' => 'Directeur Logistique National',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        $dl_national->givePermissionTo([
            'admin.student.read', 'gestion.academy.read', 'gestion.city.read',
            'gestion.center.read', 'gestion.department.read', 'gestion.phase.read',
            'gestion.formation.read', 'gestion.course.read', 'gestion.class.read',
            'gestion.exam.read', 'gestion.entrance-exam.read',
            'ressource.book.create', 'ressource.book.read', 'ressource.book.update', 'ressource.book.delete',
            'ressource.booklets.create', 'ressource.booklets.read', 'ressource.booklets.update', 'ressource.booklets.delete',
            'ressource.material.create', 'ressource.material.read', 'ressource.material.update', 'ressource.material.delete',
            'profile.update', 'history.read'
        ]);
    }

    /**
     * Création des rôles de niveau ville
     */
    private function createCityRoles()
    {
        // DDO Ville - Directeur Délégué Opérationnel
        $ddo_ville = Role::create([
            'name' => 'ddo-ville',
            'description' => 'Directeur Délégué Opérationnel de Ville',
            'guard_name' => 'web',
            'level' => 'city',
        ]);

        $ddo_ville->givePermissionTo([
            'admin.user.read', 'admin.teacher.read', 'admin.student.read',
            'gestion.academy.read', 'gestion.city.read', 'gestion.center.read',
            'gestion.department.read', 'gestion.phase.read', 'gestion.formation.read',
            'gestion.course.read', 'gestion.class.read', 'gestion.exam.read',
            'gestion.entrance-exam.read', 'plannification.planning.read',
            'plannification.slot.read', 'plannification.absence.read',
            'finance.registration.read', 'finance.transaction.read',
            'finance.histrory.read', 'ressource.book.read', 'ressource.booklets.read',
            'ressource.material.read', 'profile.update', 'history.read'
        ]);

        // SUP Ville - Superviseur
        $superviseur_ville = Role::create([
            'name' => 'superviseur-ville',
            'description' => 'Superviseur de Ville',
            'guard_name' => 'web',
            'level' => 'city',
        ]);

        $superviseur_ville->givePermissionTo([
            'admin.user.read', 'admin.teacher.read', 'admin.student.read',
            'gestion.academy.read', 'gestion.city.read', 'gestion.center.read',
            'gestion.department.read', 'gestion.phase.read', 'gestion.formation.read',
            'gestion.course.read', 'gestion.class.read', 'gestion.exam.read',
            'gestion.entrance-exam.read', 'plannification.planning.read',
            'plannification.slot.read', 'plannification.absence.read',
            'finance.registration.read', 'finance.transaction.read',
            'finance.histrory.read', 'ressource.book.read', 'ressource.booklets.read',
            'ressource.material.read', 'profile.update', 'history.read'
        ]);

        // DF Ville - Directeur Financier de Ville
        $df_ville = Role::create([
            'name' => 'df-ville',
            'description' => 'Directeur Financier de Ville',
            'guard_name' => 'web',
            'level' => 'city',
        ]);

        $df_ville->givePermissionTo([
            'admin.user.create', 'admin.user.read', 'admin.user.update', 'admin.user.delete',
            'admin.teacher.read', 'admin.student.read', 'gestion.academy.read',
            'gestion.city.read', 'gestion.center.read', 'gestion.department.read',
            'gestion.phase.read', 'gestion.formation.read', 'gestion.course.read',
            'gestion.class.read', 'gestion.exam.read', 'gestion.entrance-exam.read',
            'plannification.planning.read', 'plannification.slot.read',
            'plannification.absence.read', 'finance.registration.create',
            'finance.registration.read', 'finance.registration.update', 'finance.registration.delete',
            'finance.transaction.create', 'finance.transaction.read',
            'finance.transaction.update', 'finance.transaction.delete',
            'finance.histrory.create', 'finance.histrory.update',
            'finance.histrory.read', 'finance.histrory.delete',
            'ressource.book.read', 'ressource.booklets.read', 'ressource.material.read',
            'profile.update', 'history.read'
        ]);

        // DL Ville - Directeur Logistique de Ville
        $dl_ville = Role::create([
            'name' => 'dl-ville',
            'description' => 'Directeur Logistique de Ville',
            'guard_name' => 'web',
            'level' => 'city',
        ]);

        $dl_ville->givePermissionTo([
            'admin.student.read', 'gestion.academy.read', 'gestion.city.read',
            'gestion.center.read', 'gestion.department.read', 'gestion.phase.read',
            'gestion.formation.read', 'gestion.course.read', 'gestion.class.read',
            'gestion.exam.read', 'gestion.entrance-exam.read',
            'ressource.book.create', 'ressource.book.read', 'ressource.book.update', 'ressource.book.delete',
            'ressource.booklets.create', 'ressource.booklets.read', 'ressource.booklets.update', 'ressource.booklets.delete',
            'ressource.material.create', 'ressource.material.read', 'ressource.material.update', 'ressource.material.delete',
            'profile.update', 'history.read'
        ]);

        // AF - Agent Financier
        $agent_financier = Role::create([
            'name' => 'agent-financier',
            'description' => 'Agent Financier',
            'guard_name' => 'web',
            'level' => 'city',
        ]);

        $agent_financier->givePermissionTo([
            'admin.user.read', 'admin.teacher.read', 'admin.student.read',
            'gestion.academy.read', 'gestion.city.read', 'gestion.center.read',
            'gestion.department.read', 'gestion.phase.read', 'gestion.formation.read',
            'gestion.course.read', 'gestion.class.read', 'gestion.exam.read',
            'gestion.entrance-exam.read', 'finance.registration.read',
            'finance.transaction.read', 'finance.histrory.read',
            'ressource.book.read', 'ressource.booklets.read', 'ressource.material.read',
            'profile.update', 'history.read'
        ]);

        // CD - Chef de Département
        $chef_departement = Role::create([
            'name' => 'chef-departement',
            'description' => 'Chef de Département',
            'guard_name' => 'web',
            'level' => 'city',
        ]);

        $chef_departement->givePermissionTo([
            'admin.teacher.read', 'gestion.academy.read', 'gestion.city.read',
            'gestion.center.read', 'gestion.department.read', 'gestion.phase.read',
            'gestion.formation.read', 'gestion.course.read', 'gestion.class.read',
            'gestion.exam.read', 'gestion.entrance-exam.read',
            'plannification.planning.read', 'plannification.slot.read',
            'plannification.absence.read', 'profile.update', 'history.read'
        ]);

        // RA Ville - Responsable Académique de Ville
        $ra_ville = Role::create([
            'name' => 'responsable-academique-ville',
            'description' => 'Responsable Académique de Ville',
            'guard_name' => 'web',
            'level' => 'city',
        ]);

        $ra_ville->givePermissionTo([
            'admin.user.create', 'admin.user.read', 'admin.user.update', 'admin.user.delete',
            'admin.teacher.create', 'admin.teacher.read', 'admin.teacher.update', 'admin.teacher.delete',
            'admin.student.read', 'gestion.academy.read', 'gestion.city.read',
            'gestion.center.read', 'gestion.department.read', 'gestion.phase.read',
            'gestion.formation.read', 'gestion.course.read', 'gestion.class.read',
            'gestion.exam.read', 'gestion.entrance-exam.read',
            'plannification.planning.read', 'plannification.slot.read',
            'plannification.absence.read', 'profile.update', 'history.read'
        ]);

        // Enseignant
        $enseignant = Role::create([
            'name' => 'enseignant',
            'description' => 'Enseignant',
            'guard_name' => 'web',
            'level' => 'basic',
        ]);

        $enseignant->givePermissionTo([
            'admin.user.read', 'admin.teacher.read', 'gestion.academy.read',
            'gestion.city.read', 'gestion.center.read', 'gestion.department.read',
            'gestion.phase.read', 'gestion.formation.read', 'gestion.course.read',
            'gestion.class.read', 'gestion.exam.read', 'gestion.entrance-exam.read',
            'plannification.planning.read', 'plannification.slot.read',
            'plannification.absence.read', 'ressource.book.read',
            'ressource.booklets.read', 'ressource.material.read',
            'profile.update', 'history.read'
        ]);
    }

    /**
     * Création des rôles de niveau centre
     */
    private function createCenterRoles()
    {
        // CC - Chef de Centre
        $chef_centre = Role::create([
            'name' => 'chef-centre',
            'description' => 'Chef de Centre',
            'guard_name' => 'web',
            'level' => 'center',
        ]);

        $chef_centre->givePermissionTo([
            'admin.user.read', 'admin.user.update', 'admin.teacher.read',
            'admin.student.create', 'admin.student.read', 'admin.student.update',
            'gestion.academy.read', 'gestion.city.read', 'gestion.center.read',
            'gestion.department.read', 'gestion.phase.read', 'gestion.formation.read',
            'gestion.course.read', 'gestion.class.read', 'gestion.exam.read',
            'gestion.entrance-exam.read', 'plannification.planning.read',
            'plannification.slot.read', 'plannification.absence.read',
            'finance.registration.read', 'finance.transaction.read',
            'finance.histrory.read', 'ressource.book.read', 'ressource.booklets.read',
            'ressource.material.read', 'profile.update', 'history.read'
        ]);

        // RA Centre - Responsable Académique de Centre
        $ra_centre = Role::create([
            'name' => 'responsable-academique-centre',
            'description' => 'Responsable Académique de Centre',
            'guard_name' => 'web',
            'level' => 'center',
        ]);

        $ra_centre->givePermissionTo([
            'admin.user.read', 'admin.teacher.read', 'admin.student.create',
            'admin.student.read', 'admin.student.update', 'gestion.academy.read',
            'gestion.city.read', 'gestion.center.read', 'gestion.department.read',
            'gestion.phase.read', 'gestion.formation.read', 'gestion.course.read',
            'gestion.class.read', 'gestion.exam.read', 'gestion.entrance-exam.read',
            'plannification.planning.read', 'plannification.slot.read',
            'plannification.absence.read', 'finance.registration.read',
            'finance.transaction.read', 'finance.histrory.read',
            'ressource.book.read', 'ressource.booklets.read', 'ressource.material.read',
            'profile.update', 'history.read'
        ]);

        // RF Centre - Responsable Financier de Centre
        $rf_centre = Role::create([
            'name' => 'responsable-financier-centre',
            'description' => 'Responsable Financier de Centre',
            'guard_name' => 'web',
            'level' => 'center',
        ]);

        $rf_centre->givePermissionTo([
            'admin.user.read', 'admin.teacher.read', 'admin.student.create',
            'admin.student.read', 'admin.student.update', 'gestion.academy.read',
            'gestion.city.read', 'gestion.center.read', 'gestion.department.read',
            'gestion.phase.read', 'gestion.formation.read', 'gestion.course.read',
            'gestion.class.read', 'gestion.exam.read', 'gestion.entrance-exam.read',
            'plannification.planning.read', 'plannification.slot.read',
            'plannification.absence.read', 'finance.registration.read',
            'finance.transaction.read', 'finance.histrory.read',
            'ressource.book.read', 'ressource.booklets.read', 'ressource.material.read',
            'profile.update', 'history.read'
        ]);

        // RL Centre - Responsable Logistique de Centre
        $rl_centre = Role::create([
            'name' => 'responsable-logistique-centre',
            'description' => 'Responsable Logistique de Centre',
            'guard_name' => 'web',
            'level' => 'center',
        ]);

        $rl_centre->givePermissionTo([
            'admin.user.read', 'admin.teacher.read', 'admin.student.create',
            'admin.student.read', 'admin.student.update', 'gestion.academy.read',
            'gestion.city.read', 'gestion.center.read', 'gestion.department.read',
            'gestion.phase.read', 'gestion.formation.read', 'gestion.course.read',
            'gestion.class.read', 'gestion.exam.read', 'gestion.entrance-exam.read',
            'plannification.planning.read', 'plannification.slot.read',
            'plannification.absence.read', 'finance.registration.read',
            'finance.transaction.read', 'finance.histrory.read',
            'ressource.book.read', 'ressource.booklets.read', 'ressource.material.read',
            'profile.update', 'history.read'
        ]);

        // Personnel de Centre
        $personnel_centre = Role::create([
            'name' => 'personnel-centre',
            'description' => 'Personnel de Centre',
            'guard_name' => 'web',
            'level' => 'center',
        ]);

        $personnel_centre->givePermissionTo([
            'admin.user.read', 'admin.teacher.read', 'admin.student.create',
            'admin.student.read', 'admin.student.update', 'gestion.academy.read',
            'gestion.city.read', 'gestion.center.read', 'gestion.department.read',
            'gestion.phase.read', 'gestion.formation.read', 'gestion.course.read',
            'gestion.class.read', 'gestion.exam.read', 'gestion.entrance-exam.read',
            'plannification.planning.read', 'plannification.slot.read',
            'plannification.absence.read', 'finance.registration.read',
            'finance.transaction.read', 'finance.histrory.read',
            'ressource.book.read', 'ressource.booklets.read', 'ressource.material.read',
            'profile.update', 'history.read'
        ]);
    }

    /**
     * Création des rôles de base
     */
    private function createBasicRoles()
    {
        // Élève
        $eleve = Role::create([
            'name' => 'eleve',
            'description' => 'Élève',
            'guard_name' => 'web',
            'level' => 'basic',
        ]);

        $eleve->givePermissionTo([
            'plannification.planning.read', 'plannification.slot.read',
            'plannification.absence.read', 'ressource.book.read',
            'ressource.booklets.read', 'ressource.material.read',
            'profile.update', 'history.read'
        ]);
    }
}