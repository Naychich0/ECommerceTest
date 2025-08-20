<?php
require_once "dbconnect.php";
if(!isset($_SESSION))
{
    session_start();
}

if(isset($_POST['btnAdd']))//checking wether submit button is clicked
{
    $catName = $_POST['catName'];
    $description = $_POST['description'];
    try{
        $sql = "INSERT INTO category VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql); //prevent sql injection attack
        $status = $stmt->execute([null, $catName, $description]);
        // $id = $conn->lastInsertId();
        if($status){
            $id = $conn->lastInsertId();
            $message = "Category with id $id has been inserted";
            $_SESSION["message"] = $message;
            header("Location: viewInfo.php");
            exit();
        }
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
    <title>Category Table</title>
    <!-- cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "navigation.php"; ?>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto py-5">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form">
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="catName">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" id="desc" class="form-control" placeholder="Plese write description here..."></textarea>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary rounded" name="btnAdd" type="submit">
                            Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>