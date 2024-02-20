<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalyticsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'analytics';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'uri', 'method', 'ip', 'date',
        'navegador', 'versao_navegador', 'sistema_operacional',
        'referencia', 'dispositivo'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAnalyticsByMonthYear($month, $year, $count = false, $uriFilter = null)
    {
        $this->where('MONTH(date)', $month)
            ->where('YEAR(date)', $year);

        if (!empty($uriFilter)) {
            $this->where('uri', $uriFilter);
        }

        if ($count == false) {
            return $this->findAll();
        } else {
            return $this->countAllResults();
        }
    }

    public function getAllYears()
    {
        $query = $this->distinct()
            ->select('YEAR(date) as year')
            ->orderBy('year', 'ASC')
            ->get();

        $result = $query->getResultArray();

        $years = [];
        foreach ($result as $row) {
            $years[] = $row['year'];
        }

        return $years;
    }


    public function getAccessCountByMonthYear($year)
    {
        // Cria um array com os 12 meses e inicializa os valores de acessos como zero
        $allMonths = range(1, 12);
        $accessData = array_fill_keys($allMonths, 0);

        // Obtém os dados reais do banco de dados
        $result = $this->select('MONTH(date) as month, COUNT(*) as access_count')
            ->where('YEAR(date)', $year)
            ->groupBy('MONTH(date)')
            ->get()
            ->getResultArray();

        // Preenche os valores de acessos com base nos dados reais do banco de dados
        foreach ($result as $row) {
            $accessData[$row['month']] = $row['access_count'];
        }

        return $accessData;
    }
}
