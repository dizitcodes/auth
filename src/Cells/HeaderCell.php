<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class HeaderCell extends Cell
{
    public function type()
    {
        $data['usuario'] = ['nome' => 'Leonardo Maciel', 'tipo' => 0];
        return $this->view('header', $data);
    }
}
