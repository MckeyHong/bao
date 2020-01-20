<?php

namespace App\Console\Commands\Crontab;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Traits\LoggingTraits;
use App\Services\Common\InterestServices;
use App\Services\Common\RateServices;
use App\Services\Common\TrasnferServices;
use App\Repositories\Member\MemberRepository;
use App\Repositories\Member\MemberTransferRepository;
use App\Repositories\Platform\PlatformRepository;

class SettlementInterest extends Command
{
    use LoggingTraits;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:settlementInterest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[排程] 系統結算利息';

    protected $interestSrv;
    protected $rateSrv;
    protected $trasnferSrv;
    protected $memberRepo;
    protected $memberTransferRepo;
    protected $platformRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        InterestServices $interestSrv,
        RateServices $rateSrv,
        TrasnferServices $trasnferSrv,
        MemberRepository $memberRepo,
        MemberTransferRepository $memberTransferRepo,
        PlatformRepository $platformRepo
    ) {
        parent::__construct();
        $this->interestSrv        = $interestSrv;
        $this->rateSrv            = $rateSrv;
        $this->trasnferSrv        = $trasnferSrv;
        $this->memberRepo         = $memberRepo;
        $this->memberTransferRepo = $memberTransferRepo;
        $this->platformRepo       = $platformRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = Carbon::yesterday()->toDateString();
        $this->setLoggingStartAt();
        $this->setLoggingChannel('crontab');
        $logging = ['command' => $this->signature, 'update' => ['success' => 0, 'error' => []]];
        // 先取得平台的利率
        $rateList = [];
        $platformList = $this->platformRepo->getAll(['id']);
        foreach ($platformList as $platform) {
            $rateList[$platform['id']] = $this->rateSrv->getPlatformRate($platform['id'], $date);
        }
        // 結算利息 - 取得有儲值的會員清單
        $checkoutDateTime = Carbon::now()->toDateString() . ' 00:00:00';
        $memberList = $this->memberRepo->getCronListForSettlementInterest();
        foreach ($memberList as $member) {
            $rate = $rateList[$member['platform_id']] ?? 0;
            $tmpTime = Carbon::parse($checkoutDateTime)->diffInSeconds($member['last_transfer_at']);
            $interest = $this->interestSrv->calculateInterest('settlement', $member['today_deposit'], $rate, $tmpTime);
            $creditBefore = bcadd(($member['credit'] + $member['today_deposit']), $member['interest'], 2);
            $creditAfter = bcadd($creditBefore, $interest, 2);
            if ($interest > 0) {
                $this->memberTransferRepo->store([
                    'platform_id'   => $member['platform_id'],
                    'member_id'     => $member['id'],
                    'type'          => 3,
                    'credit_before' => $creditBefore,
                    'credit'        => $interest,
                    'credit_after'  => $creditAfter,
                    'interest'      => $interest,
                    'rate'          => $rate,
                ]);
                $this->memberRepo->incrementById($member['id'], 'interest', $interest);
            }
            // 系統轉回平台
            if ($creditAfter >= 1) {
                $credit = floor_format($creditAfter, 0);
                $transferAfter = $creditAfter - $credit;
                $result = $this->trasnferSrv->platform($member, $credit, 'OUT');
                $this->memberRepo->update($member['id'], [
                    'credit'        => 0,
                    'today_deposit' => 0,
                    'interest'      => $transferAfter,
                ]);
                if ($result['result']) {
                    $this->memberTransferRepo->store([
                        'platform_id'   => $member['platform_id'],
                        'member_id'     => $member['id'],
                        'type'          => 4,
                        'credit_before' => $creditAfter,
                        'credit'        => $credit,
                        'credit_after'  => $transferAfter,
                        'interest'      => 0,
                        'rate'          => $rate,
                    ]);
                    $logging['update']['success']++;
                } else {
                    $logging['update']['error'][] = ['account' => $member['account'], 'error' => $result['error']];
                }
            }
        }
        // 寫入Logging
        $this->setLoggingParams($logging);
        $this->writeLogging();
        // 更新平台利率
        $this->call('cron:updatePlatformRate');
    }
}
