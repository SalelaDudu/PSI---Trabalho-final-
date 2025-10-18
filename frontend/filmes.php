<?php 
    $pageTitle = 'Gerenciar Filmes'; 
    require_once '../backend/conexao.php';

    $filmes = [];
    $categorias = [];
    $idiomas = [];
    $nacionalidades = [];

    // Qpega info dos filmes pra editar 
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
    $resultado_filmes = $conn->query($sql_filmes);
    if ($resultado_filmes) {
        $filmes = $resultado_filmes->fetch_all(MYSQLI_ASSOC);
    }

    // cata os dado pra tabela
    $sql_categorias = "SELECT id_Categorias, categoria FROM Categorias ORDER BY categoria ASC";
    $resultado_categorias = $conn->query($sql_categorias);
    if ($resultado_categorias) $categorias = $resultado_categorias->fetch_all(MYSQLI_ASSOC);

    $sql_idiomas = "SELECT id_idiomas, idioma FROM idiomas ORDER BY idioma ASC";
    $resultado_idiomas = $conn->query($sql_idiomas);
    if ($resultado_idiomas) $idiomas = $resultado_idiomas->fetch_all(MYSQLI_ASSOC);

    $sql_nacionalidades = "SELECT id_Nacionalidades, nacionalidade FROM Nacionalidades ORDER BY nacionalidade ASC";
    $resultado_nacionalidades = $conn->query($sql_nacionalidades);
    if ($resultado_nacionalidades) $nacionalidades = $resultado_nacionalidades->fetch_all(MYSQLI_ASSOC);
    
    $conn->close();
    require_once './templates/header.php'; 
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Gerenciar Filmes</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMovieModal">
            Adicionar Novo Filme
        </button>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Título</th>
                <th scope="col">Ano</th>
                <th scope="col">Categoria</th>
                <th scope="col">Classificação</th>
                <th scope="col" style="width: 20%;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filmes as $filme): ?>
                <tr>
                    <th scope="row"><?php echo $filme['id_Filmes']; ?></th>
                    <td><?php echo htmlspecialchars($filme['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($filme['ano']); ?></td>
                    <td><?php echo htmlspecialchars($filme['nome_categoria']); ?></td>
                    <td><?php echo htmlspecialchars($filme['classificacao']); ?></td>
                    <td>
                        <a href="filme_atores.php?id=<?php echo $filme['id_Filmes']; ?>" class="btn btn-info btn-sm">Atores</a>
                        
                        <button type="button" class="btn btn-warning btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editMovieModal"
                                data-filme-id="<?php echo $filme['id_Filmes']; ?>"
                                data-filme-titulo="<?php echo htmlspecialchars($filme['titulo']); ?>"
                                data-filme-descricao="<?php echo htmlspecialchars($filme['descricao']); ?>"
                                data-filme-ano="<?php echo $filme['ano']; ?>"
                                data-filme-classificacao="<?php echo $filme['classificacao']; ?>"
                                data-filme-categoria-id="<?php echo $filme['Categorias_idCategorias']; ?>"
                                data-filme-idioma-id="<?php echo $filme['id_idioma']; ?>"
                                data-filme-nacionalidade-id="<?php echo $filme['Nacionalidade_id_Nacionalidades']; ?>">
                            Editar
                        </button>
                        <a href="/backend/excluir_filme.php?id=<?php echo $filme['id_Filmes']; ?>" 
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editMovieModal = document.getElementById('editMovieModal');
        editMovieModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;

            // Extrai as informações dos atributos
            var filmeId = button.getAttribute('data-filme-id');
            var titulo = button.getAttribute('data-filme-titulo');
            var descricao = button.getAttribute('data-filme-descricao');
            var ano = button.getAttribute('data-filme-ano');
            var classificacao = button.getAttribute('data-filme-classificacao');
            var categoriaId = button.getAttribute('data-filme-categoria-id');
            var idiomaId = button.getAttribute('data-filme-idioma-id');
            var nacionalidadeId = button.getAttribute('data-filme-nacionalidade-id');

            // Atualiza os campos do modal
            var modalTitle = editMovieModal.querySelector('.modal-title');
            modalTitle.textContent = 'Editar Filme: ' + titulo;

            document.getElementById('edit_filme_id').value = filmeId;
            document.getElementById('edit_titulo').value = titulo;
            document.getElementById('edit_descricao').value = descricao;
            document.getElementById('edit_ano').value = ano;
            document.getElementById('edit_classificacao').value = classificacao;
            document.getElementById('edit_categoria').value = categoriaId;
            document.getElementById('edit_idioma').value = idiomaId;
            document.getElementById('edit_nacionalidade').value = nacionalidadeId;
        });
    });
</script>