<?php
//1. 链接数据库
$mysql_conf = array(
  'host'    => '127.0.0.1:3306',
  'db'      => 'test',
  'db_user' => 'root',
  'db_pwd'  => 'LIYAXI8077',
);

try {
  $pdo = new PDO("mysql:host=" . $mysql_conf['host'] . ";dbname=" . $mysql_conf['db'], $mysql_conf['db_user'], $mysql_conf['db_pwd']); //创建一个pdo对象
} catch (PDOException $e) {
  //   echo 'Connection failed: ' . $e->getMessage();
  die('connection failed' . $e->getMessage());
}

//2.action 的值做对操作
switch ($_GET['action']) {
  case 'add': //add 
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $age = $_POST['age'];
    $classid = $_POST['classid'];
    $sql = "insert into stu (name, sex, age, classid) values ('{$name}', '{$sex}','{$age}','{$classid}')";
    $rw = $pdo->exec($sql);
    if ($rw > 0) {
      echo "<script>alter('添加成功');</script>";
    } else {
      echo "<script>alter('添加失败');</script>";
    }
    header('Location: index.php');
    break;

  case 'del': //get
    $id = $_GET['id'];
    $sql = "delete from stu where id={$id}";
    $rw = $pdo->exec($sql);
    if ($rw > 0) {
      echo "<script>alter('删除成功');</script>";
    } else {
      echo "<script>alter('删除失败');</script>";
    }
    header('Location: index.php');
    break;

  case 'edit': //post
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $classid = $_POST['classid'];
    $sex = $_POST['sex'];

    //  echo $id, $age, $age, $name;
    $sql = "update stu set name='{$name}', age={$age},sex='{$sex}',classid={$classid} where id={$id};";
    //  $sql = "update myapp.stu set name='jike',sex='女', age=24,classid=44 where id=17";
    print $sql;
    $rw = $pdo->exec($sql);
    if ($rw > 0) {
      echo "<script>alter('更新成功');</script>";
    } else {
      echo "<script>alter('更新失败');</script>";
    }
    header('Location: index.php');
    break;

  default:
    header('Location: index.php');
    break;
}
