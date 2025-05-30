<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'parent_phone_number',
        // 'city_id',
        // 'city', // Pour la compatibilité
        'address',
        'account_type',
        'profile_photo_path',
        'status',
        // 'establishment', // Pour les élèves
        // 'wanted_entrance_exams', // Pour les élèves
        // 'contract_details', // Détails du contrat
        'validated_by',
        'validated_at',
        'finalized_by',
        'finalized_at',
        'rejection_reason',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'validated_at' => 'datetime',
        'finalized_at' => 'datetime',
        'wanted_entrance_exams' => 'array', // Cast en array pour stocker les concours
        'contract_details' => 'array', // Cast en array pour stocker les détails du contrat
        'gender' => 'integer',
    ];

    // Statuts possibles pour les utilisateurs
    const STATUS_PENDING_VALIDATION = 'pending_validation'; // En attente de validation par responsable financière
    const STATUS_PENDING_CONTRACT = 'pending_contract'; // En attente d'assignation de contrat et concours
    const STATUS_ACTIVE = 'active'; // Compte activé
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_REJECTED = 'rejected';
    const STATUS_ARCHIVED = 'archived';


    /**
     * Retourne un tableau associatif des statuts possibles avec leurs labels.
     * Utilisé pour peupler les dropdowns de filtre, par exemple.
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING_VALIDATION => 'En attente de validation',
            self::STATUS_PENDING_CONTRACT => 'En attente de contrat',
            // self::STATUS_PENDING_FINALIZATION => 'En attente de finalisation', // Ajouté
            self::STATUS_ACTIVE => 'Actif',
            self::STATUS_SUSPENDED => 'Suspendu',
            self::STATUS_REJECTED => 'Rejeté',
            self::STATUS_ARCHIVED => 'Archivé',
        ];
    }

    /**
     * Accessor pour obtenir le label lisible du statut actuel de l'utilisateur.
     * Utilisé pour l'affichage : $user->status_label
     *
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status ?? 'Inconnu'));
    }


    //les genres

    const GENDER_UNSPECIFIED = 0; // Ou ce que vous avez comme défaut
    const GENDER_MALE = 1;        // Adaptez les valeurs si nécessaire
    const GENDER_FEMALE = 2;

    public static function getGenders()
    {
        return [
            self::GENDER_MALE => 'Masculin',
            self::GENDER_FEMALE => 'Féminin',
            // self::GENDER_UNSPECIFIED => 'Non spécifié', // Optionnel
        ];
    }
    public function getGenderLabelAttribute(): ?string
    {
        return self::getGenders()[$this->gender] ?? null;
    }
    // public function city(): BelongsTo // <--- AJOUTÉ ICI
    // {
    //     return $this->belongsTo(City::class, 'city_id');
    // }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    // Accessor pour le nom complet
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    // Accessor pour l'URL de la photo de profil
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }
        
        // Photo par défaut basée sur le type de compte
        $defaultPhotos = [
            'staff' => 'images/default-staff.png',
            'teacher' => 'images/default-teacher.png',
            'student' => 'images/default-student.png',
        ];
        
        return asset($defaultPhotos[$this->account_type] ?? 'images/default-user.png');
    }

    // Accessor pour vérifier si l'utilisateur est en ligne (à implémenter selon vos besoins)
    public function getIsOnlineAttribute()
    {
        // Logique pour déterminer si l'utilisateur est en ligne
        // Par exemple, basé sur la dernière activité
        return $this->last_login_at && $this->last_login_at->diffInMinutes() < 15;
    }

    // Méthodes pour vérifier les niveaux de rôles
    public function hasRoleLevel(string $level): bool 
    {
        return $this->roles()->where('level', $level)->exists();
    }

    // Relations pour la traçabilité
    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function finalizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'finalized_by');
    }

    // Relations académiques
    public function academies(): BelongsToMany
    {
        return $this->belongsToMany(Academy::class)->withPivot('role')->withTimestamps();
    }

    public function directedAcademies(): HasMany
    {
        return $this->hasMany(Academy::class, 'director_id');
    }

    public function createdAcademies(): HasMany
    {
        return $this->hasMany(Academy::class, 'created_by');
    }

    public function directedCenters(): HasMany
    {
        return $this->hasMany(Center::class, 'director_id');
    }

    public function headedDepartments(): HasMany
    {
        return $this->hasMany(Department::class, 'head_id');
    }

    // Relations pour les enseignants
    public function teacherProfile(): HasOne
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }

    public function teacherAssignations(): HasMany
    {
        return $this->hasMany(Assignation::class, 'teacher_id');
    }

    public function timetableSlots(): HasMany
    {
        return $this->hasMany(Slot::class, 'teacher_id');
    }

    // Relations pour les étudiants


    // public function enrollments(): HasMany
    // {
    //     return $this->hasMany(Enrollment::class, 'student_id');
    // }

    public function absences(): HasMany
    {
        return $this->hasMany(Absences::class, 'student_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'student_id');
    }

    // Relations pour le personnel
    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class, 'user_id');
    }

    // Relations générales
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'author_id');
    }

    public function commands(): HasMany
    {
        return $this->hasMany(Command::class, 'user_id');
    }

    public function cityAssignments(): HasMany
    {
        return $this->hasMany(CityAssignment::class, 'user_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(History::class, 'user_id');
    }

    // Scopes pour faciliter les requêtes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeByAccountType($query, $type)
    {
        return $query->where('account_type', $type);
    }

    public function scopeStaff($query)
    {
        return $query->where('account_type', 'staff');
    }

    public function scopeTeachers($query)
    {
        return $query->where('account_type', 'teacher');
    }

    public function scopeStudents($query)
    {
        return $query->where('account_type', 'student');
    }

    public function scopePendingValidation($query)
    {
        return $query->where('status', self::STATUS_PENDING_VALIDATION);
    }

    public function scopePendingContract($query)
    {
        return $query->where('status', self::STATUS_PENDING_CONTRACT);
    }

    // Méthodes utilitaires
    public function isStaff(): bool
    {
        return $this->account_type === 'staff';
    }

    public function isTeacher(): bool
    {
        return $this->account_type === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->account_type === 'student';
    }

    public function canBeDeleted(): bool
    {
        // Un utilisateur peut être supprimé s'il n'a pas de dépendances critiques
        return !$this->directedAcademies()->exists() 
            && !$this->directedCenters()->exists() 
            && !$this->headedDepartments()->exists();
    }

    // public function getStatusLabelAttribute(): string
    // {
    //     $labels = [
    //         self::STATUS_PENDING_VALIDATION => 'En attente de validation',
    //         self::STATUS_PENDING_CONTRACT => 'En attente de contrat',
    //         self::STATUS_ACTIVE => 'Actif',
    //         self::STATUS_SUSPENDED => 'Suspendu',
    //         self::STATUS_REJECTED => 'Rejeté',
    //         self::STATUS_ARCHIVED => 'Archivé',
    //     ];

    //     return $labels[$this->status] ?? 'Statut inconnu';
    // }

    public function getAccountTypeLabelAttribute(): string
    {
        $labels = [
            'staff' => 'Personnel',
            'teacher' => 'Enseignant',
            'student' => 'Étudiant',
        ];

        return $labels[$this->account_type] ?? 'Type inconnu';
    }
}