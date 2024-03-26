<?php

function getStatus($table, $ref, $field = null)
{
    $statusModel = new \App\Models\StatusModel();
    $statusModel->where('table', $table);
    $statusModel->groupStart();
    $statusModel->where('id', $ref);
    $statusModel->orWhere('uid', $ref);
    $statusModel->groupEnd();
    $status = $statusModel->first();
    if ($field) :
        if ($field == 'style') :
            return json_decode($status[$field], true);
        else :
            return $status[$field] ?? false;
        endif;
    else :
        return $status;
    endif;
}
