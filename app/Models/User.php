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
    public const STATUS_PENDING_VALIDATION = 'pending_validation';
    public const STATUS_PENDING_CONTRACT = 'pending_contract';
    // public const STATUS_PENDING_FINALIZATION = 'pending_finalization'; // Si vous l'ajoutez
    public const STATUS_ACTIVE = 'active';
    public const STATUS_SUSPENDED = 'suspended';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_ARCHIVED = 'archived';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING_VALIDATION => 'En attente de validation',
            self::STATUS_PENDING_CONTRACT => 'En attente de contrat',
            // self::STATUS_PENDING_FINALIZATION => 'En attente de finalisation',
            self::STATUS_ACTIVE => 'Actif',
            self::STATUS_SUSPENDED => 'Suspendu',
            self::STATUS_REJECTED => 'Rejeté',
            self::STATUS_ARCHIVED => 'Archivé',
        ];
    }

    /**
     * Récupère le libellé lisible pour le statut actuel de l'utilisateur.
     *
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    /**
     * Fournit la configuration de style pour chaque statut.
     *
     * @param string $status
     * @return array
     */
    public static function getStatusConfig(string $status): array
    {
        $statuses = self::getStatuses();
        $label = $statuses[$status] ?? ucfirst(str_replace('_', ' ', $status));

        $config = [
            self::STATUS_PENDING_VALIDATION => [
                'label' => $label,
                'text_color' => 'text-yellow-700', 'bg_color' => 'bg-yellow-100',
                'dark_text_color' => 'dark:text-yellow-300', 'dark_bg_color' => 'dark:bg-yellow-600/30',
                'icon' => 'fas fa-hourglass-half',
            ],
            self::STATUS_PENDING_CONTRACT => [
                'label' => $label,
                'text_color' => 'text-blue-700', 'bg_color' => 'bg-blue-100',
                'dark_text_color' => 'dark:text-blue-300', 'dark_bg_color' => 'dark:bg-blue-600/30',
                'icon' => 'fas fa-file-signature',
            ],
            self::STATUS_ACTIVE => [
                'label' => $label,
                'text_color' => 'text-green-700', 'bg_color' => 'bg-green-100',
                'dark_text_color' => 'dark:text-green-300', 'dark_bg_color' => 'dark:bg-green-700/30',
                'icon' => 'fas fa-check-circle',
            ],
            self::STATUS_SUSPENDED => [
                'label' => $label,
                'text_color' => 'text-red-700', 'bg_color' => 'bg-red-100',
                'dark_text_color' => 'dark:text-red-300', 'dark_bg_color' => 'dark:bg-red-700/30',
                'icon' => 'fas fa-ban',
            ],
            self::STATUS_REJECTED => [
                'label' => $label,
                'text_color' => 'text-pink-700', 'bg_color' => 'bg-pink-100', // Ou une autre couleur distinctive
                'dark_text_color' => 'dark:text-pink-300', 'dark_bg_color' => 'dark:bg-pink-700/30',
                'icon' => 'fas fa-times-circle',
            ],
            self::STATUS_ARCHIVED => [
                'label' => $label,
                'text_color' => 'text-gray-700', 'bg_color' => 'bg-gray-100',
                'dark_text_color' => 'dark:text-gray-300', 'dark_bg_color' => 'dark:bg-gray-600/30',
                'icon' => 'fas fa-archive',
            ],
        ];

        // Fallback pour un statut inconnu
        $defaultConfig = [
            'label' => $label,
            'text_color' => 'text-gray-700', 'bg_color' => 'bg-gray-100',
            'dark_text_color' => 'dark:text-gray-300', 'dark_bg_color' => 'dark:bg-gray-600/30',
            'icon' => 'fas fa-question-circle',
        ];

        return $config[$status] ?? $defaultConfig;
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
