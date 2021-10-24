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

.button:  {
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  font-size: 16px;
  margin: 4px 2px;
}
    
.buttonClass {
    background-color: white;
    border: 2px solid #555555;
    color: black;  
}

.buttonClass:hover {
    color: white;
  background-color: #555555;
  
}
    </style>
    <?php
    echo "<table id='mainTable' style='border: solid 2px black; width: 90%; padding:2px'>";
    echo "<tr>
        <th>Office Code</th>
        <th>City</th>
        <th>Office Address</th>
        <th>Contact</th>
        <th>More Details</th>
        </tr>";
    ?>    

    <?php
    $db = "SELECT officeCode, city, addressLine1, addressLine2, phone FROM offices";
    $output = $conn->query($db);

if ($output->num_rows > 0) {
  while($insert = $output->fetch_assoc()) {
    echo '<form id="mainForm" action="" method="POST"></form>';
    echo "<tr><td>" . 
        $insert["officeCode"]. "</td><td>" . 
        $insert["city"]. "</td><td>" . 
        $insert["addressLine1"]. " ". 
        $insert["addressLine2"]. "</td> <td>" . 
        $insert["phone"]. "</td><td>" . 
        '<button type="submit" class="button buttonClass" form="mainForm" value="' . htmlspecialchars($insert["officeCode"]) .
        '" name="click">' . "Click Here</button>" . "</td></tr>";
  }
} else {  echo "No data Found";
}
?> 

<?php
echo "</table>";
?>

<?php 
   if (isset($_POST["click"]))
   {
   $db = "SELECT * FROM `employees` 
   WHERE officeCode = '".$_POST["click"]."'
   ORDER BY `jobTitle`";
   $output = $conn->query($db);

    if ($output->num_rows > 0) {
      echo "<br><h2>Employee Details:</h2><br>";
      echo "<table id='table' style='border: solid 2px black; width: 90%;'>";
      echo "<tr>
      <th>Employee Name</th>
      <th>Job Description</th>
      <th>Employee Number</th>
      <th>Email ID</th>
      </tr>";
      while($insert = $output->fetch_assoc()) {
        echo "<tr><td>" . 
        $insert["firstName"]. " ". 
        $insert["lastName"]. "</td><td>" . 
        $insert["jobTitle"]. "</td><td>" . 
        $insert["employeeNumber"]. "</td><td>" . 
        $insert["email"]. "</td>";
        echo "</tr>";
      }
        echo "</table>"; }
   }  ?> 
    
<?php
include('footer.php');
?>