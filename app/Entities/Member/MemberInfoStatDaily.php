<?php

namespace App\Entities\Member;

use App\Entities\BaoModel;

class MemberInfoStatDaily extends BaoModel
{
    protected $table = 'member_info_stat_daily';
    protected $fillable = ['platform_id', 'member_id', 'bet_at', 'bet_total', 'deposit_credit', 'transfer_interest',
                           'interest', 'closing_interest'];
}
