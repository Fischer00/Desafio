<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pessoa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../partials/styles.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Editar Pessoa</h1>
        <form method="POST" action="../controllers/edit.php?id=<?php echo htmlspecialchars($pessoa['id'], ENT_QUOTES, 'UTF-8'); ?>">

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
            <?php endforeach; ?>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
