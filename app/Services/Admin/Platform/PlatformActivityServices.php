<?php

namespace App\Services\Admin\Platform;

use DB;
use Carbon\Carbon;
use App\Traits\TimeTraits;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\System\SystemOperationServices;
use App\Repositories\Platform\PlatformActivityRateRepository;

class PlatformActivityServices
{
    use TimeTraits;

    protected $dropdownSrv;
    protected $systemOperationSrv;
    protected $platformActivityRateRepo;

    public function __construct(
        DropdownServices $dropdownSrv,
        SystemOperationServices $systemOperationSrv,
        PlatformActivityRateRepository $platformActivityRateRepo
    ) {
        $this->dropdownSrv              = $dropdownSrv;
        $this->systemOperationSrv       = $systemOperationSrv;
        $this->platformActivityRateRepo = $platformActivityRateRepo;
    }

    /**
     * 取得列表清單
     *
     * @param  array    $params
     * @param  array    $platform
     * @return array
     */
    public function index($params, $platform)
    {
        try {
            $params['now_at'] = $this->covertUTC8ToUTC(Carbon::now()->toDateString());
            $nowAt = Carbon::now()->toDateString();
            $data = $this->platformActivityRateRepo->getAdminList($params);
            foreach ($data as $value) {
                $value['platform_id'] = $platform[$value['platform_id']] ?? '';
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
                $activity = $this->platformActivityRateRepo->store([
                    'platform_id' => $request['platform_id'],
                    'start_at'    => $request['start_at'],
                    'end_at'      => $request['end_at'],
                    'rate'        => $request['rate'],
                    'active'      => $request['active'],
                ]);
                // 操作日誌
                $operation = $this->handleOperation($activity, 'store');
                $this->systemOperationSrv->store(
                    $activity['id'],
                    1,
                    $operation['targets'],
                    $operation['content']
                );
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
                $activity = $this->platformActivityRateRepo->find($id);
                $params = [];
                $content = [['type' => 'info', 'field' => '', 'data' => 'edit']];
                foreach(['start_at', 'end_at', 'rate', 'active'] as $field) {
                    if ($activity[$field] != $request[$field]) {
                        $params[$field] = $request[$field];
                        $content[] = ['type' => 'around', 'field' => $field, 'data' => ['old' => $activity[$field], 'new' => $request[$field]]];
                    }
                }
                if (count($params) > 0) {
                    $this->platformActivityRateRepo->update($id, $params);
                    // 操作日誌
                    $operation = $this->handleOperation($activity, 'edit');
                    $this->systemOperationSrv->store(
                        $activity['id'],
                        2,
                        $operation['targets'],
                        $content
                    );
                }
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
                $activity = $this->platformActivityRateRepo->find($id)->toArray();
                $activity['end_at'] = Carbon::now()->toDateString();
                $this->platformActivityRateRepo->update($id, ['end_at' => $activity['end_at']]);
                // 操作日誌
                $operation = $this->handleOperation($activity, 'close');
                $this->systemOperationSrv->store(
                    $activity['id'],
                    2,
                    $operation['targets'],
                    $operation['content']
                );
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
                $activity = $this->platformActivityRateRepo->find($id);
                $this->platformActivityRateRepo->destroy($id);
                // 操作日誌
                $operation = $this->handleOperation($activity, 'destroy');
                $this->systemOperationSrv->store(
                    $activity['id'],
                    3,
                    $operation['targets'],
                    $operation['content']
                );
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
            if ($platformId == 0) {
                $activity = $activity = $this->platformActivityRateRepo->find($id);
                $platformId = $activity['platform_id'] ?? 0;
            }
            return ($this->platformActivityRateRepo->checkActivityExist($id, $platformId, $startAt, $endAt)->count() == 0) ?: false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 處理操作日誌要顯示的資訊
     *
     * @param  array|object  $activity
     * @param  string        $action
     * @return array
     */
    public function handleOperation($activity, $action)
    {
        try {
            $result = ['targets' => [], 'content' => []];
            $platform = $this->dropdownSrv->dropdown('platform');
            $result['targets'][] = ['type' => 'field', 'field' => 'platform', 'data' => $platform[$activity['platform_id']]];
            $result['content'][] = ['type' => 'info', 'field' => '', 'data' => $action];
            $result['content'][] = ['type' => 'field', 'field' => 'start_at', 'data' => $activity['start_at']];
            $result['content'][] = ['type' => 'field', 'field' => 'end_at', 'data' => $activity['end_at']];
            $result['content'][] = ['type' => 'field', 'field' => 'rate', 'data' => $activity['rate']];
            return $result;
        } catch (\Exception $e) {
            return ['targets' => [], 'content' => []];
        }
    }
}
