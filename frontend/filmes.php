<?php
$pageTitle = 'Gerenciar Filmes';
require_once '../backend/conexao.php';


$filmes = [];
$categorias = [];
$idiomas = [];
$nacionalidades = [];
$atores = [];
$atores_filme = [];;


// pega o id do filme via get
$id_filme = isset($_GET['id_filme']) ? intval($_GET['id_filme']) : 0;

// ==================== CONSULTAS ====================

// Filmes
$sql_filmes = "SELECT 
    f.id_Filmes, f.titulo, f.descricao, f.ano, f.classificacao, 
    f.Categorias_idCategorias, f.Nacionalidade_id_Nacionalidades,
    c.categoria AS nome_categoria,
    i.id_idiomas AS id_idioma
FROM Filmes AS f
LEFT JOIN Categorias AS c ON f.Categorias_idCategorias = c.id_Categorias
LEFT JOIN Filmes_has_idioma AS fhi ON f.id_Filmes = fhi.Filmes_id_Filmes
LEFT JOIN idiomas AS i ON fhi.idiomas_id_idiomas = i.id_idiomas
ORDER BY f.titulo ASC";
$filmes = $conn->query($sql_filmes)->fetch_all(MYSQLI_ASSOC);

// Categorias
$categorias = $conn->query("SELECT id_Categorias, categoria FROM Categorias ORDER BY categoria ASC")->fetch_all(MYSQLI_ASSOC);

// Idiomas
$idiomas = $conn->query("SELECT id_idiomas, idioma FROM idiomas ORDER BY idioma ASC")->fetch_all(MYSQLI_ASSOC);

// Nacionalidades
$nacionalidades = $conn->query("SELECT id_Nacionalidades, nacionalidade FROM Nacionalidades ORDER BY nacionalidade ASC")->fetch_all(MYSQLI_ASSOC);

// Atores
$atores = $conn->query("SELECT id_Atores, nome FROM Atores ORDER BY nome ASC")->fetch_all(MYSQLI_ASSOC);

