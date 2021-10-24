<?php
include('header.php');
?>
<style>       
table {
  font-family: arial, sans-serif;
  border-collapse: collapse; 
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

</style>
	
    <div class="Payments">
    <?php 
        $host = 'localhost:3306';
        $dbname = 'classicmodels';
        $username = 'root';
        $password = '';

//        try and catch method for exception handling- www.w3schools.com/PHP/php_exception
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $db = $conn->prepare("SELECT * FROM payments ORDER BY paymentDate DESC LIMIT 20");
        $db->execute();
        $data = $db->fetchAll(); 

        echo "<br><table style='border: solid 2px black;'>";
        echo "<tr><th>Check Number</th><th>Payment Date</th><th>Amount</th><th>Customer Number</th></tr>";
        foreach ($data as $insert) { 
            echo "<tr><td>" .$insert['checkNumber']. "</td><td>" .$insert['paymentDate']. "</td><td>" .
            $insert['amount']. "</td><td style = 'text-align: center;'><a href='payments.php?customerNumber=" .$insert['customerNumber']. "'>" .
            $insert['customerNumber']. "</a></td></tr>"; 
        }
        echo "</table>";   
    }
catch(PDOException $err) {
  echo "No connection: " . $err->getMessage();
}$conn = null;
    ?>
    </div>
    <a id="button" href="payments.php" onclick="back">Return on payments page</a>

    <script>
function back(){
document.getElementById('button').style.display = "none";}
    </script>
<div class="Desc">
    <?php
            if(isset($_GET['customerNumber'])){
                echo "<style>.Payments{display:none}</style>";
                echo "<br><h3>CustomerID :".$_GET['customerNumber'];

            $host = 'localhost:3306';
            $dbname = 'classicmodels';
            $username = 'root';
            $password = '';
    try{
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $db = $conn->prepare("select count(p.customerNumber) No_of_payment,sum(p.amount) Total,c.creditLimit,c.phone,c.salesRepEmployeeNumber
        from payments p join customers c
        on p.customerNumber=c.customerNumber where c.customerNumber=" .$_GET['customerNumber']. "");

        $db->execute();
        $data = $db->fetchAll(); 
        echo "<table style='border: solid 2px black; width:80%;'>";
        echo "<tr><th><i>Phone</i></th><th><i>Sales Rep</i></th><th><i>Credit Limit</i></th><th><i>No Of Payments</i></th><th><i>Total Amount</i></th></tr>";
        foreach($data as $insert) { 
            echo "<tr><td>" .$insert['phone']. "</td><td>" .$insert['salesRepEmployeeNumber']. "</td><td>" 
            .$insert['creditLimit']. "</td><td>" .$insert['No_of_payment']. "</td><td>" .$insert['Total']. "</td></tr>";            
                }
        echo "</table>";
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db = $conn->prepare("SELECT checkNumber,paymentDate,amount 
        FROM payments WHERE customerNumber =" .$_GET['customerNumber']. "");
        $db->execute();
        $data = $db->fetchAll(); 

    echo "<table style='border: solid 2px black;'><br><br>";
    echo "<tr><th><i> Check Number </i></th><th><i>Payment Date</i></th><th><i>Amount</i></th></tr>";
    foreach($data as $insert) { 
        echo "<tr><td>" .$insert['checkNumber']. "</td><td>" .$insert['paymentDate']. "</td><td>" .$insert['amount']. "</td></tr>"; } echo "</table>";
            } 
    catch(PDOException $err) { echo "Connection failed: " . 
        $err->getMessage();
            }
        }
    ?>
    </div>
	
<?php
include('footer.php');
?>
