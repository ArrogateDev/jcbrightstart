<?php

namespace App\Models\Resource;

use App\Models\Base;

class ResourceCategory extends Base
{
    const STATUS_PUBLISHED = 2;

    const STATUS_SUSPENSED = 1;

    const STATUS_DRAFT = 0;

    public function parent()
    {
        return $this->belongsTo(ResourceCategory::class, 'pid');
    }

    public function children()
    {
        return $this->hasMany(ResourceCategory::class, 'pid');
    }

    public function getParentTextAttribute()
    {
        return $this->parent ? $this->parent->title : __('最上級');
    }

    /**
     * 获取所有上级分类（包含父级、祖父级等）
     * 使用 MySQL 8.0+ 递归 CTE
     *
     * @param bool $include_self 是否包含自身
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getAncestors($include_self = false)
    {
        if ($this->pid == 0) {
            return $include_self ? collect([$this]) : collect();
        }

        $query = "
            WITH RECURSIVE ancestors AS (
                SELECT * FROM resource_categories WHERE id = ?
                UNION ALL
                SELECT rc.* FROM resource_categories rc
                INNER JOIN ancestors a ON rc.id = a.pid
                WHERE a.pid > 0
            )
            SELECT * FROM ancestors ORDER BY level ASC
        ";

        $ancestors = self::findBySql($query, [$this->id]);

        return $include_self ? $ancestors : $ancestors->filter(function ($item) {
            return $item->id != $this->id;
        });
    }

    /**
     * 执行原生SQL查询并返回模型集合
     *
     * @param string $query SQL查询语句
     * @param array $bindings 绑定参数
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public static function findBySql($query, $bindings = [])
    {
        $instance = new static();
        $results = $instance->getConnection()->select($query, $bindings);
        $items = [];

        foreach ($results as $result) {
            $model = new static();
            $model->setRawAttributes((array)$result, true);
            $items[] = $model;
        }

        return collect($items);
    }

    /**
     * 获取所有上级分类ID数组（从根到当前父级）
     *
     * @return array
     */
    public function getAncestorIds()
    {
        return $this->getAncestors(false)->pluck('id')->toArray();
    }

    /**
     * 获取面包屑导航路径（从根到当前）
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBreadcrumbPath()
    {
        return $this->getAncestors(true);
    }

    /**
     * @param $value
     * @return string
     */
    public function getIconAttribute($value)
    {
        return $value ? web_resource_url($value) : web_resource_url('assets/web/images/resource-kit/004_icon_002.svg');
    }
}
