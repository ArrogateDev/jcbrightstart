<?php

namespace App\Models\User;

use App\Traits\Model\BaseTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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

    public const AGE_MAPS = [
        0 => 'Under 18 / < 18',
        1 => '18-24',
        2 => '25-34',
        3 => '35-44',
        4 => '45-54',
        5 => '55-64',
        6 => '65+'
    ];

    /**
     * 设置用户密码
     *
     * @param string|null $value
     */
    public function setPasswordAttribute($value)
    {
        if (empty($value)) return;
        if (str_starts_with($value, '$2y$') || str_starts_with($value, '$2a$') || str_starts_with($value, '$2b$')) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = Hash::make($value);
        }
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

    /**
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return $value ? web_resource_url($value) : web_resource_url('assets/img/avatar.png');
    }

    /**
     * @return string
     */
    public function getGenderTextAttribute()
    {
        $gender = $this->gender;
        return is_integer($gender) ? ($gender === 1 ? __('男') : __('女')) : __('未知');
    }

    /**
     * @return string
     */
    public function getAgeTextAttribute()
    {
        $age = $this->age;
        return is_integer($age) ? (isset(self::AGE_MAPS[$age]) ? __(self::AGE_MAPS[$age]) : __('未知')) : __('未知');
    }

    /**
     * @return string
     */
    public function getRegistrationDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d M Y, h:i A');
    }
}
