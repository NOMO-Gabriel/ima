<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function staff() {
        return $this->hasOne(Staff::class);
    }

    public function teacher() {
        return $this->hasOne(Teacher::class);
    }

    public function student() {
        return $this->hasOne(Student::class);
    }

    public function isStaff() {
        return $this->staff !== null;
    }

    public function isTeacher() {
        return $this->teacher !== null;
    }

    public function isStudent() {
        return $this->student !== null;
    }

    public function rankValue() {
        switch ($this->rank) {
            case 'all':
                return 6;
            case 'academy':
                return 5;
            case 'sector':
                return 4;
            case 'city':
                return 3;
            case 'department':
                return 2;
            case 'center':
                return 1;
            default:
                return 0;
        }
    }

    /**
     * The academies that the user belongs to.
     *
     * @return BelongsToMany
     */
    public function academies(): BelongsToMany
    {
        return $this->belongsToMany(Academy::class)
                    ->withPivot('role')
                    ->withTimestamps();
    }


    /**
     * Get academies where the user is the director.
     *
     * @return HasMany
     */
    public function directedAcademies(): HasMany
    {
        return $this->hasMany(Academy::class, 'director_id');
    }

    /**
     * Get academies created by the user.
     *
     * @return HasMany
     */
    public function createdAcademies(): HasMany
    {
        return $this->hasMany(Academy::class, 'created_by');
    }

    /**
     * Get academies where the user has a specific role.
     *
     * @param string $role
     * @return BelongsToMany
     */
    public function getAcademiesByRole(string $role): BelongsToMany
    {
        return $this->academies()->wherePivot('role', $role);
    }

    /**
     * Check if user belongs to a specific academy.
     *
     * @param int $academyId
     * @return bool
     */
    public function belongsToAcademy(int $academyId): bool
    {
        return $this->academies()->where('academy_id', $academyId)->exists();
    }

    /**
     * Check if user has a specific role in an academy.
     *
     * @param int $academyId
     * @param string $role
     * @return bool
     */
    public function hasRoleInAcademy(int $academyId, string $role): bool
    {
        return $this->academies()
                    ->where('academy_id', $academyId)
                    ->wherePivot('role', $role)
                    ->exists();
    }
}