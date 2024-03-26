<?php

namespace App\Libraries;

use App\Models\LogModel;

class LogLib
{
    static function add($table, $action, $status, $context)
    {
        helper('user');
        $logModel = new LogModel();
        $data = [
            'user' => userData('id'),
            'table' => $table,
            'action' => $action,
            'status' => $context
        ];
        $logModel->insert($data);
    }
}
