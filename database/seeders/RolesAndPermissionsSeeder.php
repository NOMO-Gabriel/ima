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
        // Module de Gestion des Utilisateurs
        $this->createPermissions([
            'user.view.any' => 'Voir tous les utilisateurs',
            'user.view.own' => 'Voir son propre profil',
            'user.create' => 'Créer des utilisateurs',
            'user.update.any' => 'Modifier tous les utilisateurs',
            'user.update.own' => 'Modifier son propre profil',
            'user.delete.any' => 'Supprimer des utilisateurs',
            'user.suspend' => 'Suspendre un compte utilisateur',
            'user.reactivate' => 'Réactiver un compte utilisateur',
            'user.validate' => 'Valider les inscriptions utilisateurs',
            'user.finalize' => 'Finaliser les comptes utilisateurs',
            'user.role.assign' => 'Assigner des rôles aux utilisateurs',
            'user.permission.assign' => 'Assigner des permissions aux utilisateurs',
            'user.history.view.any' => 'Voir l\'historique de tous les utilisateurs',
            'user.history.view.own' => 'Voir son propre historique',
            'user.password.reset' => 'Réinitialiser le mot de passe d\'un utilisateur',
        ], 'User Management');

        // Module de Gestion des Académies
        $this->createPermissions([
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
            'staff.assign.academy' => 'Assigner du personnel aux académies',
            'staff.assign.center' => 'Assigner du personnel aux centres',
            'formation.view' => 'Voir les formations',
            'formation.create' => 'Créer des formations',
            'formation.update' => 'Modifier des formations',
            'formation.delete' => 'Supprimer des formations',
            'content.view' => 'Voir le contenu pédagogique',
            'content.update' => 'Modifier le contenu pédagogique',
            'content.approve' => 'Approuver le contenu pédagogique',
        ], 'Academy Management');

        // Module de Gestion du Personnel
        $this->createPermissions([
            'staff.view' => 'Voir les profils du personnel',
            'staff.create' => 'Créer des profils de personnel',
            'staff.update' => 'Modifier des profils de personnel',
            'staff.delete' => 'Supprimer des profils de personnel',
            'teacher.register.validate' => 'Valider l\'inscription d\'un enseignant',
            'teacher.contract.create' => 'Créer un contrat d\'enseignant',
            'teacher.contract.view' => 'Consulter un contrat d\'enseignant',
            'teacher.contract.update' => 'Modifier un contrat d\'enseignant',
            'teacher.contract.validate' => 'Valider un contrat d\'enseignant',
            'teacher.contract.terminate' => 'Résilier un contrat d\'enseignant',
            'teacher.assign' => 'Assigner un enseignant à un département',
            'teacher.hours.calculate' => 'Calculer les heures travaillées',
            'teacher.evaluate' => 'Évaluer un enseignant',
        ], 'Staff Management');

        // Module de Gestion des Élèves
        $this->createPermissions([
            'student.view' => 'Consulter un profil élève',
            'student.register' => 'Enregistrer un élève',
            'student.update' => 'Modifier les informations d\'un élève',
            'student.delete' => 'Supprimer un compte élève',
            'student.contract.create' => 'Créer un contrat élève',
            'student.contract.view' => 'Consulter un contrat élève',
            'student.contract.update' => 'Modifier un contrat élève',
            'student.contract.validate' => 'Valider un contrat élève',
            'student.contract.suspend' => 'Suspendre un contrat élève',
            'student.contract.terminate' => 'Résilier un contrat élève',
            'student.assign.formation' => 'Assigner un élève à une formation',
            'student.assign.group' => 'Assigner un élève à un groupe',
            'student.attendance' => 'Enregistrer la présence d\'un élève',
            'student.grade' => 'Enregistrer les notes d\'un élève',
            'student.results.view' => 'Consulter les résultats d\'un élève',
        ], 'Student Management');

        // Module de Planification
        $this->createPermissions([
            'schedule.view' => 'Consulter un planning',
            'schedule.create' => 'Créer un planning',
            'schedule.update' => 'Modifier un planning',
            'schedule.delete' => 'Supprimer un planning',
            'schedule.lock' => 'Verrouiller un planning',
            'schedule.unlock' => 'Déverrouiller un planning',
            'schedule.export' => 'Exporter l\'emploi du temps',
            'course.view' => 'Consulter un cours',
            'course.create' => 'Créer un cours',
            'course.update' => 'Modifier un cours planifié',
            'course.cancel' => 'Annuler un cours planifié',
            'course.delete' => 'Supprimer un cours',
            'course.teacher.assign' => 'Affecter un enseignant à un cours',
            'course.teacher.replace' => 'Remplacer un enseignant',
            'course.room.assign' => 'Affecter une salle à un cours',
            'course.validate' => 'Valider la réalisation d\'un cours',
            'course.attendance' => 'Enregistrer les participants à un cours',
        ], 'Schedule Management');

        // Module Financier
        $this->createPermissions([
            'finance.transaction.view' => 'Consulter les transactions',
            'finance.balance.view' => 'Consulter le solde',
            'finance.payment.student.view' => 'Consulter un paiement élève',
            'finance.payment.student.create' => 'Enregistrer un paiement élève',
            'finance.payment.student.update' => 'Modifier un paiement élève',
            'finance.payment.student.cancel' => 'Annuler un paiement élève',
            'finance.payment.schedule.create' => 'Créer un échéancier de paiement',
            'finance.payment.reminder.send' => 'Envoyer un rappel de paiement',
            'finance.payment.teacher.calculate' => 'Calculer le paiement d\'un enseignant',
            'finance.payment.teacher.validate' => 'Valider le paiement d\'un enseignant',
            'finance.payment.execute' => 'Effectuer un paiement',
            'finance.income.record' => 'Enregistrer une entrée d\'argent',
            'finance.expense.create' => 'Effectuer une dépense',
            'finance.receipt.generate' => 'Générer un reçu',
            'finance.invoice.generate' => 'Générer une facture',
            'finance.report.view' => 'Consulter les bilans financiers',
            'finance.report.generate' => 'Générer un bilan financier',
            'finance.stats.view' => 'Consulter les statistiques financières',
        ], 'Financial Management');

        // Module Logistique
        $this->createPermissions([
            'logistics.order.create' => 'Créer une commande de matériel',
            'logistics.order.view' => 'Consulter une commande',
            'logistics.order.update' => 'Modifier une commande',
            'logistics.order.cancel' => 'Annuler une commande',
            'logistics.order.validate' => 'Valider une commande',
            'logistics.delivery.record' => 'Enregistrer une livraison',
            'logistics.delivery.validate' => 'Valider une livraison',
            'logistics.issue.report' => 'Signaler une non-conformité',
            'logistics.inventory.view' => 'Consulter l\'inventaire',
            'logistics.inventory.update' => 'Mettre à jour un stock',
            'book.catalog.view' => 'Consulter le catalogue de livres',
            'book.catalog.add' => 'Ajouter un livre au catalogue',
            'book.catalog.update' => 'Modifier un livre',
            'book.catalog.remove' => 'Supprimer un livre du catalogue',
            'book.sale.validate' => 'Valider la vente d\'un livre',
            'book.sale.cancel' => 'Annuler la vente d\'un livre',
        ], 'Logistics Management');

        // Module de Concours et Évaluations
        $this->createPermissions([
            'competition.view' => 'Consulter un concours blanc',
            'competition.create' => 'Créer un concours blanc',
            'competition.update' => 'Modifier un concours blanc',
            'competition.delete' => 'Supprimer un concours blanc',
            'competition.schedule' => 'Planifier un concours blanc',
            'competition.supervise' => 'Superviser un concours blanc',
            'competition.exam.create' => 'Enregistrer les sujets d\'examen',
            'competition.exam.view' => 'Consulter les sujets d\'examen',
            'competition.grade.record' => 'Enregistrer les notes',
            'competition.grade.update' => 'Modifier les notes',
            'competition.results.publish' => 'Publier les résultats',
            'competition.results.unpublish' => 'Dépublier les résultats',
            'competition.results.view' => 'Consulter les résultats',
            'competition.ranking.generate' => 'Générer un classement',
            'competition.results.export' => 'Exporter les résultats en PDF',
            'competition.archive' => 'Archiver un concours',
        ], 'Competition Management');

        // Module de Communication et Notifications
        $this->createPermissions([
            'notification.settings' => 'Configurer les paramètres de notification',
            'notification.template.create' => 'Créer un modèle de notification',
            'notification.template.view' => 'Consulter les modèles de notification',
            'notification.template.update' => 'Modifier un modèle de notification',
            'notification.template.delete' => 'Supprimer un modèle de notification',
            'notification.send.manual' => 'Envoyer une notification manuelle',
            'notification.send.auto' => 'Programmer une notification automatique',
            'notification.group.create' => 'Créer un message groupé',
            'notification.reminder.send' => 'Envoyer un rappel',
            'notification.history.view' => 'Consulter l\'historique des notifications',
            'notification.channel.manage' => 'Configurer les canaux de communication',
        ], 'Communication Management');

        // Module d'Historique et Traçabilité
        $this->createPermissions([
            'history.view.own' => 'Consulter son historique personnel',
            'history.view.user' => 'Consulter l\'historique d\'un utilisateur',
            'history.view.system' => 'Consulter l\'historique système',
            'history.filter' => 'Filtrer les entrées d\'historique',
            'history.export' => 'Exporter les données d\'historique',
            'history.report.generate' => 'Générer des rapports d\'activité',
            'history.archive' => 'Archiver des données historiques',
            'history.purge' => 'Purger des données historiques',
            'history.restore' => 'Restaurer des données archivées',
            'history.retention.configure' => 'Configurer la durée de conservation des données',
        ], 'History Management');
    }

    /**
     * Création des rôles et attribution des permissions
     */
    private function createAllRoles()
    {
        $this->createNationalRoles();
        $this->createCityRoles();
        $this->createCenterRoles();
        $this->createTeacherAndStudentRoles();
        $this->createExternalRoles();
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

        // Donner toutes les permissions au PCA
        $pca->givePermissionTo(Permission::all());

        // DG-PREPAS (Francophone et Anglophone)
        $dgPrepas = Role::create([
            'name' => 'dg-prepas',
            'description' => 'Directeur Général des PREPAS',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        // Exclure quelques permissions stratégiques
        $dgPermissions = Permission::whereNotIn('name', [
            'user.delete.any',
            'history.purge',
            'finance.report.generate'
        ])->get();
        $dgPrepas->givePermissionTo($dgPermissions);

        // SG - Secrétaire Général
        $sg = Role::create([
            'name' => 'sg',
            'description' => 'Secrétaire Général',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        // Permissions administratives sans accès complet aux finances
        $sgPermissions = Permission::where(function($query) {
            $query->where('module', 'User Management')
                  ->orWhere('module', 'Academy Management')
                  ->orWhere('module', 'Communication Management')
                  ->orWhere('module', 'History Management')
                  ->orWhere('name', 'like', 'finance.transaction.view')
                  ->orWhere('name', 'like', 'finance.balance.view')
                  ->orWhere('name', 'like', 'finance.report.view');
        })->get();
        $sg->givePermissionTo($sgPermissions);

        // DA - Directeur Académique
        $da = Role::create([
            'name' => 'da',
            'description' => 'Directeur Académique',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        // Permissions académiques et pédagogiques
        $daPermissions = Permission::where(function($query) {
            $query->where('module', 'Academy Management')
                  ->orWhere('module', 'Schedule Management')
                  ->orWhere('module', 'Competition Management')
                  ->orWhere('module', 'Staff Management')
                  ->orWhere('name', 'like', 'user.view%')
                  ->orWhere('name', 'like', 'student.view')
                  ->orWhere('name', 'like', 'student.results.view')
                  ->orWhere('name', 'like', 'schedule.lock')
                  ->orWhere('name', 'like', 'schedule.unlock');
        })->get();
        $da->givePermissionTo($daPermissions);

        // DF Nationale - Directrice Financière Nationale
        $dfNationale = Role::create([
            'name' => 'df-national',
            'description' => 'Directrice Financière Nationale',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        // Permissions financières complètes
        $dfPermissions = Permission::where(function($query) {
            $query->where('module', 'Financial Management')
                  ->orWhere('name', 'like', 'user.view%')
                  ->orWhere('name', 'like', 'history.view%')
                  ->orWhere('name', 'like', 'history.filter')
                  ->orWhere('name', 'like', 'history.export')
                  ->orWhere('name', 'like', 'notification.send%');
        })->get();
        $dfNationale->givePermissionTo($dfPermissions);

        // DLN - Directeur Logistique National
        $dln = Role::create([
            'name' => 'dln',
            'description' => 'Directeur Logistique National',
            'guard_name' => 'web',
            'level' => 'national',
        ]);

        // Permissions logistiques complètes
        $dlnPermissions = Permission::where(function($query) {
            $query->where('module', 'Logistics Management')
                  ->orWhere('name', 'like', 'user.view%')
                  ->orWhere('name', 'like', 'history.view%')
                  ->orWhere('name', 'like', 'history.filter')
                  ->orWhere('name', 'like', 'finance.expense.create');
        })->get();
        $dln->givePermissionTo($dlnPermissions);
    }

    /**
     * Création des rôles de niveau ville
     */
    private function createCityRoles()
    {
        // DF de la Ville
        $dfVille = Role::create([
            'name' => 'df-ville',
            'description' => 'Directeur Financier de la Ville',
            'guard_name' => 'web',
            'level' => 'city',
        ]);

        // Permissions financières limitées à la ville
        $dfVillePermissions = Permission::where(function($query) {
            $query->where('module', 'Financial Management')
                  ->whereNotIn('name', ['finance.report.generate'])
                  ->orWhere('name', 'like', 'student.contract.validate')
                  ->orWhere('name', 'like', 'user.view%')
                  ->orWhere('name', 'like', 'history.view%')
                  ->orWhere('name', 'like', 'history.filter');
        })->get();
        $dfVille->givePermissionTo($dfVillePermissions);

        // Agents Financiers
        $agentFinancier = Role::create([
            'name' => 'agent-financier',
            'description' => 'Agent Financier',
            'guard_name' => 'web',
            'level' => 'city',
        ]);

        // Permissions financières opérationnelles
        $agentPermissions = Permission::whereIn('name', [
            'finance.payment.student.create',
            'finance.payment.student.view',
            'finance.payment.student.update',
            'finance.income.record',
            'finance.receipt.generate',
            'finance.transaction.view',
            'user.view.any',
            'user.view.own',
            'user.update.own',
            'student.contract.view',
            'book.sale.validate',
            'history.view.own'
        ])->get();
        $agentFinancier->givePermissionTo($agentPermissions);

        // Directeur Logistique de la Ville
        $dlVille = Role::create([
            'name' => 'dl-ville',
            'description' => 'Directeur Logistique de la Ville',
            'guard_name' => 'web',
            'level' => 'city',
        ]);

        // Permissions logistiques de ville
        $dlVillePermissions = Permission::where(function($query) {
            $query->where('module', 'Logistics Management')
                  ->whereNotIn('name', ['logistics.order.cancel', 'book.catalog.remove'])
                  ->orWhere('name', 'like', 'user.view%')
                  ->orWhere('name', 'like', 'finance.expense.create')
                  ->orWhere('name', 'like', 'history.view.own');
        })->get();
        $dlVille->givePermissionTo($dlVillePermissions);

        // Chefs de Département
        $chefDepartement = Role::create([
            'name' => 'chef-departement',
            'description' => 'Chef de Département',
            'guard_name' => 'web',
            'level' => 'city',
        ]);

        // Permissions académiques départementales
        $chefDepPermissions = Permission::where(function($query) {
            $query->where('module', 'Schedule Management')
                  ->orWhere('name', 'like', 'teacher.%')
                  ->orWhere('name', 'like', 'course.%')
                  ->orWhere('name', 'like', 'user.view%')
                  ->orWhere('name', 'like', 'user.validate')
                  ->orWhere('name', 'like', 'content.%')
                  ->orWhere('name', 'like', 'competition.%')
                  ->orWhere('name', 'like', 'student.grade')
                  ->orWhere('name', 'like', 'student.results.view');
        })->get();
        $chefDepartement->givePermissionTo($chefDepPermissions);
    }

    /**
     * Création des rôles de niveau centre
     */
    private function createCenterRoles()
    {
        // Chef de Centre
        $chefCentre = Role::create([
            'name' => 'chef-centre',
            'description' => 'Chef de Centre',
            'guard_name' => 'web',
            'level' => 'center',
        ]);

        // Permissions de gestion de centre
        $chefCentrePermissions = Permission::where(function($query) {
            $query->where('name', 'like', 'center.%')
                  ->orWhere('name', 'like', 'student.%')
                  ->orWhere('name', 'like', 'course.%')
                  ->orWhere('name', 'like', 'schedule.%')
                  ->orWhere('name', 'like', 'user.view%')
                  ->orWhere('name', 'like', 'staff.assign.center')
                  ->orWhere('name', 'like', 'finance.transaction.view')
                  ->orWhere('name', 'like', 'finance.expense.create')
                  ->orWhere('name', 'like', 'history.view%');
        })->get();
        $chefCentre->givePermissionTo($chefCentrePermissions);

        // Responsable Académique du Centre
        $respAcademique = Role::create([
            'name' => 'resp-academique',
            'description' => 'Responsable Académique du Centre',
            'guard_name' => 'web',
            'level' => 'center',
        ]);

        // Permissions académiques de centre
        $respAcadPermissions = Permission::where(function($query) {
            $query->where('name', 'like', 'student.register')
                  ->orWhere('name', 'like', 'student.view')
                  ->orWhere('name', 'like', 'student.update')
                  ->orWhere('name', 'like', 'student.assign%')
                  ->orWhere('name', 'like', 'course.%')
                  ->orWhere('name', 'like', 'schedule.view')
                  ->orWhere('name', 'like', 'student.attendance')
                  ->orWhere('name', 'like', 'course.attendance')
                  ->orWhere('name', 'like', 'course.validate')
                  ->orWhere('name', 'like', 'competition.supervise')
                  ->orWhere('name', 'like', 'competition.results.view')
                  ->orWhere('name', 'like', 'user.view%');
        })->get();
        $respAcademique->givePermissionTo($respAcadPermissions);

        // Responsable Financier de Centre
        $respFinancier = Role::create([
            'name' => 'resp-financier',
            'description' => 'Responsable Financier du Centre',
            'guard_name' => 'web',
            'level' => 'center',
        ]);

        // Permissions financières de centre
        $respFinPermissions = Permission::whereIn('name', [
            'finance.payment.student.create',
            'finance.payment.student.view',
            'finance.payment.student.update',
            'finance.transaction.view',
            'finance.income.record',
            'finance.receipt.generate',
            'student.contract.validate',
            'student.contract.view',
            'book.sale.validate',
            'user.view.any',
            'user.view.own',
            'user.update.own',
            'history.view.own'
        ])->get();
        $respFinancier->givePermissionTo($respFinPermissions);

        // Responsable Logistique du Centre
        $respLogistique = Role::create([
            'name' => 'resp-logistique',
            'description' => 'Responsable Logistique du Centre',
            'guard_name' => 'web',
            'level' => 'center',
        ]);

        // Permissions logistiques de centre
        $respLogPermissions = Permission::where(function($query) {
            $query->where('name', 'like', 'logistics.order.create')
                  ->orWhere('name', 'like', 'logistics.order.view')
                  ->orWhere('name', 'like', 'logistics.delivery.record')
                  ->orWhere('name', 'like', 'logistics.delivery.validate')
                  ->orWhere('name', 'like', 'logistics.inventory%')
                  ->orWhere('name', 'like', 'logistics.issue.report')
                  ->orWhere('name', 'like', 'book.catalog.view')
                  ->orWhere('name', 'like', 'user.view%')
                  ->orWhere('name', 'like', 'user.update.own');
        })->get();
        $respLogistique->givePermissionTo($respLogPermissions);

        // Personnel de Centre
        $personnel = Role::create([
            'name' => 'personnel-centre',
            'description' => 'Personnel de Centre',
            'guard_name' => 'web',
            'level' => 'center',
        ]);

        // Permissions basiques pour le personnel
        $personnelPermissions = Permission::whereIn('name', [
            'user.view.own',
            'user.update.own',
            'user.history.view.own',
            'book.catalog.view',
            'course.view',
            'schedule.view',
            'student.view'
        ])->get();
        $personnel->givePermissionTo($personnelPermissions);
    }

    /**
     * Création des rôles d'enseignants et d'élèves
     */
    private function createTeacherAndStudentRoles()
    {
        // Enseignant
        $enseignant = Role::create([
            'name' => 'enseignant',
            'description' => 'Enseignant',
            'guard_name' => 'web',
            'level' => 'basic',
        ]);

        // Permissions pour enseignants
        $enseignantPermissions = Permission::whereIn('name', [
            'user.view.own',
            'user.update.own',
            'user.history.view.own',
            'course.view',
            'schedule.view',
            'schedule.export',
            'student.attendance',
            'course.attendance',
            'student.grade',
            'competition.exam.view',
            'competition.grade.record',
            'competition.results.view',
            'book.catalog.view'
        ])->get();
        $enseignant->givePermissionTo($enseignantPermissions);

        // Élève
        $eleve = Role::create([
            'name' => 'eleve',
            'description' => 'Élève',
            'guard_name' => 'web',
            'level' => 'basic',
        ]);

        // Permissions pour élèves
        $elevePermissions = Permission::whereIn('name', [
            'user.view.own',
            'user.update.own',
            'user.history.view.own',
            'course.view','schedule.view',
            'schedule.export',
            'competition.results.view',
            'book.catalog.view',
            'history.view.own'
        ])->get();
        $eleve->givePermissionTo($elevePermissions);
    }

    /**
     * Création des rôles externes
     */
    private function createExternalRoles()
    {
        // Parent
        $parent = Role::create([
            'name' => 'parent',
            'description' => 'Parent d\'élève',
            'guard_name' => 'web',
            'level' => 'external',
        ]);

        // Permissions pour parents
        $parentPermissions = Permission::whereIn('name', [
            'user.view.own',
            'user.update.own',
            'schedule.view',
            'finance.payment.student.view',
            'competition.results.view'
        ])->get();
        $parent->givePermissionTo($parentPermissions);

        // Service de Notification
        $serviceNotification = Role::create([
            'name' => 'service-notification',
            'description' => 'Service de Notification Automatique',
            'guard_name' => 'web',
            'level' => 'system',
        ]);

        // Permissions pour le service de notification
        $notificationPermissions = Permission::whereIn('name', [
            'notification.send.auto',
            'notification.reminder.send',
            'notification.history.view'
        ])->get();
        $serviceNotification->givePermissionTo($notificationPermissions);
    }
}