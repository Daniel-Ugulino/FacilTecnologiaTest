<?php

$host = "localhost";
$database = "testDB";
$username = "postgres";
$password = "ugulino10";
$response = [];
$connection = null;

try {
    $connection = new PDO("pgsql:host=" . $host . ";dbname=" . $database, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $mensagem) {
    echo "Connection Error" . $mensagem->getMessage();
}


try {
    $stm = $connection->prepare("
    Select 
        bc.nome as nome_banco,
        cov.verba as verba,
        ct.codigo as codigo_contrato,
        ct.data_inclusao as data_inclusao,
        ct.valor as valor,
        ct.prazo as prazo
    From
        Tb_contrato as ct
        Join Tb_convenio_servico as cns ON ct.convenio_servico = cns.codigo
        Join Tb_convenio as cov ON cns.convenio = cov.codigo
        Join Tb_banco as bc ON cov.banco = bc.codigo
    ");
    $stm->execute();
    $response = $stm->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $mensagem) {
    echo "Connection Error" . $mensagem->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .div {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .table {
            width: 1700px;
            word-wrap: break-word;
            table-layout: fixed;
            overflow: scroll;
        }

        .table th {
            background-color: #b7e4c7;
            color: #1d1d1d;
            padding: 10px;
            text-decoration: underline;
        }

        .table td {
            text-align: center;
            width: 150px;
            background-color: #d1d1d1;
            color: #252525;
            padding: 12px;
        }

        td>a {
            color: #1d1d1d;
        }

        td>a:hover {
            font-weight: bold;
        }

        td>label {
            cursor: pointer;
            text-decoration: underline;
        }

        td>label:hover {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="div">
        <table class="table">
            <thead>
                <tr class="tr">
                    <th>Nome do banco</th>
                    <th>Verba</th>
                    <th>Codigo do Contrato</th>
                    <th>Data de Inclusão</th>
                    <th>Valor</th>
                    <th>Prazo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($response as $row) {
                    echo ("
                    <tr>
                        <td>" . $row["nome_banco"] . "</td>
                        <td>" . $row["verba"] . "</td>
                        <td>" . $row["codigo_contrato"] . "</td>
                        <td>" . $row["data_inclusao"] . "</td>
                        <td>" . $row["valor"] . "</td>
                        <td>" . $row["prazo"] . "</td>
                    </tr>
                    ");
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>