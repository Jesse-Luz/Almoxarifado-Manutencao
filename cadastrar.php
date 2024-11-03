<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" defer></script>
    <link rel="stylesheet" href="CSS/ItemCadastrado.css">
    <title>Item Cadastrado!</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-5 text-center">Item cadastrado com <span class="text-success">Sucesso!</span></h1>
            </div>
            <div class="col-12 d-flex justify-content-center pt-4">
                <div class="box shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                <?php
                    include('conexao.php');

                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        $item = $_POST['maq'];
                        $codigo = $_POST['codigo'];
                        $namePeca = $_POST['peca'];
                        $saldo = $_POST['saldo'];
                        $marca = $_POST['marca'];
                        $estqMin = $_POST['estoque'];
                        if(isset($_POST['medidas'])){
                            $medidas = $_POST['medidas'];
                            $tipoRes = $_POST['tipo'];
                        }
                
                        if($item == 'resistencia') {
                            $stmt = $conn->prepare("INSERT INTO $item(cod, nome, marca, tipo, medidas, estq_min, saldo) VALUES (?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("issssii", $codigo, $namePeca, $marca, $tipoRes, $medidas, $estqMin, $saldo);
                        } else {
                            $stmt = $conn->prepare("INSERT INTO $item(cod, nome, marca, estq_min, saldo) VALUES (?, ?, ?, ?, ?)");
                            $stmt->bind_param("issii", $codigo, $namePeca, $marca , $estqMin, $saldo);
                        }
                        
                    if($stmt->execute()){
                        echo "<script> alert('Item cadastrado com Sucesso!') </script>";
                        echo '
                                <h3 class="text-center border-bottom">Descrição do item</h3>
                                <p>Código: ' . $codigo . '</p>
                                <p>Peça: ' . $namePeca . '</p>
                                <p>Marca: ' . $marca . '</p>
                            ';
                            if($item == 'resistencia'){
                                echo '<p>Tipo Resistência: ' . $tipoRes . '</p>';
                                echo '<p>Medidas: ' . $medidas . '</p>';
                            }
                            echo '<p>Estoque Minimo: ' . $estqMin . '</p>';
                            echo '<p>Quantidade: ' . $saldo . '</p>';
                            echo "
                                <div class='btnCadastro d-flex flex-column pt-1 pb-1'>
                                    <a class='d-flex justify-content-center btn btn-warning mb-2 mt-2' href='HTML/form' . $item . '.html'>Cadastrar outro item</a>
                                    <a class='d-flex justify-content-center btn btn-info mb-2 mt-2' href='index.html'>Voltar ao início</a>
                                </div>";
                        }
                    } else {
                        echo "ERRO: " . $stmt->error;
                    }
                    $stmt-> close();
                    $conn->close();
                ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>