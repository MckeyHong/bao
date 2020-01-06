<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

abstract class BaoModel extends Model
{
    protected $connection = 'mysql';

    /**
     * 取得對應平台資訊
     *
     * @param  object  $query
     * @param  integer $platformId
     * @return mixed
     */
    public function scopePlatform($query, $platformId)
    {
        return $query->where('platform_id', $platformId);
    }

    /**
     * 取得對應會員資訊
     *
     * @param  object  $query
     * @param  integer $memberId
     * @return mixed
     */
    public function scopeMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    /**
     * 取得對應狀態資訊
     *
     * @param  object  $query
     * @param  integer $active
     * @return mixed
     */
    public function scopeActive($query, $active = 1)
    {
        return $query->where('active', $active);
    }

    /**
     * 取得連線名稱
     *
     * @return string
     */
    public static function getNowConnection()
    {
        return with(new static)->getConnectionName();
    }

    /**
     * 取得該 entity 資料表名稱
     *
     * @return string
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
