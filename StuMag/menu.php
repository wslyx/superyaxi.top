<!DOCTYPE html>
<html lang="en">

<script>
    function doExplore(){
        window.location='index.php';
    }
    function doAdd(){
        window.location='add.php';
    }
</script>

<body>
    <h1>学生管理系统</h1>
    <!-- <a href="index.php"> 浏览学生</a> -->
    <button onclick="doExplore()">浏览学生</button>
    <!-- <a href="add.php"> 添加学生</a> -->
    <button onclick="doAdd()">添加学生</button>
    <hr>
</body>
</html>