<?= $this->extend('admin/layout') ?>


<?= $this->section('content') ?>
<!--//Page Toolbar//-->
<div class="toolbar px-3 px-lg-6 pt-3 pb-3">
    <div class="position-relative container-fluid px-0">
        <div class="row align-items-center position-relative">
            <div class="col-md-7 mb-3 mb-md-0">
                <h3 class="mb-0">Dados de acesso</h3>
            </div>
        </div>
    </div>
</div>
<!--//Page Toolbar End//-->

<!--//Page content//-->
<div class="content pt-3 px-3 px-lg-6 d-flex flex-column-fluid position-relative">
    <div class="container-fluid px-0">

        <div class="row">
            <div class="col-md-12 col-xl-9 mb-3 mb-lg-5">
                <!--Card-->
                <div class="card overflow-hidden h-100">
                    <!--Card header-->
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h5 class="mb-0 pe-3">Gráfico de acessos
                            <span class="material-symbols-rounded align-middle ms-2 text-body-secondary fs-6 cursor-pointer" data-tippy-placement="bottom-start" data-tippy-content="Número de acessos por mês">info</span>
                        </h5>
                        <!--Dropdown-->
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                                <?= $getAno ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" style="--bs-dropdown-min-width:7rem">
                                <?php foreach ($anos as $ano) : ?>
                                    <a href="?ano=<?= $ano ?>" class="<?= $ano == $getAno ? 'active' : '' ?> dropdown-item"><?= $ano ?></a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                    <!--Apex chart for Overview-->
                    <div class="card-body p-0">
                        <!--chart-->
                        <div class="w-100">
                            <div id="chart_revenue_report"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4">
                <!--::begin card-->
                <div class="card overflow-hidden mb-3 mb-lg-5">
                    <div class="card-body d-flex align-items-center">
                        <!--Card text-->
                        <div class="flex-grow-1">
                            <div class="h3 mb-2">
                                <?= $acessos['total'] ?>
                            </div>
                            <span class="text-body-secondary">Acessos totais</span>
                        </div>
                        <div class="flex-shrink-0 text-end" data-tippy-content="<?= $acessos['percent'] >= 0 ? '+' : '' ?><?= $acessos['now'] - $acessos['old'] ?> acessos em relação ao mês anterior">
                            <div class="small"><span class="text-<?= $acessos['percent'] >= 0 ? 'success' : 'danger' ?>"><?= $acessos['percent'] ?>%</span></div>
                            <?php if ($acessos['percent'] >= 0) : ?>
                                <span class="material-symbols-rounded text-success">trending_up</span>
                            <?php else : ?>
                                <span class="material-symbols-rounded text-danger">trending_down</span>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <!--::/end card-->
                <!--::begin card-->
                <div class="card overflow-hidden mb-3 mb-lg-5">
                    <div class="card-body d-flex align-items-center">
                        <!--Card text-->
                        <div class="flex-grow-1">
                            <div class="h3 mb-2">
                                <?= $a['leads']['total'] ?? 0 ?>
                            </div>
                            <span class="text-body-secondary">Leads</span>
                        </div>
                        <div class="flex-shrink-0 text-end" data-tippy-content="<?= ($a['leads']['percent'] ?? 0) >= 0 ? '+' : '' ?><?= ($a['leads']['now'] ?? 0) - ($a['leads']['old'] ?? 0) ?> contatos em relação ao mês anterior">
                            <div class="small"><span class="text-<?= ($a['leads']['percent'] ?? 0) >= 0 ? 'success' : 'danger' ?>"><?= $a['leads']['percent'] ?? 0 ?>%</span></div>
                            <?php if (($a['leads']['percent'] ?? 0) >= 0) : ?>
                                <span class="material-symbols-rounded text-success">trending_up</span>
                            <?php else : ?>
                                <span class="material-symbols-rounded text-danger">trending_down</span>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <!--::/end card-->
                <!--::begin card-->
                <div class="card overflow-hidden mb-3 mb-lg-5">
                    <div class="card-body d-flex align-items-center">
                        <!--Card text-->
                        <div class="flex-grow-1">
                            <div class="h3 mb-2">
                                <?= $a['leads']['total'] ?? 0 ?>
                            </div>
                            <span class="text-body-secondary">Cotações</span>
                        </div>
                        <div class="flex-shrink-0 text-end" data-tippy-content="<?= ($a['leads']['percent'] ?? 0) >= 0 ? '+' : '' ?><?= ($a['leads']['now'] ?? 0) - ($a['leads']['old'] ?? 0) ?> contatos em relação ao mês anterior">
                            <div class="small"><span class="text-<?= ($a['leads']['percent'] ?? 0) > 0 ? 'success' : (($a['leads']['percent'] ?? 0) == 0 ? 'muted ' : 'danger') ?>"><?= $a['leads']['percent'] ?? 0 ?>%</span></div>
                            <?php if (($a['leads']['percent'] ?? 0) > 0) : ?>
                                <span class="material-symbols-rounded text-success">trending_up</span>
                            <?php elseif (($a['leads']['percent'] ?? 0) == 0) : ?>
                                <span class="material-symbols-rounded text-muted">remove</span>
                            <?php else : ?>
                                <span class="material-symbols-rounded text-danger">trending_down</span>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <!--::/end card-->

            </div>
        </div>
    </div>
</div>
<!--//Page content End//-->
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<!--Charts-->
<script src="<?= base_url('admin/vendor/apexcharts.min.js') ?>"></script>


<script>
    //Revenue report
    var optionsRevenue = {
        colors: ["var(--bs-primary)", "var(--bs-warning)"],
        series: [{
            name: 'Acessos',
            data: [<?= implode(',', $acessos[$getAno]) ?>],
        }],
        chart: {
            fontFamily: 'inherit',
            type: 'bar',
            height: 360,
            stacked: true,
            toolbar: {
                show: false,
            },
        },
        dataLabels: {
            enabled: false,
        },

        plotOptions: {
            bar: {
                columnWidth: '20%',
                startingShapes: "rounded",
                colors: {
                    backgroundBarOpacity: 0,
                }
            },
            distributed: true
        },
        grid: {
            strokeDashArray: 6,
            padding: {
                top: 10,
                bottom: 10
            },
            xaxis: {
                lines: {
                    show: true,
                },
            },
            yaxis: {
                lines: {
                    show: false,
                },
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: [{
                    formatter: function(y) {
                        if (typeof y !== 'undefined') {
                            return ' ' + y.toFixed(0) + '';
                        }
                        return y;
                    },
                },
                {
                    formatter: function(y) {
                        if (typeof y !== 'undefined') {
                            return '' + y.toFixed(0) + '';
                        }
                        return y;
                    },
                },
            ],
        },
        xaxis: {
            categories: <?= $meses ?>,

            axisTicks: {
                show: true,
            },
            axisBorder: {
                show: false,
            },
            tooltip: {
                enabled: true,
            },
        },
        yaxis: {
            crosshairs: {
                show: false,
            }
        }
    };
    new ApexCharts(document.querySelector('#chart_revenue_report'), optionsRevenue).render();
</script>
<?= $this->endSection() ?>