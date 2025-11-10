<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Config extends Base
{

    protected $hidden = [
        'show', 'created_at', 'updated_at'
    ];

    //显示
    public const SHOW = 1;

    //隐藏
    public const HIDDEN = 0;

    //系统
    public const SYSTEM = 'system';


    /**
     * 类型映射
     */
    public const typeMappings = [
        self::SYSTEM,
    ];

    /**
     * 根据标示获取索引配置值.
     *
     * @param $type
     * @param $group
     * @param null $key
     * @return mixed
     * @throws \Exception
     */
    public static function getValueByKey($type, $group, $key = null)
    {
        $configs = static::query()
            ->where('type', $type)
            ->where('group', $group)
            ->when($key, function ($query) use ($key) {
                $query->where('key', $key);
            })
            ->pluck('value', 'key')
            ->toArray();

        if ($key && !isset($configs[$key])) {
            throw new \Exception("配置key：{$key}不存在");
        }

        return $key ? $configs[$key] : $configs;
    }
}
