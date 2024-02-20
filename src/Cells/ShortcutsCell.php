<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ShortcutsCell extends Cell
{
    public function show()
    {
        if (1 == 2) :
            return $this->view('shortcuts');
        else:
            return '';
        endif;
    }
}
