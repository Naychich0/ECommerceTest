<?php
require_once "dbconnect.php"; // Include database connection file

// Fetch categories
try {
    $sql = "SELECT * FROM category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Handle form submission
if (isset($_POST['insertBtn'])) {
    $productName = $_POST['pname'];
    $productCategory = $_POST['category'];
    $description = $_POST['description'];
    $sellPrice = $_POST['sprice'];
    $qty = $_POST['quantity'];
    $buyPrice = $_POST['bprice'];

    $productImage = $_FILES['pimg'];
    $filePath = "productImages/" . $productImage['name'];

    //move temp file into specified directory
    try {
        if (move_uploaded_file($productImage['tmp_name'], $filePath)) {

            // id  product_name  cost  price  description  image_path  category  quantity
            $sql = "insert into products (product_name,cost,price,description,img_path,category,quantity) 
        values (?,?,?,?,?,?,?)";

            $stmt = $conn->prepare($sql);
            $flag = $stmt->execute([$productName, $buyPrice, $sellPrice, $description, $filePath, $productCategory, $qty]);

            if ($flag) {
                $productID = $conn->lastInsertId();
                $message = "Product with id $productID has been inserted";
                $_SESSION["productMessage"] = $message;
                header("Location:viewInfo.php?show=products");
                exit();
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "navigation.php"; ?>
        </div>

        <div class="row">
            <div class="col-md-10 mx-auto py-5">
                <form action="insertProduct.php" class="card p-4" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Left side -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pname" class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="pname" id="pname" required>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Choose Category</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="">Choose Category</option>
                                    <?php
                                    if (isset($categories)) {
                                        foreach ($categories as $category) {
                                            echo "<option value='$category[id]'>$category[cat_name]</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="desc" class="form-label">Description</label>
                                <textarea name="description" id="desc" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="bprice" class="form-label">Buy Price</label>
                                <input type="number" class="form-control" name="bprice" id="bprice" required>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sprice" class="form-label">Sell Price</label>
                                <input type="number" class="form-control" name="sprice" id="sprice" required>
                            </div>

                            <div class="mb-3">
                                <label for="qty" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity" id="qty" required>
                            </div>

                            <div class="mb-3">
                                <label for="pimg" class="form-label">Product Image</label>
                                <input type="file" class="form-control" name="pimg" id="pimg" required>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" name="insertBtn">Insert Product</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>