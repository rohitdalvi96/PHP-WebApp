<?php
include('header.php');
?>

<?php
$host = 'localhost:3306';
$dbname = 'classicmodels';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
?>
    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        td, th {
          border: 1px solid #2c2c2c;
          text-align: left;
          padding: 8px;
        }

        tr:nth-child(even) {
          background-color: #dddddd;
        }

        .button {
          color: white;
          text-align: center;
          text-decoration: none;
          font-size: 16px;
          margin: 4px 2px;
        }

        .buttonClass {
          background-color: white;
          color: black;
          border: 2px solid #555555;
        }

        .buttonClass:hover {
          background-color: #555555;
          color: white;
        }
    </style>
<?php
echo "<table id='table1' style='border: solid 2px black;padding:2px'; width: 100%; text-align: center;>";
echo "<tr><th>Product Line</th> <th style='text-align: center;'>Description</th></tr>";
?>    

<?php

$db = "SELECT productLine, textDescription 
FROM productlines";
$output = $conn->query($db);

if ($output->num_rows > 0) {
  while($insert = $output->fetch_assoc()) {
    echo "<tr><td>" . 
        $insert["productLine"]. "</td><td>" . $insert["textDescription"]. "</td></tr>";
  }
} else {
  echo "No data found";
}
?> 
<?php echo "</table>"; ?>

<form method="post" action="
<?php 
echo $_SERVER['PHP_SELF'];?>">Enter the product line: <input type="text" name="product">
  <input class="button buttonClass" type="submit" >
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $category = $_REQUEST['product'] ?? '';  
}
?>
<!--   reference for empty() - www.w3resource.com/php/function-->
<?php
if (!empty($category)) {
    $db = "SELECT * FROM `products` WHERE productLine ='".$category."'";
    $output = $conn->query($db);

    if ($output->num_rows > 0) {
      echo "<table id='droptbl' style='border: solid 2px black; width: 100%;'>";
      echo "<tr>
      <th>Product Code</th>
      <th>Product Name</th>
      <th>Product Line</th>
      <th>Product Scale</th>
      <th>Product Vendor</th>
      <th>Product Description</th>
      <th>Quantity In Stock</th>
      <th>Buy Price</th>
      <th>MSRP</th>
      </tr>";
      while($insert = $output->fetch_assoc()) {
        echo "<tr><td>" . $insert["productCode"]. "</td><td>" . $insert["productName"]. "</td><td>" . 
		$insert["productLine"]. "</td><td>" . 
        $insert["productScale"]. "</td><td>" . 
		$insert["productVendor"]. "</td><td>" . $insert["productDescription"]. "</td><td>" . 
		$insert["quantityInStock"]. "</td><td>" .
        $insert["buyPrice"]. "</td><td>" . 
        $insert["MSRP"]. "</td>";
      }
    } 
}
?> 

<?php
echo "</table>";
?>
    
<?php
include('footer.php');
?>