// Atores do filme
if ($id_filme > 0) {
    $sql_atores_filme = "
        SELECT a.id_Atores, a.nome 
        FROM filmes_has_atores fa
        JOIN Atores a ON fa.atores_id_atores = a.id_Atores
        WHERE fa.filmes_id_filmes = $id_filme
    ";
    $resultado_atores_filme = $conn->query($sql_atores_filme);
    if ($resultado_atores_filme)
        $atores_filme = $resultado_atores_filme->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
require_once './templates/header.php';
?>

<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Gerenciar Filmes</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMovieModal">
      Adicionar Novo Filme
    </button>
  </div>

  <table id="tabelaFilmes" class="table table-striped table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Título</th>
        <th>Ano</th>
        <th>Categoria</th>
        <th>Classificação</th>
        <th style="width: 20%;">Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($filmes as $filme): ?>
        <tr>
          <th scope="row"><?= $filme['id_Filmes']; ?></th>
          <td><?= htmlspecialchars($filme['titulo']); ?></td>
          <td><?= htmlspecialchars($filme['ano']); ?></td>
          <td><?= htmlspecialchars($filme['nome_categoria']); ?></td>
          <td><?= htmlspecialchars($filme['classificacao']); ?></td>
          <td>
            <a href="?id_filme=<?= $filme['id_Filmes']; ?>" class="btn btn-secondary btn-sm">
              Atores
            </a>

            <button type="button" class="btn btn-warning btn-sm"
              data-bs-toggle="modal"
              data-bs-target="#editMovieModal"
              data-filme-id="<?= $filme['id_Filmes']; ?>"
              data-filme-titulo="<?= htmlspecialchars($filme['titulo']); ?>"
              data-filme-descricao="<?= htmlspecialchars($filme['descricao']); ?>"
              data-filme-ano="<?= $filme['ano']; ?>"
              data-filme-classificacao="<?= $filme['classificacao']; ?>"
              data-filme-categoria-id="<?= $filme['Categorias_idCategorias']; ?>"
              data-filme-idioma-id="<?= $filme['id_idioma']; ?>"
              data-filme-nacionalidade-id="<?= $filme['Nacionalidade_id_Nacionalidades']; ?>">
              Editar
            </button>

            <a href="/backend/deletar_filme.php?id=<?= $filme['id_Filmes']; ?>"
              class="btn btn-danger btn-sm"
              onclick="return confirm('Tem certeza que deseja excluir este filme?');">
              Excluir
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


<!-- MODAL: Atores do Filme -->
<div class="modal fade" id="atoresFilmesModal" tabindex="-1" aria-labelledby="atoresFilmesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-3">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="atoresFilmesModalLabel">🎬 Atores do Filme</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body bg-light">
        <?php if ($id_filme > 0): ?>
        <!-- Formulário de vincular ator -->
        <form action="/backend/cadastrar_ator_filme.php" method="POST" class="mb-4">
            <input type="hidden" name="id_filme" value="<?= $id_filme; ?>">

            <div class="mb-3 d-flex align-items-end gap-2">
                <div class="flex-grow-1">
                    <label for="id_ator" class="form-label fw-semibold">Selecione um ator</label>
                    <select name="id_ator" id="id_ator" class="form-select" required>
                        <option value="">Selecione um ator</option>
                        <?php foreach ($atores as $ator): ?>
                            <option value="<?= $ator['id_Atores']; ?>">
                                <?= htmlspecialchars($ator['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <button class="btn btn-success px-3" type="submit">➕ Vincular</button>
                </div>
            </div>
        </form>

        <hr>
        <h6 class="fw-bold mb-3">Atores já vinculados:</h6>

        <?php if (!empty($atores_filme)): ?>
            <ul class="list-group list-group-flush shadow-sm rounded">
                <?php foreach ($atores_filme as $ator_filme): ?>
                    <li class="list-group-item">
                        🎭 <?= htmlspecialchars($ator_filme['nome']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Nenhum ator vinculado a este filme.
            </div>
        <?php endif; ?>
        <?php else: ?>
            <p class="text-center text-muted">Selecione um filme para ver seus atores.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!--Modal adicionar filmes-->
<div class="modal fade" id="addMovieModal" tabindex="-1" aria-labelledby="addMovieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMovieModalLabel">Cadastrar Novo Filme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/backend/cadastrar_filme.php" method="POST">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ano_lancamento" class="form-label">Ano de Lançamento</label>
                            <input type="number" class="form-control" id="ano_lancamento" name="ano" min="1888" max="<?php echo date('Y') + 1; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="classificacao" class="form-label">Classificação Indicativa</label>
                            <select class="form-select" id="classificacao" name="classificacao" required>
                                <option value="L">L - Livre</option>
                                <option value="10">10 anos</option>
                                <option value="12">12 anos</option>
                                <option value="14">14 anos</option>
                                <option value="16">16 anos</option>
                                <option value="18">18 anos</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select" id="categoria" name="id_categoria" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo htmlspecialchars($categoria['id_Categorias']); ?>">
                                        <?php echo htmlspecialchars($categoria['categoria']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="idioma" class="form-label">Idioma</label>
                            <select class="form-select" id="idioma" name="id_idioma" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($idiomas as $idioma): ?>
                                    <option value="<?php echo htmlspecialchars($idioma['id_idiomas']); ?>">
                                        <?php echo htmlspecialchars($idioma['idioma']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nacionalidade" class="form-label">Nacionalidade (Opcional)</label>
                            <select class="form-select" id="nacionalidade" name="id_nacionalidade">
                                <option value="">Selecione...</option>
                                <?php foreach ($nacionalidades as $nacionalidade): ?>
                                    <option value="<?php echo htmlspecialchars($nacionalidade['id_Nacionalidades']); ?>">
                                        <?php echo htmlspecialchars($nacionalidade['nacionalidade']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Modal editar filmes-->
<div class="modal fade" id="editMovieModal" tabindex="-1" aria-labelledby="editMovieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMovieModalLabel">Editar Filme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/backend/editar_filmes.php" method="POST">
                    <input type="hidden" name="id_filme" id="edit_filme_id">

                    <div class="mb-3">
                        <label for="edit_titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit_titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="edit_descricao" name="descricao" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_ano" class="form-label">Ano de Lançamento</label>
                            <input type="number" class="form-control" id="edit_ano" name="ano" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_classificacao" class="form-label">Classificação Indicativa</label>
                            <select class="form-select" id="edit_classificacao" name="classificacao" required>
                                <option value="L">L - Livre</option>
                                <option value="10">10 anos</option>
                                <option value="12">12 anos</option>
                                <option value="14">14 anos</option>
                                <option value="16">16 anos</option>
                                <option value="18">18 anos</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_categoria" class="form-label">Categoria</label>
                            <select class="form-select" id="edit_categoria" name="id_categoria" required>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['id_Categorias']; ?>"><?php echo htmlspecialchars($categoria['categoria']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_idioma" class="form-label">Idioma</label>
                            <select class="form-select" id="edit_idioma" name="id_idioma" required>
                                <?php foreach ($idiomas as $idioma): ?>
                                    <option value="<?php echo $idioma['id_idiomas']; ?>"><?php echo htmlspecialchars($idioma['idioma']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="edit_nacionalidade" class="form-label">Nacionalidade (Opcional)</label>
                            <select class="form-select" id="edit_nacionalidade" name="id_nacionalidade">
                                <option value="">Selecione...</option>
                                <?php foreach ($nacionalidades as $nacionalidade): ?>
                                    <option value="<?php echo $nacionalidade['id_Nacionalidades']; ?>"><?php echo htmlspecialchars($nacionalidade['nacionalidade']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
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

<?php if ($id_filme): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = new bootstrap.Modal(document.getElementById('atoresFilmesModal'));
    modal.show();
});
</script>
<?php endif; ?>
