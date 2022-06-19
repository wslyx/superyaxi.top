<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <meta charset="UTF-8">
    <title>学生信息管理</title>
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>
        // Js函数
        function doDel(id) {
            if (confirm('确认删除?')) {
                window.location = 'action.php?action=del&id=' + id;
            }
        }
        function doAlter(id) {
            window.location= 'edit.php?id=' + id;
        }
        // jquery函数
        $(document).ready(function(){
            $("#query").click(function(){
                alert("Text: " + $("th").text());
            });
        });
    </script>
</head>

<body>
    <center>
        <?php
        include("menu.php");
        ?>
        <h3>浏览学生信息</h3>
        <table>
            <tr>
                <th style="color: yellow;">ID</th>
                <th style="color: yellow;">姓名</th>
                <th style="color: yellow;">性别</th>
                <th style="color: yellow;">年龄</th>
                <th style="color: yellow;">班级</th>
                <th style="color: yellow;">操作</th>
            </tr>
            <?php
            //  1. 链接数据库
            $mysql_conf = array(
                'host'    => '127.0.0.1:3306',
                'db'      => 'test',
                'db_user' => 'root',
                'db_pwd'  => 'LIYAXI8077',
            );

            try {
                $pdo = new PDO("mysql:host=" . $mysql_conf['host'] . ";dbname=" . $mysql_conf['db'], $mysql_conf['db_user'], $mysql_conf['db_pwd']); //创建一个pdo对象
            } catch (PDOException $e) {
                die('connection failed' . $e->getMessage());
            }
            //2.执行sql
            $sql_select = "select * from stu";
            //3.data 解析
            foreach ($pdo->query($sql_select) as $row) {
                echo "<tr>";
                echo "<th>{$row['id']} </th>";
                echo "<th>{$row['name']}</th>";
                echo "<th>{$row['sex']} </th>";
                echo "<th>{$row['age']} </th>";
                echo "<th>{$row['classid']}</th>";
                echo "<th class='Operater'>
                      <button onclick='doAlter({$row['id']})'>修改</button>
                      <button onclick='doDel({$row['id']})'>删除</button>
                      </th>";
                echo "</tr>";
            }
            ?>
        </table>
        <button id="query">查询文本</button>
    </center>
</body>
</html>