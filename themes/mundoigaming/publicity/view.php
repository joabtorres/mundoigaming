<?php $this->layout("_theme", ["head" => $head]); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col" id="pagina-header">
            <h5><?= ($publicity->campaign ?? "") ?></h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url() ?>"><i class="fa fa-tachometer-alt"></i> Inicial</a> </li>
                    <li class="breadcrumb-item"><a href="<?= url("publicity") ?>"><i class="fas fa-tasks"></i> Campanhas Publicitárias</a></li>
                    <li class="breadcrumb-item"><a href="<?= url("publicity/view/{$publicity->id}") ?>"><i class="fa-solid fa-bullhorn"></i> <?= ($publicity->campaign ?? "") ?></a></li>
                </ol>
            </nav>
        </div>
        <!--fim pagina-header;-->
    </div>
    <div class="row">
        <div class="col">
            <?= flash() ?>
            <button type="button" class="btn pull-right btn-danger btn-sm" data-toggle="modal" data-target="#modal_remove_<?= md5($publicity->id) ?>" title="Excluir"><i class="fa fa-trash"></i> Excluir</button>
            <a href="<?= url("publicity/update/{$publicity->id}") ?>" class="btn pull-right btn-primary btn-sm mr-1" title="Editar"><i class="fa fa-pencil-alt"></i> Editar</a>
        </div>
    </div>
    <div class="row">
        <div class="col mt-3">
            <section class="card border-default">
                <header class="card-header bg-default">
                    <h4 class="card-title h6 mb-1 mt-1"><i class="fa-solid fa-bullhorn"></i> Campanha publicitária</h4>
                </header>
                <article class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-2"><span class="text-primary d-block">Campanha publicitária: </span> <?= ($publicity->campaign ?? "") ?></div>
                        <div class="col-md-4 mb-2"><span class="text-primary d-block">Status: </span> <?= !empty($publicity->status()) ? "<span class='p-1 rounded {$publicity->status()->class_color}'>{$publicity->status()->name}</span>" : "" ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2"><span class="text-primary d-block">Data comemorativa: </span> <?= (date_fmt($publicity->date, "d/m/Y") ?? "") ?></div>
                        <div class="col-md-4 mb-2"><span class="text-primary d-block">Data inicial da campanha: </span> <?= !empty($publicity->date_start) ? date_fmt($publicity->date_start, "d/m/Y") : "Não definido"; ?></div>
                        <div class="col-md-4 mb-2"><span class="text-primary d-block">Data final da campanha: </span> <?= !empty($publicity->date_end) ? date_fmt($publicity->date_end, "d/m/Y") : "Não definido"; ?> </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2"><span class="text-primary d-block">Descrição: </span> <?= ($publicity->description ?? "") ?></div>
                    </div>
                </article>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col mb-2 mt-2">
            <section class="card border-default">
                <header class="card-header bg-default">
                    <h1 class="card-title h6 mb-1 mt-1"><i class="fa-solid fa-file-lines"></i> Anexos</h1>
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
                                <th scope="col" class="align-middle">Nome</th>
                                <th scope="col" class="align-middle">Usuário</th>
                                <th scope="col" class="align-middle">Data</th>
                                <th scope="col" class="align-middle" width="100px">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($anexos)) :
                                $qtd = 1;
                                foreach ($anexos as $anexo) :
                            ?>
                                    <tr>
                                        <td class="text-center align-middle"><?php echo $qtd ?></td>
                                        <td class="align-middle"><?= ($anexo->description ?? "") ?></td>
                                        <td class="align-middle"><?= ("{$anexo->user()->first_name} {$anexo->user()->last_name}" ?? "") ?></td>
                                        <td class="align-middle"><?= date_fmt($anexo->created_at) ?></td>
                                        <td class="align-middle table-acao text-center">
                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_view_<?= (md5($anexo->id) ?? "") ?>" title="Visualizar"><i class="fa fa-eye"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal_remove_<?= (md5($anexo->id) ?? "") ?>" title="Excluir"><i class="fa fa-trash"></i></button>
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
</div>

<?php $this->insert("publicity/remove", ["publicity" => $publicity]); ?>

<!-- novo-registro -->
<?php $this->insert("publicity/anexos/register", ["publicity" => $publicity->id]) ?>
<!-- fim modal novo-registro-->

<!-- modal para visualizar -->
<?php
if (isset($anexos) && is_array($anexos)) :
    foreach ($anexos as $anexo) :
        $this->insert("publicity/anexos/view", ["anexo" => $anexo]);
    endforeach;
endif;
?>
<!-- fim modal para visualizar -->

<?php
if (isset($anexos) && is_array($anexos)) :
    foreach ($anexos as $anexo) :
        $this->insert("publicity/anexos/remove", ["anexo" => $anexo]);
    endforeach;
endif;
?>