<?php

namespace App\Http\Middleware;

use Closure;

use App\Traits\ApiTraits;
use App\Repositories\Platform\PlatformRepository;

class ApiVerify
{
    protected $platformRepository;

    use ApiTraits;

    public function __construct(PlatformRepository $platformRepository)
    {
        $this->platformRepository = $platformRepository;
    }

    /**
     * API相關驗證
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            // 檢查是否有平台資訊(會一併檢查IP白名單)
            $platform = $this->platformRepository->findByApiKey($request->header('x-api-key'), get_real_ip($request->ip()));
            if ($platform == null) {
                throw new \Exception('Not Found', 404);
            }
            $platform = $platform->toArray();
            $request['platform'] = $platform;
            // 傳遞參數解密
            $request['api'] = $this->doApiDecrypt($request->input('param'), $platform['encrypt_key']);
            return $next($request);
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('custom.api.code.systemError'),
                'error' => $e->getMessage(),
            ];
        }
    }
}
