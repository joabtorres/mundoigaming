<section class="modal fade" id="modal_view_<?= md5($user->id) ?>" tabindex="-1" role="dialog">
    <article class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <section class="modal-content">
            <header class="modal-header bg-default">
                <h5 class="modal-title"><i class="fas fa-tasks"></i> Usuários</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </header>
            <article class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="align-middle bg-secondary">Nome: </td>
                            <td class="align-middle"> <?= ("{$user->first_name} {$user->last_name}" ?? "") ?></td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">E-mail: </td>
                            <td class="align-middle"> <?= ($user->email ?? "") ?></td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Setor: </td>
                            <td class="align-middle"><?= ($user->sector()->name ?? "") ?></td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Status: </td>
                            <td class="align-middle"><?= !empty($user->status) ? "<span class='p-1 rounded bg-success'>Acesso permitido</span>" : "<span class='p-1 rounded bg-danger'>Acesso revogado</span>"; ?></td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Cadastro: </td>
                            <td class="align-middle"><?= (date_fmt($user->created_at) ?? "") ?></td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary" width="200px">Última alteração: </td>
                            <td class="align-middle"><?= !empty($user->updated_at) ? date_fmt($user->updated_at) : "" ?></td>
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