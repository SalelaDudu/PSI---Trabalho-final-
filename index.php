<?php 
    $pageTitle = 'Página Inicial'; 
    
    require_once './frontend/templates/header.php'; 
?>

<div class="p-5 mb-4 bg-white rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Bem-vindo ao IFES Movie Data Base!</h1>
        <p class="col-md-8 fs-4">
            O seu portal para gerenciar informações sobre filmes, atores, categorias e muito mais.
            Utilize a barra de navegação acima para começar.
        </p>
        <a href="/frontend/filmes.php" class="btn btn-primary btn-lg" type="button">Ver Filmes</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Gerenciar Atores</h5>
                <p class="card-text">Adicione, edite e visualize os atores do seu banco de dados.</p>
                <a href="/frontend/atores.php" class="btn btn-secondary">Ir para Atores</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Atualizações em breve</h5>
                <p class="card-text">Aguarde nossas novidades!</p>
            </div>
        </div>
    </div>
</div>
<?php 
    require_once './frontend/templates/footer.php'; 
?>