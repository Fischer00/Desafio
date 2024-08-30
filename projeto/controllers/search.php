<?php
require_once '../config/config.php';

// Função para evitar erros com valores nulos
function safeHtmlspecialchars($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

if (!$conn) {
    die("Falha na conexão com o banco de dados.");
}

$pessoas = [];
$hasSearchParams = !empty($_GET['nome']) || !empty($_GET['documento']) || !empty($_GET['endereco']) || !empty($_GET['contato']);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $hasSearchParams) {
    $nome = $_GET['nome'] ?? '';
    $documento = $_GET['documento'] ?? '';
    $endereco = $_GET['endereco'] ?? '';
    $contato = $_GET['contato'] ?? '';

    $sql = "SELECT p.id, p.nome, p.foto
            FROM pessoa p
            LEFT JOIN documento d ON p.id = d.id_pessoa
            LEFT JOIN endereco e ON p.id = e.id_pessoa
            LEFT JOIN contato c ON p.id = c.id_pessoa
            WHERE 1=1";

    $params = [];
    $types = "";

    if (!empty($nome)) {
        $sql .= " AND (p.nome LIKE ? OR p.nome LIKE ?)";
        $params[] = "$nome"; 
        $params[] = "$nome %"; 
        $types .= "ss";
    }

    if (!empty($documento)) {
        $sql .= " AND d.valor LIKE ?";
        $params[] = "%$documento%";
        $types .= "s";
    }
    if (!empty($endereco)) {
        $sql .= " AND (e.rua LIKE ? OR e.cidade LIKE ? OR e.bairro LIKE ?)";
        $params[] = "%$endereco%";
        $params[] = "%$endereco%";
        $params[] = "%$endereco%";
        $types .= "sss";
    }
    if (!empty($contato)) {
        $sql .= " AND c.valor LIKE ?";
        $params[] = "%$contato%";
        $types .= "s";
    }

    $stmt = $conn->prepare($sql);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $pessoas = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($pessoas as &$pessoa) {
        $id_pessoa = $pessoa['id'];

        $sql_documentos = "SELECT * FROM documento WHERE id_pessoa = ?";
        $stmt_documentos = $conn->prepare($sql_documentos);
        $stmt_documentos->bind_param("i", $id_pessoa);
        $stmt_documentos->execute();
        $result_documentos = $stmt_documentos->get_result();
        $pessoa['documentos'] = $result_documentos->fetch_all(MYSQLI_ASSOC);

        $sql_enderecos = "SELECT * FROM endereco WHERE id_pessoa = ?";
        $stmt_enderecos = $conn->prepare($sql_enderecos);
        $stmt_enderecos->bind_param("i", $id_pessoa);
        $stmt_enderecos->execute();
        $result_enderecos = $stmt_enderecos->get_result();
        $pessoa['enderecos'] = $result_enderecos->fetch_all(MYSQLI_ASSOC);

        $sql_contatos = "SELECT * FROM contato WHERE id_pessoa = ?";
        $stmt_contatos = $conn->prepare($sql_contatos);
        $stmt_contatos->bind_param("i", $id_pessoa);
        $stmt_contatos->execute();
        $result_contatos = $stmt_contatos->get_result();
        $pessoa['contatos'] = $result_contatos->fetch_all(MYSQLI_ASSOC);
    }
}

if (isset($_GET['delete_id'])) {
    $id_pessoa = $_GET['delete_id'];
    $conn->query("DELETE FROM contato WHERE id_pessoa = $id_pessoa");
    $conn->query("DELETE FROM endereco WHERE id_pessoa = $id_pessoa");
    $conn->query("DELETE FROM documento WHERE id_pessoa = $id_pessoa");
    $conn->query("DELETE FROM pessoa WHERE id = $id_pessoa");
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Pessoa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #e0e0e0;
            margin: 0;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
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
    <script>
        $(document).ready(function() {
            $("#searchForm").on("submit", function(event) {
                event.preventDefault(); // Evita o envio normal do formulário

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
        });
    </script>
</head>
<body>
    
    <div id="resultContainer" class="mt-4">
        <?php if ($hasSearchParams && !empty($pessoas)): ?>
            <div class="card bg-dark text-light mb-4">
                <div class="card-header">
                    <h4 class="mb-0">Resultados da Pesquisa</h4>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($pessoas as $pessoa): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <img src="../assets/<?= safeHtmlspecialchars($pessoa['foto']) ?>" alt="Foto" class="img-thumbnail" style="width: 50px; height: 50px;">
                            <div>
                                <h5 class="mb-1"><?= safeHtmlspecialchars($pessoa['nome']) ?></h5>
                                <div class="text-muted">
                                    <?php if (!empty($pessoa['documentos'])): ?>
                                        <p class="mb-1">Documentos:
                                            <ul>
                                                <?php foreach ($pessoa['documentos'] as $doc): ?>
                                                    <li><?= safeHtmlspecialchars($doc['valor']) ?> (<?= safeHtmlspecialchars($doc['tipo']) ?>)</li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </p>
                                    <?php endif; ?>
                                    <?php if (!empty($pessoa['enderecos'])): ?>
                                        <p class="mb-1">Endereços:
                                            <ul>
                                                <?php foreach ($pessoa['enderecos'] as $end): ?>
                                                    <li><?= safeHtmlspecialchars($end['rua']) ?>, <?= safeHtmlspecialchars($end['bairro']) ?>, <?= safeHtmlspecialchars($end['cidade']) ?> - <?= safeHtmlspecialchars($end['estado']) ?>, <?= safeHtmlspecialchars($end['cep']) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </p>
                                    <?php endif; ?>
                                    <?php if (!empty($pessoa['contatos'])): ?>
                                        <p class="mb-1">Contatos:
                                            <ul>
                                                <?php foreach ($pessoa['contatos'] as $cont): ?>
                                                    <li><?= safeHtmlspecialchars($cont['valor']) ?> (<?= safeHtmlspecialchars($cont['tipo']) ?>)</li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div>
                                <a href="../controllers/edit.php?id=<?= safeHtmlspecialchars($pessoa['id']) ?>" class="btn btn-primary btn-sm mr-2">Editar</a>
                                <a href="?delete_id=<?= safeHtmlspecialchars($pessoa['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif ($hasSearchParams): ?>
            <div class="alert alert-info">Nenhum resultado encontrado.</div>
        <?php endif; ?>
    </div>
    
</body>
</html>
