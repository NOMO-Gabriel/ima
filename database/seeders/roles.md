Voici la répartition des permissions pour chaque rôle identifié dans le système IMA-ICORP, basée sur l'analyse des documents fournis:

# Permissions par rôle

## Niveau Administratif National

### PCA (Président du Conseil d'Administration)
- **Module de Gestion des Utilisateurs**: Toutes les permissions
- **Module Académique**: Toutes les permissions
- **Module de Gestion du Personnel**: Toutes les permissions
- **Module de Gestion des Élèves**: Toutes les permissions
- **Module de Planification**: Toutes les permissions
- **Module Financier**: Toutes les permissions
- **Module Logistique**: Toutes les permissions
- **Module de Concours et Évaluations**: Toutes les permissions
- **Module de Communication**: Toutes les permissions
- **Module d'Historique**: Toutes les permissions

### DG-PREPAS (Francophone et Anglophone)
- **Gestion des Utilisateurs**:
  - Créer, consulter, modifier, supprimer un compte utilisateur
  - Valider l'inscription d'un utilisateur
  - Finaliser la validation d'un compte
  - Suspendre et réactiver un compte
  - Attribuer des rôles et modifier des permissions
  - Consulter l'historique d'un utilisateur
  
- **Module Académique**:
  - Créer, consulter, modifier, supprimer une académie
  - Assigner du personnel à une académie
  - Créer, consulter, modifier, supprimer une formation
  - Créer, consulter, modifier, supprimer un centre
  - Approuver le contenu pédagogique
  
- **Autres modules**: Accès similaire au PCA avec quelques restrictions sur les suppressions critiques

### SG (Secrétaire Général)
- **Gestion des Utilisateurs**:
  - Créer, consulter, modifier un compte utilisateur
  - Valider l'inscription d'un utilisateur
  - Suspendre et réactiver un compte
  - Consulter la liste des utilisateurs
  
- **Module Académique**:
  - Consulter une académie
  - Consulter une formation
  - Consulter un centre
  
- **Module de Communication**:
  - Toutes les permissions
  
- **Module d'Historique**:
  - Consulter l'historique d'un utilisateur
  - Générer des rapports d'activité

### DA (Directeurs Académiques)
- **Gestion des Utilisateurs**:
  - Créer, consulter, modifier un compte utilisateur académique
  - Valider l'inscription d'un enseignant
  - Consulter l'historique d'un utilisateur académique
  
- **Module Académique**:
  - Consulter, modifier une académie
  - Créer, consulter, modifier, supprimer une formation
  - Assigner du personnel à une académie
  - Consulter, modifier un centre
  
- **Module de Gestion du Personnel**:
  - Valider un contrat d'enseignant
  - Assigner un enseignant à un département
  
- **Module de Planification**:
  - Verrouiller/déverrouiller un planning
  - Valider la réalisation d'un cours
  
- **Module de Concours**:
  - Toutes les permissions

### DF Nationale (Directrice Financière Nationale)
- **Module Financier**:
  - Toutes les permissions
  
- **Gestion des Utilisateurs**:
  - Consulter un compte utilisateur
  - Consulter l'historique financier d'un utilisateur
  
- **Module d'Historique**:
  - Consulter l'historique des transactions
  - Générer des rapports financiers

### DLN (Directeur Logistique National)
- **Module Logistique**:
  - Toutes les permissions
  
- **Module Financier**:
  - Effectuer une dépense (liée à la logistique)
  - Valider une commande
  
- **Gestion des Utilisateurs**:
  - Consulter un compte utilisateur logistique

## Niveau Administratif Local (Ville)

### DF de la Ville
- **Module Financier**:
  - Enregistrer, consulter, modifier, annuler un paiement élève
  - Calculer et valider le paiement d'un enseignant
  - Effectuer une dépense (dans la limite de son niveau)
  - Enregistrer une entrée d'argent
  - Générer un reçu ou une facture
  - Générer un bilan financier local
  
- **Gestion des Élèves**:
  - Valider un contrat élève
  - Consulter un contrat élève
  
- **Module d'Historique**:
  - Consulter l'historique des transactions de sa ville

### Agents Financiers
- **Module Financier**:
  - Enregistrer un paiement élève
  - Consulter un paiement élève
  - Enregistrer une entrée d'argent
  - Générer un reçu
  
