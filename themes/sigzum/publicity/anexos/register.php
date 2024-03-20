<section class="modal fade" id="novo-registro" tabindex="-1" role="dialog">
    <article class="modal-dialog modal-md modal-dialog-centered" role="document">
        <section class="modal-content">
            <header class="modal-header bg-light">
                <h5 class="modal-title h6"><i class="fa-solid fa-file-lines"></i> Anexos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </header>
            <article class="modal-body">
                <form method="post" class="needs-validation" novalidate enctype="multipart/form-data" action="<?= url("publicity/anexo/register") ?>">
                    <?= csrf_input() ?>
                    <input type="hidden" name="publicity_id" value="<?= ($publicity ?? "") ?>">
                    <div class="ajax_response"></div>
                    <div class="form-row">
                        <div class="col-md-12 mb-2">
                            <label for="idesc">Descrição: *</label>
                            <textarea id="idesc" class="form-control" rows="5" name="description" required></textarea>
                            <div class="invalid-feedback">Informe a descrição.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div>
                                <label>Anexo:</label><br>
                            </div>
                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" name="url" id="iAnexo" required>
                                <label class="custom-file-label" for="iAnexo">Nenhum arquivo selecionado.</label>
                                <div class="invalid-feedback">Selecione o arquivo.</div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit"><i class="fa fa-check-circle" aria-hidden="true"></i> Salvar</button>
                </form>
            </article>
            <footer class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
            </footer>
        </section>
    </article>
</section>