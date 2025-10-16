<?php 
    // Define o título desta página específica
    $pageTitle = 'Gerenciar Filmes'; 
    
    // 1. CONEXÃO E BUSCA DE DADOS (Tudo em um lugar só)
    // -----------------------------------------------------------
    require_once '../backend/conexao.php'; // Inclui a conexão

    // Inicializa os arrays que vamos usar
    $filmes = [];
    $categorias = [];
    $idiomas = [];
    $nacionalidades = [];

    // Busca os FILMES para listar na tabela principal (com JOIN para pegar o nome da categoria)
    $sql_filmes = "SELECT f.id_Filmes, f.titulo, f.ano, f.classificacao, c.categoria AS nome_categoria
                   FROM Filmes AS f
                   LEFT JOIN Categorias AS c ON f.Categorias_idCategorias = c.id_Categorias
                   ORDER BY f.titulo ASC";
    $resultado_filmes = $conn->query($sql_filmes);
    if ($resultado_filmes->num_rows > 0) {
        $filmes = $resultado_filmes->fetch_all(MYSQLI_ASSOC);
    }

    // Busca as CATEGORIAS para o formulário
    $sql_categorias = "SELECT id_Categorias, categoria FROM Categorias ORDER BY categoria ASC";
    $resultado_categorias = $conn->query($sql_categorias);
    if ($resultado_categorias->num_rows > 0) {
        $categorias = $resultado_categorias->fetch_all(MYSQLI_ASSOC);
    }

    // Busca os IDIOMAS para o formulário
    $sql_idiomas = "SELECT id_Idiomas, idioma FROM Idiomas ORDER BY idioma ASC";
    $resultado_idiomas = $conn->query($sql_idiomas);
    if ($resultado_idiomas->num_rows > 0) {
        $idiomas = $resultado_idiomas->fetch_all(MYSQLI_ASSOC);
    }

    // Busca as NACIONALIDADES para o formulário
    $sql_nacionalidades = "SELECT id_Nacionalidades, nacionalidade FROM Nacionalidades ORDER BY nacionalidade ASC";
    $resultado_nacionalidades = $conn->query($sql_nacionalidades);
    if ($resultado_nacionalidades->num_rows > 0) {
        $nacionalidades = $resultado_nacionalidades->fetch_all(MYSQLI_ASSOC);
    }
    
    // Fecha a conexão APENAS UMA VEZ, após todas as consultas
    $conn->close();

    // Inclui o cabeçalho (início do nosso template)
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
                <th scope="col" style="width: 15%;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($filmes)): ?>
                <tr>
                    <td colspan="6" class="text-center">Nenhum filme encontrado. Cadastre o primeiro!</td>
                </tr>
            <?php else: ?>
                <?php foreach ($filmes as $filme): ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars($filme['id_Filmes']); ?></th>
                        <td><?php echo htmlspecialchars($filme['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($filme['ano']); ?></td>
                        <td><?php echo htmlspecialchars($filme['nome_categoria']); ?></td>
                        <td><?php echo htmlspecialchars($filme['classificacao']); ?></td>
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
                                    <option value="<?php echo htmlspecialchars($idioma['id_Idiomas']); ?>">
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

<?php 
    // Inclui o rodapé (fim do nosso template)
    require_once './templates/footer.php'; 
?>