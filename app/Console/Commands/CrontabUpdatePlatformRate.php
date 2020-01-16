<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Repositories\Platform\PlatformRepository;
use App\Repositories\Platform\PlatformRateRecordRepository;

class CrontabUpdatePlatformRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:updatePlatformRate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[排程] 更新平台利率';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = Carbon::yesterday()->toDateString();
        $platformRepo = new PlatformRepository();
        $platformRateRecordRepo = new PlatformRateRecordRepository();
        // 取得要更新利率的平台清單
        $platformList = $platformRepo->getCronListForUpdateRate();
        foreach ($platformList as $platform) {
            // 檢查是否已有異動紀錄(避免重複執行Command)
            if ($platformRateRecordRepo->findByPlatformIdAndDate($platform['id'], $date) === 0) {
                // 將預設利率更新到現行利率
                $platformRepo->update($platform['id'], ['present' => $platform['future']]);
                // 利率異動紀錄
                $platformRateRecordRepo->store([
                    'platform_id' => $platform['id'],
                    'date_at'     => $date,
                    'present'     => $platform['present'],
                ]);
            }
        }
    }
}