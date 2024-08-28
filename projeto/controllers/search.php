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

// Verifica se há parâmetros de pesquisa na requisição
$hasSearchParams = !empty($_GET['nome']) || !empty($_GET['documento']) || !empty($_GET['endereco']) || !empty($_GET['contato']);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $hasSearchParams) {
    
    $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
    $documento = isset($_GET['documento']) ? $_GET['documento'] : '';
    $endereco = isset($_GET['endereco']) ? $_GET['endereco'] : '';
    $contato = isset($_GET['contato']) ? $_GET['contato'] : '';

    
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
        $params[] = "$nome"; // Busca nomes que exatamente correspondem à string fornecida
        $params[] = "$nome %"; // Busca nomes que começam com a string fornecida e são seguidos por um espaço
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

    // Preparar e executar a consulta
    $stmt = $conn->prepare($sql);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $pessoas = $result->fetch_all(MYSQLI_ASSOC);

    // Consultar os detalhes para cada pessoa encontrada
    foreach ($pessoas as &$pessoa) {
        $id_pessoa = $pessoa['id'];

        // Consultar os documentos da pessoa
        $sql_documentos = "SELECT * FROM documento WHERE id_pessoa = ?";
        $stmt_documentos = $conn->prepare($sql_documentos);
        $stmt_documentos->bind_param("i", $id_pessoa);
        $stmt_documentos->execute();
        $result_documentos = $stmt_documentos->get_result();
        $pessoa['documentos'] = $result_documentos->fetch_all(MYSQLI_ASSOC);

        // Consultar os endereços da pessoa
        $sql_enderecos = "SELECT * FROM endereco WHERE id_pessoa = ?";
        $stmt_enderecos = $conn->prepare($sql_enderecos);
        $stmt_enderecos->bind_param("i", $id_pessoa);
        $stmt_enderecos->execute();
        $result_enderecos = $stmt_enderecos->get_result();
        $pessoa['enderecos'] = $result_enderecos->fetch_all(MYSQLI_ASSOC);

        // Consultar os contatos da pessoa
        $sql_contatos = "SELECT * FROM contato WHERE id_pessoa = ?";
        $stmt_contatos = $conn->prepare($sql_contatos);
        $stmt_contatos->bind_param("i", $id_pessoa);
        $stmt_contatos->execute();
        $result_contatos = $stmt_contatos->get_result();
        $pessoa['contatos'] = $result_contatos->fetch_all(MYSQLI_ASSOC);
    }
}

// Lógica para exclusão
if (isset($_GET['delete_id'])) {
    $id_pessoa = $_GET['delete_id'];

    // Excluir registros
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
    <!-- Inclua o Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Pesquisar Pessoa</h1>
        <form method="GET" action="" class="mb-4"> 
            <div class="form-row">
                <div class="form-group col-md-3">
                    <input type="text" name="nome" class="form-control" placeholder="Nome" value="<?php echo safeHtmlspecialchars($_GET['nome'] ?? ''); ?>">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" name="documento" class="form-control" placeholder="Documento" value="<?php echo safeHtmlspecialchars($_GET['documento'] ?? ''); ?>">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" name="endereco" class="form-control" placeholder="Endereço" value="<?php echo safeHtmlspecialchars($_GET['endereco'] ?? ''); ?>">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" name="contato" class="form-control" placeholder="Contato" value="<?php echo safeHtmlspecialchars($_GET['contato'] ?? ''); ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        
        <?php if ($hasSearchParams && !empty($pessoas)): ?>
            <div class="card">
                <div class="card-header">
                    Resultados da Pesquisa
                </div>
                <div class="card-body">
                    <?php foreach ($pessoas as $pessoa): ?>
                        <h5 class="card-title">Detalhes da Pessoa ID: <?php echo safeHtmlspecialchars($pessoa['id']); ?></h5>
                        <p>Nome: <?php echo safeHtmlspecialchars($pessoa['nome']); ?></p>
                        <p>Foto: <img src="<?php echo safeHtmlspecialchars($pessoa['foto']); ?>" alt="Foto de <?php echo safeHtmlspecialchars($pessoa['nome']); ?>" class="img-thumbnail"></p>

                        <?php if (!empty($pessoa['documentos'])): ?>
                            <h6>Documentos:</h6>
                            <?php foreach ($pessoa['documentos'] as $doc): ?>
                                <p>Tipo Documento: <?php echo safeHtmlspecialchars($doc['tipo']); ?></p>
                                <p>Valor Documento: <?php echo safeHtmlspecialchars($doc['valor']); ?></p>
                                <p>Data Criação: <?php echo safeHtmlspecialchars($doc['data_criacao']); ?></p>
                                <p>Data Validade: <?php echo safeHtmlspecialchars($doc['data_validade']); ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (!empty($pessoa['enderecos'])): ?>
                            <h6>Endereços:</h6>
                            <?php foreach ($pessoa['enderecos'] as $end): ?>
                                <p>Tipo Endereço: <?php echo safeHtmlspecialchars($end['tipo']); ?></p>
                                <p>CEP: <?php echo safeHtmlspecialchars($end['cep']); ?></p>
                                <p>Estado: <?php echo safeHtmlspecialchars($end['estado']); ?></p>
                                <p>Cidade: <?php echo safeHtmlspecialchars($end['cidade']); ?></p>
                                <p>Bairro: <?php echo safeHtmlspecialchars($end['bairro']); ?></p>
                                <p>Rua: <?php echo safeHtmlspecialchars($end['rua']); ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (!empty($pessoa['contatos'])): ?>
                            <h6>Contatos:</h6>
                            <?php foreach ($pessoa['contatos'] as $cont): ?>
                                <p>Tipo Contato: <?php echo safeHtmlspecialchars($cont['tipo']); ?></p>
                                <p>Valor Contato: <?php echo safeHtmlspecialchars($cont['valor']); ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <a href="edit.php?id=<?php echo $pessoa['id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="?delete_id=<?php echo $pessoa['id']; ?>" class="btn btn-danger" onclick="return confirm('Você tem certeza que deseja excluir?')">Excluir</a>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php elseif ($hasSearchParams): ?>
            <div class="alert alert-info mt-4" role="alert">
                Nenhum resultado encontrado.
            </div>
        <?php endif; ?>
    </div>

    <
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
