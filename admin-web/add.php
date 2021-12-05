<html>

<body>
    <style>
        <?php include './add.css'; ?>
    </style>
    <main>
        <div class='header'>
            <h1>Add Product</h1>
            <h3 class='ip'>IP: <?php echo $_SERVER["SERVER_ADDR"] ?></h3>
        </div>
        <?php if (isset($_POST["name"], $_POST["price"], $_POST["quantity"])) {
            $ch = curl_init();

            $name = $_POST["name"];
            $price = $_POST["price"];
            $quantity = $_POST["quantity"];

            $url = "http://flaskadmin-app:5000/add?name=" . $name . "&price=" . $price . "&quantity=" . $quantity;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            $response = curl_exec($ch);
            print "curl response is:" . $response;

            // close the connection, release resources used
            curl_close($ch);

            // do anything you want with your response
            var_dump($response);
            echo "<script type='text/javascript'>alert('Done');</script>";
            // echo '<META http-equiv="refresh" content="0;URL="/">';
            echo '<script>window.location.href = "index.php";</script>';
        } ?>
        <div class='content'>
            <form id="myForm" action="add.php" method="POST" class="form">
                <input type="text" name="name" placeholder="Product Name">
                <input type="number" min="0.00" name="price" max="10000.00" step="0.01" placeholder="Product Price" />
                <input type="number" name="quantity" placeholder="Product Quantity">
                <button class="addBtn" type="submit">Add Product</button>
            </form>
        </div>
    </main>
</body>

</html>