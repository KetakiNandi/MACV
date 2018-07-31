<!--<?php phpinfo(); ?>-->

<?php
$servername = "db";
$username = "root";
$password = "admin";
$db = "ReachOutDB";

// Create connection
//$mysqli = new mysqli('0.0.0.0', 'root', 'admin', 'ReachOutDB', '3306');
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
    die ('Fail to connect to MySQL: ' . mysqli_connect_error());   
}
 
$sql = 'SELECT staff_id, category, senior_id, junior_id 
        FROM comment';
         
$query = mysqli_query($conn, $sql);
 
if (!$query) {
    die ('SQL Error: ' . mysqli_error($conn));
}
 
echo '<table>
        <thead>
            <tr>
                <th>STAFF ID</th>
                <th>CATEGORY</th>
                <th>SENIOR ID</th>
                <th>JUNIOR ID</th>
            </tr>
        </thead>
        <tbody>';
         
while ($row = mysqli_fetch_array($query))
{
    echo '<tr>
            <td>'.$row['staff_id'].'</td>
            <td>'.$row['category'].'</td>
            <td>'.$row['senior_id'].'</td>
            <td class="right">'.$row['junior_id'].'</td>
        </tr>';
}
echo '
    </tbody>
</table>';
 
// Should we need to run this? read section VII
mysqli_free_result($query);
 
// Should we need to run this? read section VII
mysqli_close($conn);
?>
