<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



include '../config/config.php';


function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}


var_dump($_POST);

// Obter e sanitizar os dados do formulário
$nome = isset($_POST['nome']) ? sanitize_input($_POST['nome']) : null;
if (empty($nome)) {
    throw new Exception("O campo 'nome' é obrigatório.");
} else {
    echo "Nome recebido: " . $nome;
}
$tipo_documento = isset($_POST['tipo_documento']) ? sanitize_input($_POST['tipo_documento']) : null;
$valor_documento = isset($_POST['valor_documento']) ? sanitize_input($_POST['valor_documento']) : null;
$data_criacao = isset($_POST['data_criacao']) ? sanitize_input($_POST['data_criacao']) : null;
$data_validade = isset($_POST['data_validade']) ? sanitize_input($_POST['data_validade']) : null;

$tipo_endereco = isset($_POST['tipo_endereco']) ? sanitize_input($_POST['tipo_endereco']) : null;
$cep = isset($_POST['cep']) ? sanitize_input($_POST['cep']) : null;
$estado = isset($_POST['estado']) ? sanitize_input($_POST['estado']) : null;
$cidade = isset($_POST['cidade']) ? sanitize_input($_POST['cidade']) : null;
$bairro = isset($_POST['bairro']) ? sanitize_input($_POST['bairro']) : null;
$rua = isset($_POST['rua']) ? sanitize_input($_POST['rua']) : null;

$tipo_contato = isset($_POST['tipo_contato']) ? sanitize_input($_POST['tipo_contato']) : null;
$valor_contato = isset($_POST['valor_contato']) ? sanitize_input($_POST['valor_contato']) : null;


$conn->begin_transaction();

try {
    // Inserir um novo registro na tabela pessoa e obter o ID gerado
    $stmt = $conn->prepare("INSERT INTO pessoa (nome) VALUES (?)");
    if ($stmt) {
        $stmt->bind_param("s", $nome);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao adicionar pessoa: " . $stmt->error);
        }
        $id_pessoa = $stmt->insert_id; // Obtém o ID gerado
        $stmt->close();
    } else {
        throw new Exception("Erro ao preparar a consulta de pessoa: " . $conn->error);
    }

    // Adicionar um novo documento
    $stmt = $conn->prepare("INSERT INTO documento (id_pessoa, tipo, valor, data_criacao, data_validade) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("issss", $id_pessoa, $tipo_documento, $valor_documento, $data_criacao, $data_validade);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao adicionar documento: " . $stmt->error);
        }
        $stmt->close();
    } else {
        throw new Exception("Erro ao preparar a consulta de documento: " . $conn->error);
    }

    // Adicionar um novo endereço
    $stmt = $conn->prepare("INSERT INTO endereco (id_pessoa, tipo, cep, estado, cidade, bairro, rua) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("issssss", $id_pessoa, $tipo_endereco, $cep, $estado, $cidade, $bairro, $rua);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao adicionar endereço: " . $stmt->error);
        }
        $stmt->close();
    } else {
        throw new Exception("Erro ao preparar a consulta de endereço: " . $conn->error);
    }

    // Adicionar um novo contato
    $stmt = $conn->prepare("INSERT INTO contato (id_pessoa, tipo, valor) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("iss", $id_pessoa, $tipo_contato, $valor_contato);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao adicionar contato: " . $stmt->error);
        }
        $stmt->close();
    } else {
        throw new Exception("Erro ao preparar a consulta de contato: " . $conn->error);
    }

    
    $conn->commit();

    echo "Dados adicionados com sucesso!";

} catch (Exception $e) {
    
    $conn->rollback();
    echo "Erro: " . $e->getMessage();
}


$conn->close();
?>
