<html>

<body>
    <style>
        <?php include './edit.css'; ?>
    </style>
    <main>
    <div class='header'>
            <h2>Edit Product</h2>
            <div>
                <h3 class='header_right'>Hostname: <span class="header_identity"><?php echo gethostname() ?></span></h3>
                <h3 class='header_right'>IP: <span class="header_identity"><?php echo $_SERVER["SERVER_ADDR"] ?></span></h3>
            </div>
        </div>
        <?php
        $id = strval(htmlspecialchars($_GET["id"]));
        $url = "http://flaskadmin-app:5000/product/" . $id . "/edit";
        $data = file_get_contents($url);
        $decoded_json = json_decode($data, true);

        $id = $decoded_json[0]["id"];
        $name = $decoded_json[0]["name"];
        $price = $decoded_json[0]["price"];
        $quantity = $decoded_json[0]["quantity"];

        ?>
        <?php if (isset($_POST["name"], $_POST["price"], $_POST["quantity"], $_POST["id"])) {
            $ch = curl_init();

            $fid = $_POST["id"];
            $fname = $_POST["name"];
            $fprice = $_POST["price"];
            $fquantity = $_POST["quantity"];

            $url = "http://flaskadmin-app:5000/product/" . $fid . "/edit" . "?name=" . $fname . "&price=" . $fprice . "&quantity=" . $fquantity;
            $url = str_replace(' ', '%20', $url);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            $response = curl_exec($ch);
            print "curl response is:" . $response;
            echo $url;

            // close the connection, release resources used
            curl_close($ch);

            // do anything you want with your response
            var_dump($response);
            echo "<script type='text/javascript'>alert('Done');</script>";
            // echo '<META http-equiv="refresh" content="0;URL="/">';
            echo '<script>window.location.href = "index.php";</script>';
        } ?>
        <div class='content'>
            <form id="myForm" action="edit.php" method="POST" class="form">
                <input type="text" name="name" placeholder="Product Name" value="<?php echo $name; ?>" />
                <input type="number" min="0.00" name="price" max="10000.00" step="0.01" placeholder="Product Price" value="<?php echo $price; ?>" />
                <input type="number" name="quantity" placeholder="Product Quantity" value="<?php echo $quantity; ?>" />
                <input type="number" name="id" value="<?php echo $id; ?>" hidden />
                <button class="addBtn" type="submit">Update Product</button>
            </form>
        </div>
    </main>

</body>

</html>