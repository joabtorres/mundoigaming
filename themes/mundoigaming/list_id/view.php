<section class="modal fade" id="modal_view_<?= md5($id->id) ?>" tabindex="-1" role="dialog">
    <article class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <section class="modal-content">
            <header class="modal-header bg-default">
                <h5 class="modal-title"><i class="fa-solid fa-list-ol"></i> Id</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </header>
            <article class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="align-middle bg-secondary" width="200px">ID: </td>
                            <td class="align-middle"> <?= ("{$id->id}" ?? "") ?> </td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Nome: </td>
                            <td class="align-middle"> <?= ("{$id->name}" ?? "") ?> </td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Cadastro: </td>
                            <td class="align-middle"><?= (date_fmt($id->created_at) ?? "") ?> </td>
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