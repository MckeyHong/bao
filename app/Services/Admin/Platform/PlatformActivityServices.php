<?php

namespace App\Services\Admin\Platform;

use DB;
use Carbon\Carbon;
use App\Traits\TimeTraits;
use App\Repositories\Platform\PlatformActivityRateRepository;

class PlatformActivityServices
{
    use TimeTraits;

    protected $platformActivityRateRepo;

    public function __construct(
        PlatformActivityRateRepository $platformActivityRateRepo
    ) {
        $this->platformActivityRateRepo = $platformActivityRateRepo;
    }

    /**
     * 取得列表清單
     *
     * @param  array    $params
     * @param  array    $platforms
     * @return array
     */
    public function index($params, $platforms)
    {
        try {
            $params['now_at'] = $this->covertUTC8ToUTC(Carbon::now()->toDateString());
            $nowAt = Carbon::now()->toDateString();
            $data = $this->platformActivityRateRepo->getAdminList($params);
            foreach ($data as $value) {
                $value['platform_id'] = $platforms[$value['platform_id']] ?? '';
                $value['is_action'] = $value['is_close'] = false;
                if ($value['start_at'] > $nowAt) {
                    $value['is_action'] = true;
                } elseif ($value['start_at'] <= $nowAt && $value['end_at'] > $nowAt) {
                    $value['is_close'] = true;
                }
                $value['start_at'] = $this->covertUTCToUTC8($value['start_at']);
                $value['end_at'] = $this->covertUTCToUTC8($value['end_at']);
            }
            return [
                'result' => true,
                'data'   => $data,
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'data'   => [],
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 關閉活動
     *
     * @param  integer  $id
     * @return array
     */
    public function close($id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $this->platformActivityRateRepo->update($id, ['end_at' => $this->covertUTC8ToUTC(Carbon::now()->toDateString())]);
                return true;
            });
            return ['result' => $result];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 刪除活動
     *
     * @param  integer  $id
     * @return array
     */
    public function destroy($id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $this->platformActivityRateRepo->destroy($id);
                return true;
            });
            return ['result' => $result];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