- **Gestion des Élèves**:
  - Consulter un contrat élève

### Directeur Logistique de la Ville
- **Module Logistique**:
  - Créer, consulter, modifier une commande de matériel
  - Valider une commande (dans la limite de son niveau)
  - Enregistrer et valider une livraison
  - Consulter l'inventaire
  - Valider la vente d'un livre
  
- **Module Financier**:
  - Effectuer une dépense (liée à la logistique locale)

### Chefs de Département
- **Gestion du Personnel**:
  - Valider l'inscription d'un enseignant
  - Créer, consulter, modifier un contrat d'enseignant
  - Evaluer un enseignant
  
- **Module de Planification**:
  - Créer, consulter, modifier un planning
  - Planifier un cours
  - Affecter un enseignant à un cours
  - Valider la réalisation d'un cours
  
- **Module de Concours**:
  - Créer, modifier un concours blanc
  - Enregistrer les sujets d'examen
  - Publier les résultats
  
- **Module Académique**:
  - Modifier le contenu pédagogique

### Enseignants
- **Module de Planification**:
  - Consulter l'emploi du temps
  - Enregistrer les participants à un cours
  
- **Gestion des Élèves**:
  - Enregistrer la présence d'un élève
  - Enregistrer les notes d'un élève
  
- **Module de Concours**:
  - Consulter les sujets d'examen
  - Enregistrer les notes
  
- **Module d'Historique**:
  - Consulter son historique personnel

## Niveau Centre (Opérationnel)

### Chef de Centre
- **Gestion des Utilisateurs**:
  - Consulter, modifier un compte utilisateur de son centre
  
- **Gestion des Élèves**:
  - Toutes les permissions pour les élèves de son centre
  
- **Module de Planification**:
  - Consulter, modifier un planning de son centre
  - Valider la réalisation d'un cours
  
- **Module Financier**:
  - Consulter les transactions de son centre
  - Effectuer une dépense (dans la limite de son niveau)
  
- **Module d'Historique**:
  - Consulter l'historique des activités de son centre

### Responsable Académique du Centre
- **Gestion des Élèves**:
  - Enregistrer un élève
  - Consulter, modifier les informations d'un élève
  - Assigner un élève à une formation ou un groupe
  
- **Module de Planification**:
  - Consulter un planning
  - Enregistrer les participants à un cours
  - Valider la réalisation d'un cours
  
- **Module de Concours**:
  - Superviser un concours blanc
  - Consulter les résultats

### Responsables Financiers de Centre
- **Module Financier**:
  - Enregistrer un paiement élève
  - Consulter un paiement élève
  - Enregistrer une entrée d'argent
  - Générer un reçu
  - Consulter les transactions du centre
  
- **Gestion des Élèves**:
  - Valider un contrat élève
  - Consulter un contrat élève

### Responsable Logistique du Centre
- **Module Logistique**:
  - Créer une commande de matériel
  - Consulter une commande
  - Enregistrer une livraison
  - Mettre à jour un stock
  - Consulter l'inventaire
  
- **Module Financier**:
  - Valider la vente d'un livre

### Personnels de Centre
- **Module de Planification**:
  - Consulter l'emploi du temps
  
- **Gestion des Élèves**:
  - Consulter un profil élève (limité)
  
- **Module d'Historique**:
  - Consulter son historique personnel

### Élèves
- **Module de Planification**:
  - Consulter l'emploi du temps
  
- **Module de Concours**:
  - Consulter les résultats
  
- **Module d'Historique**:
  - Consulter son historique personnel

## Utilisateurs Externes

### Parents
- **Module de Planification**:
  - Consulter l'emploi du temps de leur enfant
  
- **Module de Concours**:
  - Consulter les résultats de leur enfant
  
- **Module Financier**:
  - Consulter les paiements effectués

### Service de Notification
- **Module de Communication**:
  - Envoyer une notification automatique
  - Programmer une notification automatique
  - Envoyer un rappel

Cette répartition des permissions reflète la structure hiérarchique décrite dans les documents fournis et permet de mettre en œuvre un contrôle d'accès granulaire adapté aux besoins de l'organisation. Les permissions sont attribuées selon le principe du moindre privilège, où chaque rôle a accès uniquement aux fonctionnalités nécessaires à l'exécution de ses responsabilités.