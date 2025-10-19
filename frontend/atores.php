<?php
$pageTitle = 'Gerenciar Atores';
require_once '../backend/conexao.php';

$nacionalidades = [];
$atores = [];
$filmes_ator = [];

// ID do ator selecionado (para abrir o modal)
$id_ator = isset($_GET['id_ator']) ? intval($_GET['id_ator']) : 0;

// ==================== CONSULTAS ====================

// Nacionalidades
$sql_nacionalidades = "SELECT id_Nacionalidades, nacionalidade FROM Nacionalidades ORDER BY nacionalidade ASC";
$nacionalidades = $conn->query($sql_nacionalidades)->fetch_all(MYSQLI_ASSOC);

// Atores
$sql_atores = "
    SELECT a.id_Atores, a.nome, a.sobrenome, a.nascimento, n.nacionalidade 
    FROM Atores a
    JOIN Nacionalidades n ON a.Nacionalidade_idNacionalidades = n.id_Nacionalidades
    ORDER BY a.nome ASC
";
$atores = $conn->query($sql_atores)->fetch_all(MYSQLI_ASSOC);

// Filmes estrelados (quando o ator é selecionado)
if ($id_ator > 0) {
  $sql_filmes_ator = "
        SELECT f.id_Filmes, f.titulo, f.ano, c.categoria
        FROM filmes_has_atores fa
        JOIN Filmes f ON fa.filmes_id_filmes = f.id_Filmes
        JOIN Categorias c ON f.Categorias_idCategorias = c.id_Categorias
        WHERE fa.atores_id_atores = $id_ator
        ORDER BY f.titulo ASC
    ";
  $resultado_filmes_ator = $conn->query($sql_filmes_ator);
  if ($resultado_filmes_ator)
    $filmes_ator = $resultado_filmes_ator->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
require_once './templates/header.php';
?>

<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Gerenciar Atores</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAtorModal">
      Adicionar Novo Ator
    </button>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <table id="tabelaAtores" class="table table-striped table-hover align-middle" style="width:100%">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Nome Completo</th>
            <th>Nascimento</th>
            <th>Nacionalidade</th>
            <th style="width: 20%;">Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($atores as $ator): ?>
            <tr>
              <th scope="row"><?= $ator['id_Atores']; ?></th>
              <td><?= htmlspecialchars($ator['nome'] . ' ' . $ator['sobrenome']); ?></td>
              <td><?= htmlspecialchars($ator['nascimento']); ?></td>
              <td><?= htmlspecialchars($ator['nacionalidade']); ?></td>
              <td>
                <a href="?id_ator=<?= $ator['id_Atores']; ?>" class="btn btn-secondary btn-sm">
                  Filmes estrelados
                </a>

                <button type="button" class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#editAtorModal"
                        data-ator-id="<?= $ator['id_Atores']; ?>"
                        data-ator-nome="<?= htmlspecialchars($ator['nome']); ?>"
                        data-ator-sobrenome="<?= htmlspecialchars($ator['sobrenome']); ?>">
                  Editar
                </button>

                <a href="/backend/deletar_ator.php?id=<?= $ator['id_Atores']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Tem certeza que deseja excluir este ator?');">
                  Excluir
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL: Filmes Estrelados -->
<div class="modal fade" id="filmesEstreladosModal" tabindex="-1" aria-labelledby="filmesEstreladosModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-3">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="filmesEstreladosModalLabel">🎬 Filmes estrelados</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body bg-light">
        <?php if ($id_ator > 0): ?>
          <?php if (!empty($filmes_ator)): ?>
            <ul class="list-group list-group-flush shadow-sm rounded">
              <?php foreach ($filmes_ator as $filme): ?>
                <li class="list-group-item">
                  🎞️ <strong><?= htmlspecialchars($filme['titulo']); ?></strong>
                  (<?= htmlspecialchars($filme['ano']); ?>)
                  <span class="badge bg-secondary"><?= htmlspecialchars($filme['categoria']); ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <div class="alert alert-warning text-center">
              Nenhum filme vinculado a este ator.
            </div>
          <?php endif; ?>
        <?php else: ?>
          <p class="text-center text-muted">Selecione um ator para ver seus filmes estrelados.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- MODAL: Adicionar Novo Ator -->
<div class="modal fade" id="addAtorModal" tabindex="-1" aria-labelledby="addAtorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAtorModalLabel">Cadastrar Novo Ator</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/backend/cadastrar_ator.php" method="POST">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="sobrenome" class="form-label">Sobrenome</label>
              <input type="text" class="form-control" id="sobrenome" name="sobrenome">
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="nascimento" class="form-label">Data de Nascimento</label>
              <input type="date" class="form-control" id="nascimento" name="nascimento">
            </div>
            <div class="col-md-4 mb-3">
              <label for="sexo" class="form-label">Sexo</label>
              <select class="form-select" id="sexo" name="sexo" required>
                <option value="MASCULINO">Masculino</option>
                <option value="FEMININO">Feminino</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="nacionalidade" class="form-label">Nacionalidade</label>
              <select class="form-select" id="nacionalidade" name="id_nacionalidade" required>
                <?php foreach ($nacionalidades as $nacionalidade): ?>
                  <option value="<?= $nacionalidade['id_Nacionalidades']; ?>">
                    <?= htmlspecialchars($nacionalidade['nacionalidade']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar Ator</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- MODAL: Editar Ator -->
<div class="modal fade" id="editAtorModal" tabindex="-1" aria-labelledby="editAtorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAtorModalLabel">Editar Ator</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="/backend/editar_ator.php" method="POST">
          <input type="hidden" id="edit-id-ator" name="id_ator">

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="edit-nome" class="form-label">Nome</label>
              <input type="text" class="form-control" id="edit-nome" name="nome" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="edit-sobrenome" class="form-label">Sobrenome</label>
              <input type="text" class="form-control" id="edit-sobrenome" name="sobrenome">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
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
  <?php if ($id_ator): ?>
    var modal = new bootstrap.Modal(document.getElementById('filmesEstreladosModal'));
    modal.show();
  <?php endif; ?>

  const editModal = document.getElementById('editAtorModal');
  if (editModal) {
    editModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;

      // Dados vindos dos atributos do botão
      const id = button.getAttribute('data-ator-id');
      const nome = button.getAttribute('data-ator-nome');
      const sobrenome = button.getAttribute('data-ator-sobrenome');

      // Seleciona os inputs do modal
      const inputId = editModal.querySelector('#edit-id-ator');
      const inputNome = editModal.querySelector('#edit-nome');
      const inputSobrenome = editModal.querySelector('#edit-sobrenome');

      //preenche os valores
      inputId.value = id;
      inputNome.value = nome;
      inputSobrenome.value = sobrenome;
    });
  }
});
</script>


<script>