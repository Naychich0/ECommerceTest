<?php
if(!isset($_SESSION))
{
    session_start();
}
require_once "dbconnect.php";
if(isset($_GET['show']) && $_GET['show'] == 'categories'){
    try{
        $sql = "SELECT * FROM category";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll();
    
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}else if(isset($_GET['show']) && $_GET['show'] == 'products'){
    try{
        $sql = "SELECT p.id, p.product_name, p.cost,p.price, p.description, p.img_path, c.cat_name 
        as category, p.id catid, p.quantity 
        FROM products p, category c 
        WHERE p.category = c.id;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll();
        // var_dump($products);
    
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Information</title>
    <!-- cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluit">
        <div class="row">
            <?php require_once "navigation.php"; ?>
        </div>
        <div class="row">
            <div class="col-md-2 mx-auto py-5">
                <?php if(isset($_SESSION['admin_login'])) {?>
                <div class="card ms-2">
                    <a href="insertCategory.php" class="btn btn-outline-primary roundted mb-2">Insert Category</a>
                    <a href="insertProduct.php" class="btn btn-outline-primary roundted mb-2">Insert Product</a>
                </div>
                <?php } ?>
            </div>
            <div class="col-md-10 mx-auto py-5">
                <?php 
                    if(isset($_SESSION["message"])){
                        echo "<p class='alert alert-success'>$_SESSION[message] </p>";
                        unset($_SESSION["message"]);
                    }
                    if(isset($_SESSION["productMessage"])){
                        echo "<p class='alert alert-success'>$_SESSION[productMessage] </p>";
                        unset($_SESSION["productMessage"]);
                    }

                ?>
                <table class="table table-striped">
                <?php 
                    if(isset($categories)){
                        foreach($categories as $category){
                            echo "<tr>
                            <td>$category[id]</td>
                            <td>$category[cat_name]</td>
                            <td>$category[description]</td>
                            </tr>";
                        }
                    }else if(isset($products)){
                        foreach($products as $product){
                            echo "<tr>
                            <td>$product[id]</td>
                            <td>$product[product_name]</td>
                            <td>$product[cost]</td>
                            <td>$product[price]</td>
                            <td>$product[description]</td>
                            <td>$product[category]</td>
                            <td>$product[quantity]</td>
                            <td>
                                <img src = $product[img_path] style=width:75px;height=75px>
                            </td>
                            <td>
                                <a class='btn btn-primary btn-sm' href=editProduct.php?val=edit>Edit</a>
                            </td>
                            <td>
                                <a class='btn btn-danger btn-sm' href=deleteProduct.php?val=del&id=$product[id]>Delete</a>
                            </td>
                            

                            </tr>";
                        }
                    }
                ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>