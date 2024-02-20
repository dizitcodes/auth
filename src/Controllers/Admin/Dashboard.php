<?php

namespace App\Controllers\Admin;

use App\Models\AnalyticsModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $analyticsModel = new AnalyticsModel();
        $data['getAno'] = $this->request->getGet('ano') ?? date('Y');

        $data['anos'] = $analyticsModel->getAllYears();

        $meses = array(
            'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro'
        );
        $data['meses'] = json_encode($meses);

        // ACESSOS TOTAIS
        $acessoTotal = $analyticsModel->countAllResults();

        $old = $analyticsModel->getAnalyticsByMonthYear(date('m') - 1, date('Y'), true);
        $now = $analyticsModel->getAnalyticsByMonthYear(date('m'), date('Y'), true);

        if ($old != 0) {
            $crescimentoPercentual = (($now - $old) / $old) * 100;
        } else {
            $crescimentoPercentual = ($now != 0) ? 100 : 0;
        }

        $data['acessos']['percent'] = intval($crescimentoPercentual);
        $data['acessos']['old'] = $old;
        $data['acessos']['now'] = $now;
        $data['acessos']['total'] = $acessoTotal;

        $data['acessos'][$data['getAno']] = $analyticsModel->getAccessCountByMonthYear($data['getAno']);
        // ACESSOS TOTAIS FIM


        return view('admin/pages/dashboard/default', $data);
    }
}
