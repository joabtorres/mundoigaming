<?php $this->layout("_theme", ["head" => $head]); ?>

<div class="container-fluid" id="section-container">
    <div class="row">
        <div class="col" id="pagina-header">
            <h5>Página Inicial</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?= url() ?>"><i class="fa fa-tachometer-alt"></i> Página Inicial</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <?= flash() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <section class="card border-default">
                <header class="card-header bg-default">
                    <h4 class="card-title h6 mt-1 mb-1"><i class="fa-solid fa-bullhorn"></i> Campanhas Publicitárias</h4>
                </header>
                <article class="card-body">
                    <?= count_reg($publicitiesCount) ?>
                </article>
            </section>
        </div>
        <div class="col-md-4 mb-3">
            <section class="card border-default">
                <header class="card-header bg-default">
                    <h4 class="card-title h6 mt-1 mb-1"><i class="fa-solid fa-swatchbook"></i> Status</h4>
                </header>
                <article class="card-body">
                    <?= count_reg($statusCount) ?>
                </article>
            </section>
        </div>
        <div class="col-md-4 mb-3">
            <section class="card border-default">
                <header class="card-header bg-default">
                    <h4 class="card-title h6 mt-1 mb-1"><i class="fa-solid fa-users"></i> Usuários</h4>
                </header>
                <article class="card-body">
                    <?= count_reg($usersCount) ?>
                </article>
            </section>
        </div>
    </div>
    <!-- <div class="row"> -->
    <div class="row">
        <div class="col mb-2 mt-2">
            <section class="card border-default">
                <header class="card-header bg-default">
                    <h1 class="card-title h6 mb-1 mt-1"><i class="fa-solid fa-bullhorn"></i> Campanhas Publicitárias</h1>
                </header>
                <div class="table-responsive">
                    <!--table-->
                    <table class="table table-striped table-bordered table-sm table-hover mb-0">
                        <thead class="bg-secondary">
                            <tr class="">
                                <th scope="col" class="align-middle" width="50px">#</th>
                                <th scope="col" class="align-middle">Campanha</th>
                                <th scope="col" class="align-middle">Data</th>
                                <th scope="col" class="align-middle">Qtd. dias restantes</th>
                                <th scope="col" class="align-middle">Status</th>
                                <th scope="col" class="align-middle" width="60px">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($publicities)) :
                                $qtd = 1;
                                foreach ($publicities as $publicity) :
                            ?>
                                    <tr>
                                        <td class="text-center align-middle"><?php echo $qtd ?></td>
                                        <td class="align-middle"><?= ($publicity->campaign ?? "") ?></td>
                                        <td class="align-middle"><?= date_fmt($publicity->date, "d/m/Y") ?></td>
                                        <td class="align-middle"><?= date_from_days($publicity->date) ?></td>
                                        <td class="align-middle"><span class="p-1 rounded <?= ($publicity->status()->class_color ?? "") ?>"><?= ($publicity->status()->name ?? "") ?></span></td>
                                        <td class="align-middle text-center">
                                            <a class="btn btn-success btn-sm" href="<?= url("publicity/view/{$publicity->id}") ?>" title="Visualizar"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                            <?php
                                    $qtd++;
                                endforeach;
                            else :
                                echo "<tr><td colspan='5'>Nenhum registro encontrado! </td></tr>";
                            endif;
                            ?>
                        </tbody>
                    </table>
                    <!--table-->
                </div>
            </section>
        </div>
    </div>
    <!-- </div> fim row  -->
</div>
<!-- /#section-container -->

<?php
$this->start("scripts"); ?>
<script src="<?= theme("../../shared/js/chart/chart.min.js") ?>"></script>
<script src="<?= theme("assets/js/charts.js") ?>"></script>
<?php
$this->end(); ?>