<?php 
    // Define o título desta página específica
    $pageTitle = 'Gerenciar Filmes'; 
    
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
                <th scope="col">Ano de Lançamento</th>
                <th scope="col">Classificação</th>
                <th scope="col" style="width: 15%;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Duna: Parte 2</td>
                <td>2024</td>
                <td>14</td>
                <td>
                    <button class="btn btn-warning btn-sm">Editar</button>
                    <button class="btn btn-danger btn-sm">Excluir</button>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Oppenheimer</td>
                <td>2023</td>
                <td>16</td>
                <td>
                    <button class="btn btn-warning btn-sm">Editar</button>
                    <button class="btn btn-danger btn-sm">Excluir</button>
                </td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Interestelar</td>
                <td>2014</td>
                <td>10</td>
                <td>
                    <button class="btn btn-warning btn-sm">Editar</button>
                    <button class="btn btn-danger btn-sm">Excluir</button>
                </td>
            </tr>
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
                <form action="/backend/filmes_salvar.php" method="POST">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ano_lancamento" class="form-label">Ano de Lançamento</label>
                            <input type="number" class="form-control" id="ano_lancamento" name="ano_lancamento" min="1888" max="<?php echo date('Y') + 1; ?>" required>
                        </div>

                        <div class="col-md-4 mb-3">
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

                        <div class="col-md-4 mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select" id="categoria" name="id_categoria" required>
                                <option value="1">Ficção Científica</option>
                                <option value="2">Drama</option>
                                <option value="3">Ação</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="idioma" class="form-label">Idioma</label>
                            <select class="form-select" id="idioma" name="id_idioma" required>
                                <option value="1">Inglês</option>
                                <option value="2">Português</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nacionalidade" class="form-label">Nacionalidade (Opcional)</label> 
                            <select class="form-select" id="nacionalidade" name="id_nacionalidade">
                                <option value="">Selecione...</option>
                                <option value="1">Americana</option>
                                <option value="2">Brasileira</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar Filme</button>
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