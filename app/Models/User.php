<?php

namespace App\Models;

use App\Traits\Model\BaseTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends  Authenticatable
{
    use HasApiTokens, Notifiable, BaseTrait, SoftDeletes;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public const NORMAL = 0;

    public const DISABLE = 1;

    /**
     * 设置用户密码
     *
     * @param string $value
     */
    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * @param string|null $abilities
     * @return void
     */
    public function remove_tokens(string $abilities = null)
    {
        \Laravel\Sanctum\PersonalAccessToken::query()
            ->where('tokenable_id', $this->id)
            ->when($abilities, function ($query) use ($abilities) {
                $query->where('abilities', sprintf('["%s"]', $abilities));
            })
            ->delete();
    }
}
