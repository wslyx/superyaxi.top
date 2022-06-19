<!DOCTYPE html>
<html lang="en">

<script>
   function doReturn(){
      window.location='index.php';
   }
   function doSubmit(){

   }
   function doReset(){

   }
</script>

<head>
   <meta charset="UTF-8">
   <title>学生管理系统</title>
   <link rel="stylesheet" type="text/css" href="css/add.css">
</head>

<body>
   <center>
      <h3>增加学生信息</h3>
      <form>
         <table>
            <tr>
               <th>姓名</th>
               <th>年龄</th>
               <th>性别</th>
               <th>班级</th>
            </tr>
            <tr>
               <th><input type="text" name="name"></th>
               <th><input type="text" name="age"></th>
               <th><select name="sex" size="1" style="width: 120px; text-align: center;">
                     <option value="男">男</option>
                     <option value="女">女</option>
                  </select></th>
               <th><input type="text" name="classid"></th>
            </tr>
         </table>
      </form>
      <!-- <a href="index.php" class="MyButton">返回</a> -->
      <button onclick="doReturn()">返回</button>
      <!-- <input type="submit" class="MyButton" value="添加"> -->
      <button onclick="doSubmit()">添加</button>
      <!-- <input type="reset" class="MyButton" value="重置"> -->
      <button onclick="doReset()">重置</button>
   </center>
</body>

</html>