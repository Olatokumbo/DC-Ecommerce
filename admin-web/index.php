<html>

<body>
    <style>
        <?php include './style.css'; ?>
    </style>
    <main>
        <div class='header'>
            <h2>Admin</h2>
            <div>
                <h3 class='header_right'>Hostname: <span class="header_identity"><?php echo gethostname() ?></span></h3>
                <h3 class='header_right'>IP: <span class="header_identity"><?php echo $_SERVER["SERVER_ADDR"] ?></span></h3>
            </div>
        </div>
        <div class='content'>
            <?php
            $data = file_get_contents("http://flaskadmin-app:5000");
            $decoded_json = json_decode($data, true);
            ?>
            <div class="display">
                <a href="/admin/add.php"><button class="addBtn">Add Product</button></a>
                <table border='1'>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    foreach ($decoded_json as $key => $product) {
                        echo "<tr>";

                        echo "<td>" . $key + 1 . "</td>";

                        echo "<td>" . $product["name"] . "</td>";

                        echo "<td>" . '$' . $product["price"] . "</td>";

                        echo "<td>" . $product["quantity"] . "</td>";

                        echo "<td> <a href='/admin/edit.php?id=" . $product['id'] . "' ><button>Edit</button></a> <a href='/admin/delete.php?id=" . $product['id'] . "' ><button>Delete</button></a>";

                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </main>

</body>

</html>