<?php $this->layout("_theme", ["head" => $head]); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col" id="pagina-header">
            <h5>Consultar Campanhas Publicitárias</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url() ?>"><i class="fa fa-tachometer-alt"></i> Inicial</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= url("publicity") ?>"><i class="fas fa-tasks"></i> Campanhas Publicitárias</a></li>
                </ol>
            </nav>
        </div>
        <!--fim pagina-header;-->
    </div>
    <!--<div class="row">-->
    <div class="row" id="painel_de_consulta">
        <div class="col">
            <form method="POST" action="<?= url("/publicity") ?>">
                <div class="ajax_response"></div>
                <section class="card border-default">
                    <header class="card-header bg-default">
                        <a data-toggle="collapse" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false">
                            <h4 class="card-title h6 mb-1 mt-1"><i class="fa fa-search pull-left"></i> Painel de busca <i class="fa fa-eye pull-right"></i></h4>
                        </a>
                    </header>
                    <div class="collapse show" id="collapseExample">
                        <article class="card-body">
                            <?= csrf_input() ?>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for='istatus'>Status: *</label><br />
                                    <select class="custom-select select2-js" name="status" id="istatus" required>
                                        <?php if (!empty($status)) : ?>
                                            <?php foreach ($status as $statusItem) : ?>
                                                <option value="<?= ($statusItem->id ?? "") ?>"><?= ($statusItem->name ?? "") ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="invalid-feedback">Informe o status</div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for='iSelectBuscar'>Tipo da busca: </label><br />
                                    <select class="custom-select select2-js" name="type" id="iSelectBuscar">
                                        <option value="" selected="selected" disabled="disabled">Selecione</option>
                                        <option value="name">Nome</option>
                                    </select>
                                    <div class="invalid-feedback">Informe o setor</div>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label for="iCampo">Campo: </label>
                                    <input type="text" class="form-control" name="search" id="iCampo" />
                                    <div class="invalid-feedback">
                                        Informe nome / email do usuário
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label for="iDataInicial">Data Inicial: </label>
                                    <input type="text" class="form-control date_serach input-data" name="date_start" id="iDataInicial" />
                                    <div class="invalid-feedback">
                                        Informe a data inicial do protocolo
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="iDataFinal">Data final: </label>
                                    <input type="text" class="form-control date_serach input-data" name="date_final" id="iDataFinal" />
                                    <div class="invalid-feedback">
                                        Informe a data final do protocolo
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for='iModelView'>Modo de exibição: </label>
                                    <select class="custom-select" name="order" id="iModelView">
                                        <option value="DESC"> Decrecente (do último para o primeiro registro)</option>
                                        <option value="ASC">Crescente (do primeiro para o último registro)</option>
                                    </select>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <button type="submit" name="nBuscarBT" value="BuscarBT" class="btn btn-primary"><i class="fa fa-search pull-left"></i> Buscar</button>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>
            </form>
        </div>
    </div>
    <!--<div class="row" id="painel_de_consulta">-->
    <div class="row">
        <div class="col mb-2 mt-2">
            <?= flash() ?>
        </div>
    </div>
    <div class="row">
        <div class="col mb-2 mt-2">
            <section class="card border-default">
                <header class="card-header bg-default">
                    <h1 class="card-title h6 mb-1 mt-1">Total de Registros Encontrados: <?= ($publicityTotal ?? "") ?></h1>
                </header>
                <article class="card-body py-0">
                    <div class="row">
                        <div class="col-12 my-2">
                            <a class="btn btn-sm btn-success pull-right" title="Adicionar" href="<?= url("publicity/register") ?>"><i class="fas fa-plus-square"></i>
                                Adicionar</a>
                        </div>
                    </div>
                </article>
                <div class="table-responsive">
                    <!--table-->
                    <table class="table table-striped table-bordered table-sm table-hover mb-0">
                        <thead class="bg-secondary">
                            <tr class="">
                                <th scope="col" class="align-middle" width="50px">#</th>
                                <th scope="col" class="align-middle">Campanha Publicitária</th>
                                <th scope="col" class="align-middle">Data</th>
                                <th scope="col" class="align-middle">Status</th>
                                <th scope="col" class="align-middle" width="100px">Ação</th>
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
                                        <td class="align-middle"><span class="p-1 rounded <?= ($publicity->status()->class_color ?? "") ?>"><?= ($publicity->status()->name ?? "") ?></span></td>
                                        <td class="align-middle table-acao text-center">
                                            <a class="btn btn-success btn-sm" href="<?= url("publicity/view/{$publicity->id}") ?>" title="Visualizar"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-primary btn-sm" href="<?= url("publicity/update/{$publicity->id}") ?>" title="Editar"><i class="fa fa-pencil-alt"></i></a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal_remove_<?= (md5($publicity->id) ?? "") ?>" title="Excluir"><i class="fa fa-trash"></i></button>
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

    <?php
    if (isset($publicities) && is_array($publicities)) :
        foreach ($publicities as $publicity) :
            $this->insert("publicity/remove", ["publicity" => $publicity]);
        endforeach;
    endif;
    ?>