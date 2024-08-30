<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/projeto/config/config.php');



function safeHtmlspecialchars($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

if (!$conn) {
    die("Falha na conexão com o banco de dados.");
}

$sql = "SELECT id, nome, foto
        FROM pessoa
        ORDER BY id DESC
        LIMIT 5";

$result = $conn->query($sql);

if ($result) {
    $pessoas = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $pessoas = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
        }
        
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 900px;
            margin: auto;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-message {
            font-size: 1.15em;
            margin-bottom: 30px;
            color: #555;
            text-align: center;
        }

        .list-group-item {
            background-color: #ffffff;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: box-shadow 0.3s;
        }

        .list-group-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .list-group-item-heading {
            color: #444;
            font-weight: bold;
        }

        .img-thumbnail {
            border-radius: 8px;
            margin-right: 15px;
            transition: transform 0.3s;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
        }

        .btn {
            margin-top: 10px;
            margin-right: 10px;
        }

        .btn-warning {
            background-color: #ffcc00;
            border: none;
        }

        .btn-danger {
            background-color: #e60000;
            border: none;
        }

        .alert {
            font-size: 1.1em;
            text-align: center;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 10px;
            }

            .container {
                padding: 15px;
            }

            .img-thumbnail {
                width: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/projeto/partials/sidebar.php'); ?>
    </div>
    <div class="main-content">
        <div class="container">
            <h1>Bem-vindo à Página Inicial!</h1>
            <p class="welcome-message">Aqui estão as últimas pessoas adicionadas ao banco de dados:</p>

            <?php if (!empty($pessoas)): ?>
                <div class="list-group">
                    <?php foreach ($pessoas as $pessoa): ?>
                        <div class="list-group-item d-flex align-items-center">
                            <img src="<?php echo safeHtmlspecialchars($pessoa['foto']); ?>" alt="Foto de <?php echo safeHtmlspecialchars($pessoa['nome']); ?>" class="img-thumbnail" style="width: 100px;">
                            <div class="flex-grow-1">
                                <h5 class="list-group-item-heading"><?php echo safeHtmlspecialchars($pessoa['nome']); ?></h5>
                            </div>
                            <div>
                                <a href="/projeto/controllers/edit.php?id=<?php echo $pessoa['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="?delete_id=<?= safeHtmlspecialchars($pessoa['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>

                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
            <?php else: ?>
                <div class="alert alert-info mt-4" role="alert">
                    Nenhuma pessoa encontrada.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
