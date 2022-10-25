<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use App\Traits\Uuids;
use Illuminate\Contracts\Auth\Authenticatable as IAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;


/**
 * @OA\Schema(
 *   schema="User",
 *   @OA\Property(property="id", type="string", example="6f4d9b55-2a8e-4b99-b69e-84bfde0f86b4"),
 *   @OA\Property(property="display_name", type="string", example="John Doe"),
 *   @OA\Property(property="email", type="string" ,example= "johndoe@example.com"),
 *   @OA\Property(property="status_id", type="integer", example="1"),
 * )
 */
class User extends Model implements JWTSubject, IAuthenticatable
{
    use HasFactory, Uuids, Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'display_name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password','created_at','updated_at','deleted_at'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
