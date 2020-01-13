<?php

namespace App\Services\Admin\Platform;

use App\Repositories\Platform\PlatformRepository;

class PlatformListServices
{
    protected $platformRepo;

    public function __construct(
        PlatformRepository $platformRepo
    ) {
        $this->platformRepo = $platformRepo;
    }

    /**
     * 列表清單
     *
     * @param  array    $params
     * @return array
     */
    public function index()
    {
        try {
            return [
                'result' => true,
                'data'   => $this->platformRepo->getAdminList(),
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'data'   => [],
                'error'  => $e->getMessage(),
            ];
        }
    }
}
