<html>

<body>
    <style>
        <?php include './edit.css'; ?>
    </style>
    <main>
        <div class='header'>
            <h1>Delete Product</h1>
            <h3 class='ip'>IP: <?php echo $_SERVER["SERVER_ADDR"] ?></h3>
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
        } ?>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ch = curl_init();

            $fid = $_POST["id"];
            $fname = $_POST["name"];
            $fprice = $_POST["price"];
            $fquantity = $_POST["quantity"];

            $eurl = "http://flaskadmin-app:5000/product/" . $fid . "/delete";
            curl_setopt($ch, CURLOPT_URL, $eurl);
            curl_setopt($ch, CURLOPT_POST, 1);
            $response = curl_exec($ch);
            print "curl response is:" . $response;
            echo $eurl;

            // close the connection, release resources used
            curl_close($ch);

            // do anything you want with your response
            var_dump($response);
            echo "<script type='text/javascript'>alert('Done');</script>";
            // echo '<META http-equiv="refresh" content="0;URL="/">';
            echo '<script>window.location.href = "index.php";</script>';
        }

        ?>
        <div class='content'>
            <form id="myForm" action="delete.php" method="POST" class="form">
                <input type="text" name="name" placeholder="Product Name" value="<?php echo $name; ?>" disabled />
                <input type="number" min="0.00" name="price" max="10000.00" step="0.01" placeholder="Product Price" value="<?php echo $price; ?>" disabled />
                <input type="number" name="quantity" placeholder="Product Quantity" value="<?php echo $quantity; ?>" disabled />
                <input type="number" name="id" value="<?php echo $id; ?>" hidden />
                <button class="addBtn" type="submit">Delete Product</button>
            </form>
        </div>
    </main>

</body>

</html>