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
    ];

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
     * Override de la méthode assignRole pour mettre à jour le account_type
     */
   /**
 * Assigne un rôle à l'utilisateur et met à jour son account_type
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


