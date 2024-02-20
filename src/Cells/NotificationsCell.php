<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class NotificationsCell extends Cell
{
    public function show()
    {
        $data = [
            'notificationsView' => false
        ];

        return $this->view('notifications', $data);
    }
}
