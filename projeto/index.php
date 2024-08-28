<!DOCTYPE html>
<html lang="pt-BR">
<?php include 'partials/head.php'; ?>
<body>
    <?php include 'partials/sidebar.php'; ?>

    <div class="content">
        
        <div class="content-section" id="home-section">
            <h2>Adicionar Registro</h2>
            <form id="multiStepForm" action="http://localhost/projeto/controllers/register.php" method="POST">
                
                <div class="step active">
                    <h4>Informações Gerais</h4>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <button type="button" class="btn btn-primary next-btn">Próximo</button>
                </div>

                <div class="step">
                    <h4>Documento</h4>
                    <div class="mb-3">
                        <label for="tipo_documento" class="form-label">Tipo de Documento:</label>
                        <select id="tipo_documento" name="tipo_documento" class="form-select" required>
                            <option value="CPF">CPF</option>
                            <option value="CNH">CNH</option>
                            <option value="RG">RG</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="valor_documento" class="form-label">Valor:</label>
                        <input type="number" class="form-control" id="valor_documento" name="valor_documento">
                    </div>
                    <div class="mb-3">
                        <label for="data_criacao" class="form-label">Data de Criação:</label>
                        <input type="date" class="form-control" id="data_criacao" name="data_criacao" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_validade" class="form-label">Data de Validade:</label>
                        <input type="date" class="form-control" id="data_validade" name="data_validade">
                    </div>
                    <button type="button" class="btn btn-secondary prev-btn">Voltar</button>
                    <button type="button" class="btn btn-primary next-btn">Próximo</button>
                </div>

                <div class="step">
                    <h4>Endereço</h4>
                    <div class="mb-3">
                        <label for="tipo_endereco" class="form-label">Tipo de Endereço:</label>
                        <select id="tipo_endereco" name="tipo_endereco" class="form-select" required>
                            <option value="Casa">Casa</option>
                            <option value="Trabalho">Trabalho</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cep" class="form-label">CEP:</label>
                        <input type="text" class="form-control" id="cep" name="cep" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado:</label>
                        <input type="text" class="form-control" id="estado" name="estado" required>
                    </div>
                    <div class="mb-3">
                        <label for="cidade" class="form-label">Cidade:</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" required>
                    </div>
                    <div class="mb-3">
                        <label for="bairro" class="form-label">Bairro:</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" required>
                    </div>
                    <div class="mb-3">
                        <label for="rua" class="form-label">Rua:</label>
                        <input type="text" class="form-control" id="rua" name="rua" required>
                    </div>
                    <button type="button" class="btn btn-secondary prev-btn">Voltar</button>
                    <button type="button" class="btn btn-primary next-btn">Próximo</button>
                </div>

                <div class="step">
                    <h4>Contato</h4>
                    <div class="mb-3">
                        <label for="tipo_contato" class="form-label">Tipo de Contato:</label>
                        <select id="tipo_contato" name="tipo_contato" class="form-select" required>
                            <option value="Email">Email</option>
                            <option value="Celular">Celular</option>
                            <option value="Telefone">Telefone</option>
                            <option value="Website">Website</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="valor_contato" class="form-label">Valor:</label>
                        <input type="text" class="form-control" id="valor_contato" name="valor_contato" required>
                    </div>
                    <button type="button" class="btn btn-secondary prev-btn">Voltar</button>
                    <button type="button" class="btn btn-primary" id="submit-btn">Enviar</button>
                    <button type="submit" style="display: none;" id="hidden-submit-btn"></button>
                </div>
            </form>
        </div>

        
        <div class="content-section" id="busca-section">
            <h2>Procurar Registro</h2>
            <form id="search-form" action="http://localhost/projeto/controllers/search.php" method="GET">
                <input type="text" name="nome" placeholder="Nome">
                <input type="text" name="documento" placeholder="Documento">
                <input type="text" name="endereco" placeholder="Endereço">
                <input type="text" name="contato" placeholder="Contato">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
            <div id="search-results"></div>
        </div>
    </div>

    <?php include 'partials/footer.php'; ?>
    <script src="partials/scripts.js"></script>
</body>
</html>