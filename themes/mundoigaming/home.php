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
                    <h4 class="card-title h6 mt-1 mb-1"><i class="fa-solid fa-bullhorn"></i> Uploads realizados</h4>
                </header>
                <article class="card-body">
                    <?= count_reg($uploadCount) ?>
                </article>
            </section>
        </div>
        <div class="col-md-4 mb-3">
            <section class="card border-default">
                <header class="card-header bg-default">
                    <h4 class="card-title h6 mt-1 mb-1"><i class="fa-solid fa-swatchbook"></i> Lista de ID</h4>
                </header>
                <article class="card-body">
                    <?= count_reg($listIdCount) ?>
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
                    <h1 class="card-title h6 mb-1 mt-1"><i class="fa-solid fa-bullhorn"></i> Uploads aguardando análise</h1>
                </header>
                <article class="card-body py-0">
                    <div class="row">
                        <div class="col-12 my-2">
                            <button class="btn btn-sm btn-success pull-right" type="button" data-toggle="modal" data-target="#novo-registro" title="Adicionar"><i class="fas fa-plus-square"></i>
                                Adicionar</button>
                        </div>
                    </div>
                </article>
                <div class="table-responsive">
                    <!--table-->
                    <table class="table table-striped table-bordered table-sm table-hover mb-0">
                        <thead class="bg-secondary">
                            <tr class="">
                                <th scope="col" class="align-middle" width="50px">#</th>
                                <th scope="col" class="align-middle">Descrição</th>
                                <th scope="col" class="align-middle">Data</th>
                                <th scope="col" class="align-middle">Status</th>
                                <th scope="col" class="align-middle" width="60px">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($uploads)) :
                                $qtd = 1;
                                foreach ($uploads as $upload) :
                            ?>
                                    <tr>
                                        <td class="text-center align-middle"><?php echo $qtd ?></td>
                                        <td class="align-middle"><?= ($upload->description ?? "") ?></td>
                                        <td class="align-middle"><?= (date_fmt($upload->created_at) ?? "") ?></td>
                                        <td class="align-middle"><span class="p-1 rounded <?= ($upload->status()->class_color ?? "") ?>"><?= ($upload->status()->name ?? "") ?></span></td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_view_<?= (md5($upload->id) ?? "") ?>" title="Visualizar"><i class="fa fa-eye"></i></button>
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
            <div class="mt-3 mb-3">
                <?= $paginator; ?>
            </div>
        </div>
    </div>
    <!-- </div> fim row  -->
</div>
<!-- /#section-container -->


<?php $this->insert("upload/register"); ?>

<!-- modal para visualizar -->
<?php
if (isset($uploads) && is_array($uploads)) :
    foreach ($uploads as $upload) :
        $this->insert("upload/view", ["upload" => $upload]);
    endforeach;
endif;
?>
<!-- fim modal para visualizar -->