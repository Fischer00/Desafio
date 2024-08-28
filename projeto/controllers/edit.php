<?php
require_once '../config/config.php';

if (!isset($_GET['id'])) {
    die("ID não fornecido.");
}

$id_pessoa = $_GET['id'];

// Recuperar dados da pessoa
$sql = "SELECT * FROM pessoa WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pessoa);
$stmt->execute();
$pessoa = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizar dados da pessoa
    $nome = $_POST['nome'];
    
    // Atualizar a pessoa
    $sql = "UPDATE pessoa SET nome = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nome, $id_pessoa);
    $stmt->execute();

    // Atualizar documentos
    if (isset($_POST['documento_id'])) {
        foreach ($_POST['documento_id'] as $index => $doc_id) {
            $tipo_doc = $_POST['documento_tipo'][$index];
            $valor_doc = $_POST['documento_valor'][$index];
            $data_criacao_doc = $_POST['documento_data_criacao'][$index];
            $data_validade_doc = $_POST['documento_data_validade'][$index];

            $sql = "UPDATE documento SET tipo = ?, valor = ?, data_criacao = ?, data_validade = ? WHERE id = ? AND id_pessoa = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssii", $tipo_doc, $valor_doc, $data_criacao_doc, $data_validade_doc, $doc_id, $id_pessoa);
            $stmt->execute();
        }
    }

    // Atualizar endereços
    if (isset($_POST['endereco_id'])) {
        foreach ($_POST['endereco_id'] as $index => $end_id) {
            $tipo_end = $_POST['endereco_tipo'][$index];
            $cep_end = $_POST['endereco_cep'][$index];
            $estado_end = $_POST['endereco_estado'][$index];
            $cidade_end = $_POST['endereco_cidade'][$index];
            $bairro_end = $_POST['endereco_bairro'][$index];
            $rua_end = $_POST['endereco_rua'][$index];

            $sql = "UPDATE endereco SET tipo = ?, cep = ?, estado = ?, cidade = ?, bairro = ?, rua = ? WHERE id = ? AND id_pessoa = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssii", $tipo_end, $cep_end, $estado_end, $cidade_end, $bairro_end, $rua_end, $end_id, $id_pessoa);
            $stmt->execute();
        }
    }

    // Atualizar contatos
    if (isset($_POST['contato_id'])) {
        foreach ($_POST['contato_id'] as $index => $cont_id) {
            $tipo_cont = $_POST['contato_tipo'][$index];
            $valor_cont = $_POST['contato_valor'][$index];

            $sql = "UPDATE contato SET tipo = ?, valor = ? WHERE id = ? AND id_pessoa = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssii", $tipo_cont, $valor_cont, $cont_id, $id_pessoa);
            $stmt->execute();
        }
    }

    // Redirecionar após atualização
    header('Location: search.php');
    exit;
}

// Consultar documentos, endereços e contatos da pessoa
$sql_documentos = "SELECT * FROM documento WHERE id_pessoa = ?";
$stmt_documentos = $conn->prepare($sql_documentos);
$stmt_documentos->bind_param("i", $id_pessoa);
$stmt_documentos->execute();
$result_documentos = $stmt_documentos->get_result();
$documentos = $result_documentos->fetch_all(MYSQLI_ASSOC);

$sql_enderecos = "SELECT * FROM endereco WHERE id_pessoa = ?";
$stmt_enderecos = $conn->prepare($sql_enderecos);
$stmt_enderecos->bind_param("i", $id_pessoa);
$stmt_enderecos->execute();
$result_enderecos = $stmt_enderecos->get_result();
$enderecos = $result_enderecos->fetch_all(MYSQLI_ASSOC);

$sql_contatos = "SELECT * FROM contato WHERE id_pessoa = ?";
$stmt_contatos = $conn->prepare($sql_contatos);
$stmt_contatos->bind_param("i", $id_pessoa);
$stmt_contatos->execute();
$result_contatos = $stmt_contatos->get_result();
$contatos = $result_contatos->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pessoa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Editar Pessoa</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?php echo htmlspecialchars($pessoa['nome'], ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <h4>Documentos</h4>
            <?php foreach ($documentos as $index => $doc): ?>
                <input type="hidden" name="documento_id[]" value="<?php echo htmlspecialchars($doc['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="form-group">
                    <label for="documento_tipo_<?php echo $index; ?>">Tipo Documento</label>
                    <input type="text" name="documento_tipo[]" id="documento_tipo_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($doc['tipo'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <label for="documento_valor_<?php echo $index; ?>">Valor Documento</label>
                    <input type="text" name="documento_valor[]" id="documento_valor_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($doc['valor'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <label for="documento_data_criacao_<?php echo $index; ?>">Data Criação</label>
                    <input type="date" name="documento_data_criacao[]" id="documento_data_criacao_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($doc['data_criacao'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <label for="documento_data_validade_<?php echo $index; ?>">Data Validade</label>
                    <input type="date" name="documento_data_validade[]" id="documento_data_validade_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($doc['data_validade'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <hr>
            <?php endforeach; ?>

            <h4>Endereços</h4>
            <?php foreach ($enderecos as $index => $end): ?>
                <input type="hidden" name="endereco_id[]" value="<?php echo htmlspecialchars($end['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="form-group">
                    <label for="endereco_tipo_<?php echo $index; ?>">Tipo Endereço</label>
                    <input type="text" name="endereco_tipo[]" id="endereco_tipo_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($end['tipo'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <label for="endereco_cep_<?php echo $index; ?>">CEP</label>
                    <input type="text" name="endereco_cep[]" id="endereco_cep_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($end['cep'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <label for="endereco_estado_<?php echo $index; ?>">Estado</label>
                    <input type="text" name="endereco_estado[]" id="endereco_estado_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($end['estado'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <label for="endereco_cidade_<?php echo $index; ?>">Cidade</label>
                    <input type="text" name="endereco_cidade[]" id="endereco_cidade_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($end['cidade'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <label for="endereco_bairro_<?php echo $index; ?>">Bairro</label>
                    <input type="text" name="endereco_bairro[]" id="endereco_bairro_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($end['bairro'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <label for="endereco_rua_<?php echo $index; ?>">Rua</label>
                    <input type="text" name="endereco_rua[]" id="endereco_rua_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($end['rua'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <hr>
            <?php endforeach; ?>

            <h4>Contatos</h4>
            <?php foreach ($contatos as $index => $cont): ?>
                <input type="hidden" name="contato_id[]" value="<?php echo htmlspecialchars($cont['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="form-group">
                    <label for="contato_tipo_<?php echo $index; ?>">Tipo Contato</label>
                    <input type="text" name="contato_tipo[]" id="contato_tipo_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($cont['tipo'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <label for="contato_valor_<?php echo $index; ?>">Valor Contato</label>
                    <input type="text" name="contato_valor[]" id="contato_valor_<?php echo $index; ?>" class="form-control" value="<?php echo htmlspecialchars($cont['valor'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <hr>
            <?php endforeach; ?>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="search.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
