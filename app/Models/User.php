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
        'city_id',
        'address',
        'account_type',
        'profile_photo_path',
        'status',
        'establishment', // Pour les élèves
        'wanted_entrance_exams', // Pour les élèves
        'contract_details', // Détails du contrat
        'validated_by_financial',
        'financial_validation_date',
        'entrance_exam_assigned',
        'contract_assigned',
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
        'wanted_entrance_exams' => 'array', // Cast en array pour stocker les concours
        'contract_details' => 'array', // Cast en array pour stocker les détails du contrat
    ];

    // Statuts possibles pour les élèves
    const STATUS_PENDING_VALIDATION = 'pending_validation'; // En attente de validation par responsable financière
    const STATUS_PENDING_CONTRACT = 'pending_contract'; // En attente d'assignation de contrat et concours
    const STATUS_ACTIVE = 'active'; // Compte activé
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

    // Ajouter ces méthodes pour faciliter l'accès aux informations
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }
        
        // Fallback sur Gravatar
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?s=200&d=mp";
    }

    /**
     * Get the academies directed by the user.
     */
    public function directedAcademies()
    {
        return $this->hasMany(Academy::class, 'director_id');
    }

    /**
     * Get the departments headed by the user.
     */
    public function headedDepartments()
    {
        return $this->hasMany(Department::class, 'head_id');
    }

    /**
     * Get the centers directed by the user.
     */
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
     * Relation avec la responsable financière qui a validé
     */
    public function financialValidator()
    {
        return $this->belongsTo(User::class, 'validated_by_financial');
    }

    /**
     * Override de la méthode assignRole pour mettre à jour le account_type
     */
    public function myAssignRole($roles)
    {
        // Appel à la méthode du trait
        $this->assignRole($roles);
        
        // Mettre à jour le account_type
        if (is_array($roles) || $roles instanceof \Illuminate\Support\Collection) {
            $this->account_type = $roles[0];
        } else {
            $this->account_type = $roles;
        }
        
        // Sauvegarder sans déclencher les events pour éviter les boucles
        $this->saveQuietly();
        
        return $this;
    }
}