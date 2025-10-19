<?php
    $pageTitle = 'Gerenciar Nacionalidades';
    require_once '../backend/conexao.php';

    $nacionalidades = [];
    $sql = "SELECT id_Nacionalidades, nacionalidade FROM Nacionalidades ORDER BY nacionalidade ASC";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
        $nacionalidades = $resultado->fetch_all(MYSQLI_ASSOC);
    }
    include_once './templates/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Gerenciar Nacionalidades</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNacionalidadeModal">
            Adicionar Nova
        </button>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col" style="width: 15%;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nacionalidades as $nacionalidade): ?>
                <tr>
                    <th scope="row"><?php echo htmlspecialchars($nacionalidade['id_Nacionalidades']); ?></th>
                    <td><?php echo htmlspecialchars($nacionalidade['nacionalidade']); ?></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editNacionalidadeModal"
                                data-nacionalidade-id="<?php echo $nacionalidade['id_Nacionalidades']; ?>"
                                data-nacionalidade-nome="<?php echo htmlspecialchars($nacionalidade['nacionalidade']); ?>">
                            Editar
                        </button>
                        <a href="/backend/deletar_nacionalidade.php?id=<?php echo $nacionalidade['id_Nacionalidades']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Atenção! Excluir uma nacionalidade pode causar erros se ela estiver sendo usada. Deseja continuar?');">
                           Excluir
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addNacionalidadeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Nova Nacionalidade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/backend/cadastrar_nacionalidade.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome da Nacionalidade</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editNacionalidadeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNacionalidadeModalLabel">Editar Nacionalidade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/backend/editar_nacionalidade.php" method="POST">
                    <input type="hidden" name="id_nacionalidade" id="edit_nacionalidade_id">
                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome da Nacionalidade</label>
                        <input type="text" class="form-control" id="edit_nome" name="nome" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once './templates/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var editNacionalidadeModal = document.getElementById('editNacionalidadeModal');
    editNacionalidadeModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var nacionalidadeId = button.getAttribute('data-nacionalidade-id');
        var nacionalidadeNome = button.getAttribute('data-nacionalidade-nome');

        var modalTitle = editNacionalidadeModal.querySelector('.modal-title');
        var modalInputId = document.getElementById('edit_nacionalidade_id');
        var modalInputNome = document.getElementById('edit_nome');

        modalTitle.textContent = 'Editar Nacionalidade: ' + nacionalidadeNome;
        modalInputId.value = nacionalidadeId;
        modalInputNome.value = nacionalidadeNome;
    });
});
</script>