<?php 
    // Define o título desta página específica
    $pageTitle = 'Gerenciar Atores'; 
    
    // Inclui o cabeçalho (início do nosso template)
    require_once './templates/header.php'; 
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Gerenciar Atores</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addActorModal">
            Adicionar Novo Ator
        </button>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome Completo</th>
                <th scope="col">Data de Nascimento</th>
                <th scope="col">Nacionalidade</th>
                <th scope="col" style="width: 15%;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Timothée Chalamet</td>
                <td>27/12/1995</td>
                <td>Americana</td>
                <td>
                    <button class="btn btn-warning btn-sm">Editar</button>
                    <button class="btn btn-danger btn-sm">Excluir</button>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Wagner Moura</td>
                <td>27/06/1976</td>
                <td>Brasileira</td>
                <td>
                    <button class="btn btn-warning btn-sm">Editar</button>
                    <button class="btn btn-danger btn-sm">Excluir</button>
                </td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Zendaya</td>
                <td>01/09/1996</td>
                <td>Americana</td>
                <td>
                    <button class="btn btn-warning btn-sm">Editar</button>
                    <button class="btn btn-danger btn-sm">Excluir</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addActorModal" tabindex="-1" aria-labelledby="addActorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addActorModalLabel">Cadastrar Novo Ator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/backend/atores_salvar.php" method="POST">
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
                                <option value="">Selecione...</option>
                                <option value="1">Americana</option>
                                <option value="2">Brasileira</option>
                                <option value="3">Britânica</option>
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
<?php 
    // Inclui o rodapé (fim do nosso template)
    require_once './templates/footer.php'; 
?>