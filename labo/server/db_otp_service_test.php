<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <body>
        <?php
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $db = "otp_service";

            $dbconnect = mysqli_connect($hostname,$username,$password,$db);

            if ($dbconnect->connect_error) {
              die("Database connection failed: " . $dbconnect->connect_error);
            }
        ?>        

        <table border="1" align="center">
            <th colspan="4">Customer_Request</th>
            <tr>
              <td>Track_ID</td>
              <td>Content</td>
              <td>Customer_ID</td>
              <td>Status</td>
            </tr>
            <?php
                $query = mysqli_query($dbconnect, "SELECT * FROM customer_req")
                   or die (mysqli_error($dbconnect));

                while ($row = mysqli_fetch_array($query)) {
                  echo
                   "<tr>
                    <td>{$row['Track_ID']}</td>
                    <td>{$row['Content']}</td>
                    <td>{$row['Customer_ID']}</td>
                    <td>{$row['Status']}</td>
                   </tr>\n";
                }
            ?>
        </table>
        <hr>
        <table border="1" align="center">
            <th colspan="3">Courrier_Request</th>
            <tr>
              <td>Track_ID</td>
              <td>Courrier_Request</td>
              <td>Courrier_ID</td>
            </tr>
            <?php
                $query = mysqli_query($dbconnect, "SELECT * FROM courrier_req")
                   or die (mysqli_error($dbconnect));

                while ($row = mysqli_fetch_array($query)) {
                  echo
                   "<tr>
                    <td>{$row['Track_ID']}</td>
                    <td>{$row['Courrier_Request']}</td>
                    <td>{$row['Courrier_ID']}</td>
                   </tr>\n";
                }
            ?>
        </table>
    </body>
</html>
