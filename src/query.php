<?php
error_reporting(0);

session_start();

// mine
// $db_host = '127.0.0.1';
// $db_username = 'root';
// $db_password = '1q2w3e4r5t!@#';
// $db_name = 'mysql';

$db_host = '127.0.0.1:33060';
$db_username = $_POST["db_username"];
$db_password = $_POST["db_password"];
$db_name = $_POST["db_name"];
if(isset($db_host)){
    try {
        $dsn = "mysql:host=$db_host;dbname=$db_name";
        $pdo = new PDO($dsn, $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $_SESSION['dsn']=$dsn;
        $_SESSION['db_username']=$db_username;
        $_SESSION['db_password']=$db_password;
    } catch (Exception $e) {
       die($e->getMessage());
    }
}
if(!isset($_SESSION['dsn'])){
    die("<script>alert('请先连接数据库');window.location.href='index.php'</script>");
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>执行数据库命令</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>执行数据库命令</h1>
        <!-- flag 就在 /flag -->
        <form action="query.php" method="post">
            <div class="form-group">
                <label for="db_command">MySQL命令：</label>
                <input type="text" id="db_command" name="db_command" style="width: 500px;" required>
            </div>
            <div class="form-group">
                <button type="submit">执行命令</button>
            </div>
        </form>

        <div class="result">
           
            <?php
            if (isset($_POST['db_command'])) {
                $db_command = $_POST["db_command"];
                $dsn=$_SESSION['dsn'];
                $db_username = $_SESSION['db_username'];
                $db_password = $_SESSION['db_password'];

                try {
                    $pdo = new PDO($dsn, $db_username, $db_password,array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $pdo->prepare($db_command);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($result) {
                        echo "<h2>执行结果：</h2>";
                        echo "<table>";
                        echo "<tr>";
                        foreach (array_keys($result[0]) as $column) {
                            echo "<th>$column</th>";
                        }
                        echo "</tr>";
                        foreach ($result as $row) {
                            echo "<tr>";
                            foreach ($row as $value) {
                                echo "<td>$value</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>没有结果返回。</p>";
                    }
                } catch (Exception $e) {
                    echo "<p class='error-message'>执行错误：" . $e->getMessage() . "</p>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>