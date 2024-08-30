<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nova Pessoa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../partials/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #9d00db; 
            color: #e0e0e0;
            margin: 0;
        }

        .main-content {
            margin-left: 270px; /* Ajustado para combinar com o tamanho da sidebar */
            padding: 20px;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff; 
            border-radius: 12px; /* Bordas mais arredondadas */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Sombra mais pronunciada */
            padding: 20px;
        }

        h1 {
            color: #ffffff;
        }

        .form-control,
        .form-select {
            border-radius: 8px; 
            background-color: #e0e0e0; 
            color: #333; 
            border: 1px solid #004d99; 
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #003c7d; 
            box-shadow: 0 0 0 0.2rem rgba(0, 61, 122, 0.25); 
        }

        .btn-primary {
            background-color: #004d99; 
            border-color: #003c7d; 
            border-radius: 8px; 
        }

        .btn-primary:hover {
            background-color: #003c7d; 
            border-color: #002a5b; 
        }

        .btn-secondary {
            background-color: #6c757d; 
            border-color: #5a6268; 
            border-radius: 8px; 
        }

        .btn-secondary:hover {
            background-color: #5a6268; 
            border-color: #4e555b; 
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
    <div class="sidebar">
        <?php include '../partials/sidebar.php'; ?>
    </div>

    <div class="main-content">
        <div class="form-container">
            <h1>Registrar Nova Pessoa</h1>
            <form id="multiStepForm" action="../controllers/register.php" method="POST" enctype="multipart/form-data">
                <div class="step active">
                    <h4>Informações Gerais</h4>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary next-btn">Próximo</button>
                    </div>
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
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary prev-btn">Voltar</button>
                        <button type="button" class="btn btn-primary next-btn">Próximo</button>
                    </div>
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
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary prev-btn">Voltar</button>
                        <button type="button" class="btn btn-primary next-btn">Próximo</button>
                    </div>
                </div>

                <div class="step">
                    <h4>Foto</h4>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto:</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary prev-btn">Voltar</button>
                        <button type="button" class="btn btn-primary next-btn">Próximo</button>
                    </div>
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
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary prev-btn">Voltar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </form>
            <div class="alert alert-danger d-none" id="errorAlert">Por favor, preencha todos os campos obrigatórios.</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('multiStepForm');
            const steps = Array.from(document.querySelectorAll('.step'));
            const nextButtons = document.querySelectorAll('.next-btn');
            const prevButtons = document.querySelectorAll('.prev-btn');
            const errorAlert = document.getElementById('errorAlert');
            let currentStep = 0;

            function showStep(stepIndex) {
                steps.forEach((step, index) => {
                    step.classList.toggle('active', index === stepIndex);
                });
            }

            function validateStep(stepIndex) {
                const step = steps[stepIndex];
                const requiredFields = step.querySelectorAll('[required]');
                let valid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        valid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                return valid;
            }

            nextButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (validateStep(currentStep)) {
                        errorAlert.classList.add('d-none');
                        currentStep++;
                        if (currentStep >= steps.length) {
                            currentStep = steps.length - 1; 
                        }
                        showStep(currentStep);
                    } else {
                        errorAlert.classList.remove('d-none');
                    }
                });
            });

            prevButtons.forEach(button => {
                button.addEventListener('click', () => {
                    currentStep--;
                    if (currentStep < 0) {
                        currentStep = 0; 
                    }
                    showStep(currentStep);
                });
            });

            showStep(currentStep); 
        });
    </script>
</body>
</html>
