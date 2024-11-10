<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h3>Games</h3>
        <?php
        // put your code here
        $servername = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "softball";
        
        // create connection
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        
        // check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // retrieve data
        $sql = "SELECT id, opponent, site, result FROM games";
        $result = $conn->query($sql);
        
        echo "<table border='1'>
                <tr>
                <th>ID</th>
                <th>Opponent</th>
                <th>Site</th>
                <th>Result</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['opponent'] . "</td>";
            echo "<td>" . $row['site'] . "</td>";
            echo "<td>" . $row['result'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        $conn->close();
        ?>
    </body>
</html>
