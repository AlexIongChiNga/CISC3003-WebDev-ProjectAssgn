<?php
session_start();
include("function.php");
include("connection.php");
$user_data = check_login($con);

// Pagination setup
$limit = 16; // Number of products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page or default to 1
$offset = ($page - 1) * $limit; // Calculate the offset for the query

// Fetch products for the current page
$query = "SELECT product_id, name, price, image, rating FROM products LIMIT $limit OFFSET $offset";
$result = $con->query($query);

// Get total number of products for pagination
$total_query = "SELECT COUNT(*) AS total FROM products";
$total_result = $con->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shop</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
  </head>
  <body>
    <div class="container">
        <?php include "include/navbar.html"; ?>
    </div>

    <div class="small-container">
      <div class="row row-2">
        <h2>All Products</h2>
      </div>
      <div class="row">
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<div class="col-4">';
              echo '<a href="productDetails.php?product_id=' . $row['product_id'] . '">';
              echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" />';
              echo '<h4>' . $row['name'] . '</h4>';
              echo '<p>$' . $row['price'] . '</p>';
              echo '</a>';
              echo '</div>';
          }
        } else {
          echo '<p>No products available.</p>';
        }
        ?>
      </div>

      <div class="page-btn">
      <?php
        if ($page > 1) {
            echo '<a href="shop.php?page=' . ($page - 1) . '"><span>&#8592;</span></a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<a href="shop.php?page=' . $i . '"><span>' . $i . '</span></a>';
        }
        if ($page < $total_pages) {
            echo '<a href="shop.php?page=' . ($page + 1) . '"><span>&#8594;</span></a>';
        }
        ?>
      </div>
    </div>

    <?php include "include/footer.html"; ?>

    <script>
      var MenuItems = document.getElementById("MenuItems");

      MenuItems.style.maxHeight = "0px";

      function menutoogle() {
        if (MenuItems.style.maxHeight == "0px") {
          MenuItems.style.maxHeight = "200px";
        } else {
          MenuItems.style.maxHeight = "0px";
        }
      }
    </script>
  </body>
</html>
