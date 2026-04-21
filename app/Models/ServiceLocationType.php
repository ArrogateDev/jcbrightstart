<?php

namespace App\Models;

class ServiceLocationType extends Base
{

    public const NORMAL = 0;

    public const DISABLE = 1;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(ServiceLocation::class, 'type');
    }
}
