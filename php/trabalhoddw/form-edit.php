<?php
require 'init.php';
// pega o ID da URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
// valida o ID
if (empty($id)) {
    echo "ID para alteração não definido";
    exit;
}
// busca os dados do produtos a ser editado
$PDO = db_connect();
$sql = "SELECT name, color, price, startdate, quantity FROM products WHERE id = :id";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetch(PDO::FETCH_ASSOC);
// se o método fetch() não retornar um array, significa que o ID não corresponde 
// a um produtos válido
if (!is_array($products)) {
    echo "Nenhum produtos encontrado";
    exit;
}
?>
<!doctype html>
<html>
    <<head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Sistema de Cadastro</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>

        <!-- Custom fonts for this template -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
        <link  rel="icon" href="img/home.ico" type="image/x-icon" />
        <!-- Custom styles for this template -->
        <link href="css/business-casual.css" rel="stylesheet">

    </head>
    <body>
        <h1><center><strong>Sistema de Cadastro</strong></center></h1>
        <div class="container">
            <h2><strong><i>Edição de Produtos</strong></i></h2>

            <form action="edit.php" method="post"><br />
                <label for="name">Nome: </label>
                <br>
                <input type="text" name="name" id="name" value="<?php echo $products['name'] ?>">
                <br><br>
                <label for="color">Cor: </label>
                <br>
                <input type="color" name="color" id="color" value="<?php echo $products['color'] ?>">
                <br><br>
                <label for="price">Preço: </label>
                <br>
                <input type="text" name="price" id="price" value="<?php echo $products['price'] ?>">
                <br><br>
                <label for="startdate">Início das vendas: </label>
                <br>
                <input type="text" name="startdate" id="startdate" placeholder="dd/mm/yyyy" 
                       value="<?php echo dateConvert($products['startdate']) ?>">
                <br><br>
                <label for="quantity">Quantidade em estoque: </label>
                <br>
                <input type="quantity" name="quantity" id="quantity" value="<?php echo $products['quantity'] ?>">
                <br><br>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="submit" value="Alterar">
            </form>
        </div>

    </body>
</html>