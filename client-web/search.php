<html>

<body>
    <style>
        <?php include './search.css'; ?>
    </style>
    <main>
        <div class='header'>
            <h2>Client</h2>
            <div>
                <h3 class='header_right'>Hostname: <span class="header_identity"><?php echo gethostname() ?></span></h3>
                <h3 class='header_right'>IP: <span class="header_identity"><?php echo $_SERVER["SERVER_ADDR"] ?></span></h3>
            </div>
        </div>
        <div class='content'>
            <?php
            $url = "http://flask-app:5001/search?name=" . $_POST["name"];
            $url = str_replace(' ', '%20', $url);
            $data = file_get_contents($url);
            $decoded_json = json_decode($data, true);
            ?>
            <?php echo "<h2 class='result'>" . "Searched for: " . $_POST["name"] . "</h2>"; ?>
            <?php echo "<h2 class='result'>" . count($decoded_json) . " Results Found" . "</h2>"; ?>
            <a href='/index.php'><button class='backBtn'>Go Back</button></a>
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