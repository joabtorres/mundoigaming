<section class="modal fade" id="novo-registro" tabindex="-1" role="dialog">
    <article class="modal-dialog modal-md modal-dialog-centered" role="document">
        <section class="modal-content">
            <header class="modal-header bg-light">
                <h5 class="modal-title"><i class="fa-solid fa-swatchbook"></i> Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </header>
            <article class="modal-body">
                <form method="post" class="needs-validation" novalidate enctype="multipart/form-data" action="<?= url("status/register") ?>">
                    <?= csrf_input() ?>
                    <div class="ajax_response"><?= flash() ?></div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for='icompany'>Empresa: </label><br />
                            <select class="custom-select select2-js" name="company" id="icompany">
                                <?php if (!empty($companies)) : ?>
                                    <?php foreach ($companies as $company) : ?>
                                        <option value="<?= ($company->id ?? "") ?>"><?= ($company->full_name ?? "") ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="invalid-feedback">Informe o setor</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="inome">Status: *</label>
                            <input name="name" id="inome" class="form-control" required />
                            <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o nome completo</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for='icor'>Cores: </label><br />
                            <select class="custom-select select2-js" name="class_color" id="icor">
                                <?php foreach (bgcolor_options() as $bgColor) :  ?>
                                    <option value="<?= ($bgColor["value"] ?? "") ?>"><?= ($bgColor["label"] ?? "") ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Informe o setor</div>
                        </div>
                    </div>
                    <button class="btn btn-success" name="nSalvaHistorico" value="true" type="submit"><i class="fa fa-check-circle" aria-hidden="true"></i> Salvar</button>
                </form>
            </article>
            <footer class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
            </footer>
        </section>
    </article>
</section>