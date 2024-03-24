<?php $this->layout("_theme", ["head" => $head]); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col" id="pagina-header">
            <h5>Novo registro</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url() ?>"><i class="fa fa-tachometer-alt"></i> Inicial</a> </li>
                    <li class="breadcrumb-item"><a href="<?= url("publicity") ?>"><i class="fas fa-tasks"></i> Campanhas Publicitárias</a></li>
                    <li class="breadcrumb-item"><a href="<?= url("publicity/register") ?>"><i class="fa-solid fa-plus"></i> Novo registro</a></li>
                </ol>
            </nav>
        </div>
        <!--fim pagina-header;-->
    </div>
    <div class="row">
        <div class="col">
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data" action="<?= url("publicity/register") ?>">
                <?= csrf_input() ?>
                <input type="hidden" name="id" />
                <div class="ajax_response"><?= flash() ?> </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title h6 mb-1 mt-1"><i class="fa-solid fa-plus"></i> Novo registro</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8 mb-3">
                                <label for="icompany">Campanha Publicitária: *</label>
                                <input type="text" name="campaign" id="icompany" class="form-control" required />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o nome da campanha</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="idate">Data comemorativa: *</label>
                                <input type="text" name="date" id="idate" class="form-control date_serach input-data" required />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe a data comemorativa</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="idesc">Descrição: * <small class="text-primary">Descreva a ideia de marketing</small></label>
                                <textarea name="description" id="idesc" class="form-control" rows="6" required></textarea>
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe a descrição</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for='istatus'>Status: *</label><br />
                                <select class="custom-select select2-js" name="status_id" id="istatus" required>
                                    <?php if (!empty($status)) : ?>
                                        <?php foreach ($status as $statusItem) : ?>
                                            <option value="<?= ($statusItem->id ?? "") ?>"><?= ($statusItem->name ?? "") ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="invalid-feedback">Informe o status</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="idatei">Data de início: </label>
                                <input type="text" name="date_start" id="idatei" class="form-control date_serach input-data" />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe a data comemorativa</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="idatee">Data de termino: </label>
                                <input type="text" name="date_end" id="idatee" class="form-control date_serach input-data" />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe a data comemorativa</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button class="btn btn-success" name="nSalvaHistorico" value="true" type="submit"><i class="fa fa-check-circle" aria-hidden="true"></i> Salvar</button>
                    <a class="btn btn-danger" href="<?= url_back() ?>"><i class="fa fa-close" aria-hidden="true"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>