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
                $value['start_at'] = $value['start_at'];
                $value['end_at'] = $value['end_at'];
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
     * 新增
     *
     * @param  array $request
     * @return array
     */
    public function store($request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $this->platformActivityRateRepo->store([
                    'platform_id' => $request['platform_id'],
                    'start_at'    => $request['start_at'],
                    'end_at'      => $request['end_at'],
                    'rate'        => $request['rate'],
                    'active'      => $request['active'],
                ]);
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
     * 取得平台活動利率資訊
     *
     * @param  integer  $id
     * @return array
     */
    public function getEdit($id)
    {
        try {
            return [
                'result' => true,
                'data'   => $this->platformActivityRateRepo->find($id),
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
     * 編輯
     *
     * @param  integer $id
     * @param  array   $request
     * @return array
     */
    public function edit($id, $request)
    {
        try {
            $result = DB::transaction(function () use ($id, $request) {
                $this->platformActivityRateRepo->update($id, [
                    'platform_id' => $request['platform_id'],
                    'start_at'    => $request['start_at'],
                    'end_at'      => $request['end_at'],
                    'rate'        => $request['rate'],
                    'active'      => $request['active'],
                ]);
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

    /**
     * 檢查帳號是否存在
     *
     * @param  integer  $id
     * @param  integer  $platformId
     * @param  string   $startAt
     * @param  string   $endAt
     * @return boolean
     */
    public function checkActivityExists($id, $platformId, $startAt, $endAt)
    {
        try {
            if ($id < 0 || $platformId < 0 || $startAt == '' || $endAt == '') {
                throw new \Exception('not found');
            }
            return ($this->platformActivityRateRepo->checkActivityExist($id, $platformId, $startAt, $endAt)->count() == 0) ?: false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
