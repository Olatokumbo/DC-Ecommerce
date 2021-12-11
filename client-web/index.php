<html>

<body>
    <style>
        <?php include './style.css'; ?>
    </style>

    <!-- <h1>My first PHP page</h1> -->
    <!-- $_SERVER["SERVER_ADDR"] -->
    <!-- gethostname() -->
    <main>
        <div class='header'>
            <h2>Client</h2>
            <div>
                <h3 class='header_right'>Hostname: <span class="header_identity"><?php echo gethostname() ?></span></h3>
                <h3 class='header_right'>IP: <span class="header_identity"><?php echo $_SERVER["SERVER_ADDR"] ?></span></h3>
            </div>
        </div>
        <div class='content'>
            <h2>All Products</h2>
            <?php
            $data = file_get_contents("http://flask-app:5001");
            $decoded_json = json_decode($data, true);
            ?>

            <table border='1'>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
                <?php
                foreach ($decoded_json as $product) {
                    echo "<tr>";

                    echo "<td>" . $product["id"] . "</td>";

                    echo "<td>" . $product["name"] . "</td>";

                    echo "<td>" . $product["price"] . "</td>";

                    echo "<td>" . $product["quantity"] . "</td>";

                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </main>

</body>

</html>