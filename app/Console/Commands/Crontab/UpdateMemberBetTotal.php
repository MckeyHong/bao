<?php

namespace App\Console\Commands\Crontab;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Traits\LoggingTraits;
use App\Api\Traits\ApiCommonTraits;
use App\Api\Traits\Wager\WagerBetTotalTraits;
use App\Repositories\Member\MemberInfoStatDailyRepository;
use App\Repositories\Platform\PlatformRepository;

class UpdateMemberBetTotal extends Command
{
    use LoggingTraits, ApiCommonTraits, WagerBetTotalTraits;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:updateMemberBetTotal {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[排程] 取得平台會員昨日下注洗碼量';

    protected $memberInfoStatDailyRepo;
    protected $platformRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        MemberInfoStatDailyRepository $memberInfoStatDailyRepo,
        PlatformRepository $platformRepo
    ) {
        parent::__construct();
        $this->memberInfoStatDailyRepo = $memberInfoStatDailyRepo;
        $this->platformRepo            = $platformRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->setLoggingStartAt();
        $this->setLoggingChannel('crontab');
        $date = (validate_date($this->option('date'))) ? $this->option('date') : Carbon::yesterday()->toDateString();

        $platformList = $this->platformRepo->getByWhere('active', 1, ['id', 'code']);
        foreach ($platformList as $platform) {
            $this->setPlatformCode($platform['code']);
            $response = $this->getBetTotalOfApi($date);
            if (count($response['data']) > 0) {
            }
        }
    }
}
