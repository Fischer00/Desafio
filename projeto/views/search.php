<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Pessoa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #9d00db;
            color: #e0e0e0;
            margin: 0;
        }
        
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        .container {
            background-color: #2b3a4e;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }
        h1 {
            color: #ffffff;
        }
        .btn-primary {
            background-color: #004d99;
            border-color: #003c7d;
        }
        .btn-primary:hover {
            background-color: #003c7d;
            border-color: #002a5b;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchForm").on("submit", function(event) {
                event.preventDefault(); 

                $.ajax({
                    url: '../controllers/search.php',
                    type: 'GET',
                    data: $(this).serialize(), // Serializa o formulário
                    success: function(response) {
                        $("#resultContainer").html(response); // Atualiza o conteúdo da página com o resultado
                    },
                    error: function() {
                        $("#resultContainer").html('<div class="alert alert-danger">Ocorreu um erro ao buscar os dados.</div>');
                    }
                });
            });

            // Limpa o resultado quando o formulário é resetado
            $("#searchForm").on("reset", function() {
                $("#resultContainer").empty();
            });
        });
    </script>
</head>
<body>
    <div class="sidebar">
    <?php include '../partials/sidebar.php'; ?>
    </div>
    <div class="main-content">
        <div class="container mt-4">
            <h1>Pesquisar Pessoa</h1>
            <form id="searchForm" method="GET" action="" class="mb-4">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input type="text" name="nome" class="form-control" placeholder="Nome">
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="documento" class="form-control" placeholder="Documento">
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="endereco" class="form-control" placeholder="Endereço">
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="contato" class="form-control" placeholder="Contato">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
                <button type="reset" class="btn btn-secondary">Limpar</button>
            </form>

            <div id="resultContainer"></div>
        </div>
    </div>
</body>
</html>
