<?php

namespace App\Services\Admin\Platform;

use DB;
use App\Traits\TimeTraits;
use App\Repositories\Platform\PlatformRepository;

class PlatformListServices
{
    use TimeTraits;

    protected $platformRepo;

    public function __construct(
        PlatformRepository $platformRepo
    ) {
        $this->platformRepo = $platformRepo;
    }

    /**
     * 取得列表清單
     *
     * @param  array    $params
     * @return array
     */
    public function index()
    {
        try {
            $data = $this->platformRepo->getAdminList();
            foreach ($data as $value) {
                $value['updated_at'] = $this->covertUTCToUTC8($value['updated_at']);
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
     * 取得平台資訊
     *
     * @param  integer  $id
     * @return array
     */
    public function getEdit($id)
    {
        try {
            return [
                'result' => true,
                'data'   => $this->platformRepo->find($id),
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
     * @param  integer  $id
     * @param  array    $request
     * @return array
     */
    public function edit($id, $request)
    {
        try {
            $result = DB::transaction(function () use ($id, $request) {
                $this->platformRepo->update($id, [
                    'name'   => $request['name'],
                    'future' => $request['future'],
                    'active' => $request['active'],
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
}
