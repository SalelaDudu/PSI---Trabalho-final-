<?php
    $pageTitle = 'Gerenciar Nacionalidades';
    require_once '../backend/conexao.php';

    // Busca todas as nacionalidades existentes para listar na tabela
    $nacionalidades = [];
    $sql = "SELECT id_Nacionalidades, nacionalidade FROM Nacionalidades ORDER BY nacionalidade ASC";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
        $nacionalidades = $resultado->fetch_all(MYSQLI_ASSOC);
    }
    $conn->close();

    require_once './templates/header.php';
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
            <?php if (empty($nacionalidades)): ?>
                <tr>
                    <td colspan="3" class="text-center">Nenhuma nacionalidade encontrada.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($nacionalidades as $nacionalidade): ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars($nacionalidade['id_Nacionalidades']); ?></th>
                        <td><?php echo htmlspecialchars($nacionalidade['nacionalidade']); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
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

<?php require_once './templates/footer.php'; ?>