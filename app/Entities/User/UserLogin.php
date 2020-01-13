<?php

namespace App\Entities\User;

use App\Traits\TimeTraits;
use App\Entities\BaoModel;

class UserLogin extends BaoModel
{
    use TimeTraits;

    protected $table = 'user_login';
    protected $fillable = ['user_id', 'user_account', 'user_name', 'login_ip', 'area', 'status'];

    /**
     * 處理要顯示場次資訊
     *
     * @return string
     */
    public function getLoginAtAttribute()
    {
        $result = '';
        if (isset($this->attributes['created_at'])) {
            $result = $this->covertUTCToUTC8($this->attributes['created_at']);
        }
        return $result;
    }
}
