<?php

namespace App\Traits;

trait AdminOperation
{
    /**
     * 資料範例
     *
     *  [
     *     ['type' => 'field', 'field' => 'account', 'data' => 'xxxx']
     *     ['type' => 'info', 'field' => '', 'data' => 'store']
     *     ['type' => 'around', 'field' => 'rate', 'data' => ['old' => 1, 'new' => 2]]
     *     ['type' => 'permission', 'field' => '', 'data' => ['add' => [], 'delete' => []]]
     *  ]
     */

    /**
     * 轉換操作日誌要顯示的資訊
     *
     * @param  array $operation
     * @return string
     */
    public function covertOperation($operation)
    {
        try {
            $result = '';
            foreach ($operation as $value) {
                switch ($value['type']) {
                    case 'field': // 名稱-資訊
                        $result .= ($result !== '') ? '<br />' : '';
                        $result .= trans('custom.admin.operation.field.' . $value['field']) . ' : ' . $value['data'];
                        break;
                    case 'info': // 純文字顯示
                        $result .= ($result !== '') ? '<br />' : '';
                        $result .= trans('custom.admin.operation.info.' . $value['data']);
                        break;
                    case 'around': // 前後數值
                        $result .= ($result !== '') ? '<br />' : '';
                        $result .= trans('custom.admin.operation.field.' . $value['field']) . ' : ';
                        if ($value['field'] == 'active') {
                            $result .= trans('custom.admin.operation.active.' . $value['data']['old']) . ' → ' . trans('custom.admin.operation.active.' . $value['data']['new']);
                        } else {
                            $result .= $value['data']['old'] . ' → ' . $value['data']['new'];
                        }
                        break;
                    case 'permission': // 功能權限
                        foreach (['add', 'delete'] as $field) {
                            $tmp = '';
                            foreach ($value['data'][$field] as $funcKey => $funcValue) {
                                $tmp .= trans('custom.admin.func.' . $funcKey) . '：';
                                $tmpAction = '';
                                foreach ($funcValue as $action) {
                                    $tmpAction .= ($tmpAction !== '') ? ', ' : '';
                                    $tmpAction .= trans('custom.admin.operation.permissionAction.' . $action);
                                }
                                $tmp .= $tmpAction . '<br />';
                            }
                            if ($tmp !== '') {
                                $result .= (($result !== '') ? '<br />' : '') . trans('custom.admin.operation.permissionAction.' . $field) . '<br />' . $tmp;
                            }
                        }
                        break;
                    default:
                }
            }
            return $result;
        } catch (\Exception $e) {
            return '';
        }
    }
}
