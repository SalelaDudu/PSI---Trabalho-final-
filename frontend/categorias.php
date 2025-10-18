<?php
    $pageTitle = 'Gerenciar Categorias';
    require_once '../backend/conexao.php';

    $categorias = [];
    $sql = "SELECT id_Categorias, categoria FROM Categorias ORDER BY categoria ASC";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
        $categorias = $resultado->fetch_all(MYSQLI_ASSOC);
    }
    $conn->close();

    require_once './templates/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Gerenciar Categorias</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoriaModal">
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
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <th scope="row"><?php echo htmlspecialchars($categoria['id_Categorias']); ?></th>
                    <td><?php echo htmlspecialchars($categoria['categoria']); ?></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editCategoriaModal"
                                data-categoria-id="<?php echo $categoria['id_Categorias']; ?>"
                                data-categoria-nome="<?php echo htmlspecialchars($categoria['categoria']); ?>">
                            Editar
                        </button>
                        <a href="/backend/deletar_categoria.php?id=<?php echo $categoria['id_Categorias']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Atenção! Excluir uma categoria pode causar erros se ela estiver sendo usada por um filme. Deseja continuar?');">
                           Excluir
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addCategoriaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Nova Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/backend/cadastrar_categoria.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome da Categoria</label>
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

<div class="modal fade" id="editCategoriaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoriaModalLabel">Editar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/backend/editar_categoria.php" method="POST">
                    <input type="hidden" name="id_categoria" id="edit_categoria_id">
                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome da Categoria</label>
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
    var editCategoriaModal = document.getElementById('editCategoriaModal');
    editCategoriaModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var categoriaId = button.getAttribute('data-categoria-id');
        var categoriaNome = button.getAttribute('data-categoria-nome');

        var modalTitle = editCategoriaModal.querySelector('.modal-title');
        var modalInputId = document.getElementById('edit_categoria_id');
        var modalInputNome = document.getElementById('edit_nome');

        modalTitle.textContent = 'Editar Categoria: ' + categoriaNome;
        modalInputId.value = categoriaId;
        modalInputNome.value = categoriaNome;
    });
});
</script>