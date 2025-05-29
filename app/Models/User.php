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
        'city_id',
        'address',
        'account_type',
        'profile_photo_path',
        'status',
        'city ',
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


    public function hasRoleLevel(string $level) {
        return $this->roles()->where('level', $level)->exists();
    }
// Relations
    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function finalizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'finalized_by');
    }

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

    public function teacherAssignations(): HasMany
    {
        return $this->hasMany(Assignation::class, 'teacher_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absences::class, 'student_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'student_id');
    }

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

    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class, 'user_id');
    }

    public function teachers(): HasOne
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'user_id');
    }

    public function timetableSlots(): HasMany
    {
        return $this->hasMany(Slot::class, 'teacher_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(History::class, 'user_id');
    }
    /**
     * Relation avec le modèle Student (un utilisateur a un profil étudiant)
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }
}
