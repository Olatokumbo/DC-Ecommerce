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
            <h1>Client</h1>
            <h3 class='ip'>IP: <?php echo $_SERVER["SERVER_ADDR"] ?></h3>
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