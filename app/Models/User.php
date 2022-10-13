<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tenancy\Identification\Concerns\AllowsTenantIdentification;
use Tenancy\Identification\Contracts\Tenant;
use Tenancy\Identification\Drivers\Http\Contracts\IdentifiesByHttp;

class User extends Authenticatable implements Tenant, IdentifiesByHttp
{
    use HasApiTokens, HasFactory, Notifiable, AllowsTenantIdentification;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Specify whether the tenant model is matching the request.
     *
     * @param  Request  $request
     * @return User|null
     */
    public function tenantIdentificationByHttp(Request $request): ?User
    {
        list($subdomain) = explode('.', $request->getHost(), 2);
        return $this->query()
            ->where('subdomain', $subdomain)
            ->first();
    }
}
