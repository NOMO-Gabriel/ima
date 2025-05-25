<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'parent_phone_number', // Nouveau
        'city_id',
        'center_id', // Nouveau
        'address',
        'establishment', // Nouveau - Établissement d'origine
        'account_type',
        'profile_photo_path',
        'status',
        'wanted_entrance_exams',
        'contract_details',
        'validated_by_financial',
        'financial_validation_date',
        'entrance_exam_assigned',
        'contract_assigned',
        'student_data',// Pour stocker matricule, concours, détails du contrat, etc.
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
        'financial_validation_date' => 'datetime',
        'wanted_entrance_exams' => 'array',
        'contract_details' => 'array',
        'student_data' => 'array', // ou 'json'
    ];

    // Statuts possibles pour les élèves
    const STATUS_PENDING_VALIDATION = 'pending_validation';
    const STATUS_PENDING_CONTRACT = 'pending_contract';
    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_REJECTED = 'rejected';
    const STATUS_ARCHIVED = 'archived';

    /**
     * Vérifie si le compte est en attente de validation financière
     */
    public function isPendingFinancialValidation(): bool
    {
        return $this->status === self::STATUS_PENDING_VALIDATION;
    }

    /**
     * Vérifie si le compte est en attente d'assignation de contrat
     */
    public function isPendingContract(): bool
    {
        return $this->status === self::STATUS_PENDING_CONTRACT;
    }

    /**
     * Vérifie si le compte est actif
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Valide le compte par la responsable financière
     */
    public function validateByFinancial(User $financialResponsible): void
    {
        $this->status = self::STATUS_PENDING_CONTRACT;
        $this->validated_by_financial = $financialResponsible->id;
        $this->financial_validation_date = now();
        $this->save();
    }

    /**
     * Assigne les concours et contrat puis active le compte
     */
    public function assignContractAndExams(array $entranceExams, array $contractDetails, User $assignedBy): void
    {
        $this->wanted_entrance_exams = $entranceExams;
        $this->contract_details = $contractDetails;
        $this->entrance_exam_assigned = true;
        $this->contract_assigned = true;
        $this->status = self::STATUS_ACTIVE;
        $this->finalized_by = $assignedBy->id;
        $this->finalized_at = now();
        $this->save();
    }

    // Accesseurs
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }
        
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?s=200&d=mp";
    }

    // Relations
    public function directedAcademies()
    {
        return $this->hasMany(Academy::class, 'director_id');
    }

    public function headedDepartments()
    {
        return $this->hasMany(Department::class, 'head_id');
    }

    public function directedCenters()
    {
        return $this->hasMany(Center::class, 'director_id');
    }

    /**
     * Relation avec la ville
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relation avec le centre choisi par l'élève
     */
    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    /**
     * Relation avec la responsable financière qui a validé
     */
    public function financialValidator()
    {
        return $this->belongsTo(User::class, 'validated_by_financial');
    }

    /**
     * Scope pour les élèves uniquement
     */
    public function scopeStudents($query)
    {
        return $query->where('account_type', 'eleve');
    }

    /**
     * Scope pour filtrer par centre
     */
    public function scopeByCenter($query, $centerId)
    {
        return $query->where('center_id', $centerId);
    }

    /**
     * Scope pour filtrer par ville
     */
    public function scopeByCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }

    /**
     * Scope pour les élèves en attente de validation
     */
    public function scopePendingValidation($query)
    {
        return $query->students()->where('status', self::STATUS_PENDING_VALIDATION);
    }

    /**
     * Scope pour les élèves en attente de contrat
     */
    public function scopePendingContract($query)
    {
        return $query->students()->where('status', self::STATUS_PENDING_CONTRACT);
    }

    /**
     * Override de la méthode assignRole pour mettre à jour le account_type
     */
    public function myAssignRole($roles)
    {
        $this->assignRole($roles);
        
        if (is_array($roles) || $roles instanceof \Illuminate\Support\Collection) {
            $this->account_type = $roles[0];
        } else {
            $this->account_type = $roles;
        }
        
        $this->saveQuietly();
        
        return $this;
    }
    public static function getStudentStatusInfo($statusKey)
{
    $statuses = self::getStudentStatuses();
    $statusText = $statuses[$statusKey] ?? 'Inconnu';

    $statusConfig = [
        self::STATUS_PENDING_VALIDATION => ['class' => 'warning', 'icon' => 'hourglass-start'],
        self::STATUS_PENDING_CONTRACT => ['class' => 'info', 'icon' => 'file-signature'],
        self::STATUS_ACTIVE => ['class' => 'success', 'icon' => 'check-circle'],
        self::STATUS_SUSPENDED => ['class' => 'danger', 'icon' => 'ban'],
        self::STATUS_REJECTED => ['class' => 'secondary', 'icon' => 'times-circle'],
        self::STATUS_ARCHIVED => ['class' => 'dark', 'icon' => 'archive'],
    ];
    $config = $statusConfig[$statusKey] ?? ['class' => 'secondary', 'icon' => 'question-circle'];

    return array_merge($config, ['text' => $statusText]);
}

// Relation pour accéder aux données financières (si vous en avez une table séparée plus tard)
// public function financialData() {
//     return $this->hasOne(StudentFinancialData::class);
// }


    public static function getStudentStatuses()
{
    return [
        self::STATUS_PENDING_VALIDATION => 'En attente de validation',
        self::STATUS_PENDING_CONTRACT => 'En attente de contrat',
        self::STATUS_ACTIVE => 'Actif',
        self::STATUS_SUSPENDED => 'Suspendu',
        self::STATUS_REJECTED => 'Rejeté',
        self::STATUS_ARCHIVED => 'Archivé',
    ];
}

}