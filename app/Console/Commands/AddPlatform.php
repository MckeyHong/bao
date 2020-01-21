<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Entities\Platform\Platform;
use App\Entities\Platform\PlatformWhitelist;

class AddPlatform extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bao:addPlatform';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '新增平台';

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
        $params = ['code' => '', 'name' => ''];
        $list = [
            ['key' => 'code', 'message' => '請輸入要新增的平台代碼(code)?'],
            ['key' => 'name', 'message' => '請輸入要新增的平台名稱(name)?'],
        ];
        foreach ($list as $value) {
            $check = false;
            while (!$check) {
                $params[$value['key']] = trim($this->ask($value['message']));
                if ($params[$value['key']] !== '') {
                    $check = true;
                }
            }
        }
        // 檢查是否已存在
        if (Platform::select(['id'])->where('code', $params['code'])->get()->count() > 0) {
            $this->error('該平台代碼(code)已存在，請重新命名');
            exit;
        }
        $platform = Platform::create([
            'code'        => $params['code'],
            'name'        => $params['name'],
            'api_key'     => Str::uuid(),
            'encrypt_key' => Str::random(16),
        ]);

        // 平台API串接IP白名單
        $ipList = $this->ask('是否要設定API串接的IP白名單?(多個用,區隔，沒有則按Enter)');
        $ipList = explode(',', $ipList);
        foreach ($ipList as $ip) {
            $ip = trim($ip);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                PlatformWhitelist::create([
                    'platform_id' => $platform['id'],
                    'ip'          => $ip
                ]);
            }
        }


        $this->info('平台「' . $params['name'] .'(' . $params['code'] . ')」新增完畢。' . PHP_EOL
                   .'平台API Key：' . $platform['api_key'] . PHP_EOL
                   .'平台加密Key：' . $platform['encrypt_key']);
    }
}
