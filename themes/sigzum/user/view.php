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
                <ul class="list-unstyled">
                    <li><b>Nome: </b> <?= ("{$user->first_name} {$user->last_name}" ?? "") ?>;</li>
                    <li><b>Email: </b> <?= ($user->email ?? "") ?>;</li>
                    <li><b>Setor: </b> <?= ($user->sector()->name ?? "") ?>;</li>
                    <li><b>Status: </b> <?= !empty($user->status) ? "<span class='p-1 rounded bg-success'>Acesso permitido</span>": "<span class='p-1 rounded bg-danger'>Acesso revogado</span>"; ?>;</li>
                    <li><b>Data de cadastro: </b> <?= (date_fmt($user->created_at) ?? "") ?>;</li>
                    <li><b>Data de última alteração: </b> <?= !empty($user->updated_at) ? date_fmt($user->updated_at) : "" ?>.</li>
                </ul>
            </article>
            <footer class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
            </footer>
        </section>
    </article>
</section>