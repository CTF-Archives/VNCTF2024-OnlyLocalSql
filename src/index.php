<!DOCTYPE html>
<html>
<head>
    <title>数据库连接</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>数据库连接</h1>
        <form action="query.php" method="post" >
            <div class="form-group">
                <label for="db_host">数据库地址：</label>
                <input type="text" id="db_host" name="db_host" readonly value="127.0.0.1:33060" style="background-color: #f2f2f2;">
                <!-- 别想了，改这里没用的 -->
            </div>
            <div class="form-group">
                <label for="db_username">用户名：</label>
                <input type="text" id="db_username" name="db_username" required>
            </div>
            <div class="form-group">
                <label for="db_password">密码：</label>
                <input type="password" id="db_password" name="db_password" required>
            </div>
            <div class="form-group">
                <label for="db_name">数据库名：</label>
                <input type="text" id="db_name" name="db_name" required>
            </div>
            <div class="form-group">
                <input  type="submit" value="连接数据库">
            </div>
        </form>
    </div>
</body>
</html>