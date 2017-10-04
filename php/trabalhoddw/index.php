<?php
require_once 'init.php';
// abre a conexão
$PDO = db_connect();
// SQL para contar o total de registros
// A biblioteca PDO possui o método rowCount(), 
// mas ele pode ser impreciso.
// É recomendável usar a função COUNT da SQL
$sql_count = "SELECT COUNT(*) AS total FROM products ORDER BY name ASC";
// SQL para selecionar os registros
$sql = "SELECT id, name, color, price, startdate, quantity "
        . "FROM products ORDER BY name ASC";
// conta o toal de registros
$stmt_count = $PDO->prepare($sql_count);
$stmt_count->execute();
$total = $stmt_count->fetchColumn();
// seleciona os registros
$stmt = $PDO->prepare($sql);
$stmt->execute();
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
        <h1><center><strong>Sistema de Cadastro</strong></center></h1><br />
        <div class="container">
            <p><h3 class="text-shadow"><a href="form-add.php"><strong><i>Adicionar Produto</strong></i></a></h3></p>
        </div>
       <div class="container"> 
        <h2>Lista de Produtos</h2>
        </div>
        <div class="container">
        <p>Total de produtos: <?php echo $total ?></p>
        </div>
        <?php if ($total > 0): ?>
            <table width="50%" border="1">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Cor</th>
                        <th>Preço</th>
                        <th>Início da venda</th>
                        <th>Quantidade em estoque</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($products = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $products['name'] ?></td>
                            <td><?php echo $products['color'] ?></td>
                            <td><?php echo $products['price'] ?> </td>
                            <td><?php echo $products['quantity'] ?> </td>
                            <td><?php echo dateConvert($products['startdate']) ?></td>
                            
                            <td>
                               <a href="form-edit.php?id=<?php echo $products['id'] ?>">Editar</a>
                                <a href="delete.php?id=<?php echo $products['id'] ?>" 
                                   onclick="return confirm('Tem certeza de que deseja remover?');">
                                    Remover
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
        <div class="container">
            <p>Nenhum produto registrado</p>
        </div>
        <?php endif; ?>
    </body>
</html>