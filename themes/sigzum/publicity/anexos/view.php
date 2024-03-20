<section class="modal fade" id="modal_view_<?= md5($anexo->id) ?>" tabindex="-1" role="dialog">
    <article class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <section class="modal-content">
            <header class="modal-header bg-default">
                <h5 class="modal-title"><i class="fa-solid fa-file-lines"></i> Anexos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </header>
            <article class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="align-middle bg-secondary">Arquivo: </td>
                            <td class="align-middle"> <?= ($anexo->description ?? "") ?></td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Vizualizar: </td>
                            <td class="align-middle"> <a href="<?= url(CONF_UPLOAD_DIR . "/{$anexo->url}") ?>" class="btn btn-primary m-0 p-1" target="_blank"> <i class="fa-solid fa-file-lines"></i> Baixar</a></td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Usuário: </td>
                            <td class="align-middle"> <?= ("{$anexo->user()->first_name} {$anexo->user()->last_name}" ?? "") ?> </td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Campanha: </td>
                            <td class="align-middle"><?= ("{$anexo->publicity()->campaign}" ?? "") ?></td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Cadastro: </td>
                            <td class="align-middle"><?= (date_fmt($anexo->created_at) ?? "") ?> </td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary" width="200px">Última alteração: </td>
                            <td class="align-middle"><?= !empty($anexo->updated_at) ? date_fmt($anexo->updated_at) : "" ?> </td>
                        </tr>

                    </tbody>
                </table>
            </article>
            <footer class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
            </footer>
        </section>
    </article>
</section>