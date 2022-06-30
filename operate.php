<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Crillerium Note</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="style.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Rubik', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      font-size: calc(10px + 0.33vw);
      -webkit-font-smoothing: antialiased;
      padding: 5vh 10vw;
      color: #121314;
    }
    h1 {
      font-size: 4.5em;
      font-weight: 500;
      margin-bottom: 0;
    }
    p {
      font-size: 1.6em;
      font-weight: 300;
      line-height: 1.4;
    }
    a {
      text-decoration: none;
      color: #121314;
      position: relative;
    }
    a:after {
      content: "";
      position: absolute;
      z-index: -1;
      top: 60%;
      left: -0.1em;
      right: -0.1em;
      bottom: 0;
      transition: top 200ms cubic-bezier(0, .8, .13, 1);
      background-color: rgba(79,192,141,0.5);
    }
    a:hover:after {
      top: 0%;
    }
    .comments {
    width:100%;/*自动适应父布局宽度*/
    overflow:auto;
    word-break:break-all;
    outline: none;
    }
    textarea{
      outline: none;
      resize: none;
    }
  </style>
</head>
<body>
<?php
if ($_POST['action']=='new') {
    $text = file_get_contents('server.config');
    $config = json_decode($text,true);
    echo '<p style="font-weight:500; font-size:2.2em">正在创建笔记。</p><p>';
    if($connect = mysqli_connect($config['server_url'],$config['server_user_name'],$config['server_user_password'])){
        if (mysqli_select_db($connect,$config['database_name'])) {
            $id =time();
            $name = base64_encode($_POST['name']);
            $text = base64_encode($_POST['text']);
            $sql_new = "INSERT INTO `note` (`id`, `name`, `text`) VALUES ('".$id."', '".$name."', '".$text."')";
            if (mysqli_query($connect,$sql_new)) {
                echo '笔记创建成功, <a href=viewnote.php?id='.$id.'>点击访问';
            }
            else {
                echo "笔记创建失败";
            }
        }
        else {
            echo "笔记创建失败";
        }
    }
    else {
        echo "笔记创建失败";
    }
    echo '</p>';
}
elseif ($_POST['action']=='edit') {
  echo '<p style="font-weight:500; font-size:2.2em">正在修改笔记内容。</p>';
  $text = file_get_contents('server.config');
  $config = json_decode($text,true);
  if($connect = mysqli_connect($config['server_url'],$config['server_user_name'],$config['server_user_password'])){
      if (mysqli_select_db($connect,$config['database_name'])) {
        $name = base64_encode($_POST['name']);
        $text = base64_encode($_POST['text']);
        $sql_edit = "UPDATE `note` SET `name` = '".$name."', `text` = '".$text."' WHERE `id` = ".$_POST['id'];
          if(mysqli_query($connect,$sql_edit)){
            echo '<p>修改成功<br/><br/><a href="viewnote.php?id='.$_POST['id'].'">点击访问</a><br/><a href="index.php">返回主页</a></p>';
          }
          else {
            echo '<p>修改失败,请提交issue给<a href="https://github.com/Crillerium/CloudNote">Crillerium</a></p>';
            echo 'SQL:'.$sql_edit;
          }
      }
  }
}
elseif ($_GET['action']=='deleting') {
echo '<p style="font-weight:500; font-size:2.2em">真的要删除这篇笔记吗?</p><p>在下方输入框中输入笔记的名称即可删除。<form name="deleting" action="operate.php" method="get"><input name="action" type="hidden" value="deleted"><input name="id" type="hidden" value="'.$_GET['id'].'"><input name="name" type="text" class="comments"><br/><br/><input name="submit" type="submit" value="确认删除"></form></p>';
}
elseif ($_GET['action']=='deleted') {
  echo '<p style="font-weight:500; font-size:2.2em">正在删除笔记。</p>';
  $text = file_get_contents('server.config');
  $config = json_decode($text,true);
  if($connect = mysqli_connect($config['server_url'],$config['server_user_name'],$config['server_user_password'])){
      if (mysqli_select_db($connect,$config['database_name'])) {
        $result = mysqli_query($connect,"select * from note where id ='".$_GET['id']."'");
        $row = mysqli_fetch_array($result);
        $name = base64_encode($_GET['name']);
        if ($name==$row['name']) {
          if(mysqli_query($connect,'DELETE FROM `note` WHERE `id` ='.$_GET['id'])){
            echo '<p>删除成功<br/><a href="index.php">返回主页</a></p>';
          }
          else {
            echo '<p>删除失败,请提交issue给<a href="https://github.com/Crillerium/CloudNote">Crillerium</a></p>';
          }
        }
        else {
          echo "<p>删除失败,所填内容与笔记名称不一致。</p>";
        }
      }
  }
}
elseif ($_GET['action']=='install') {
    $text = file_get_contents('server.config');
    $config = json_decode($text,true);
    echo '<p style="font-weight:500; font-size:2.2em">正在安装数据库。</p><p>';
    if($connect = mysqli_connect($config['server_url'],$config['server_user_name'],$config['server_user_password'])){
        echo "1>服务器连接成功! <br>";
        if (mysqli_select_db($connect,$config['database_name'])) {
            echo "2>数据库选择成功! <br>";
            $sql_install = 'CREATE TABLE `note` ( `id` INT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL , `text` MEDIUMTEXT NOT NULL , PRIMARY KEY (`id`))';
            if (mysqli_query($connect,$sql_install)) {
                echo "3>数据表创建成功! <br>";
            }
            else {
                echo "3>数据表创建失败! <br>";
            }
        }
        else {
            echo "2>数据库选择失败! <br>";
        }
    }
    else {
        echo "1>服务器连接失败! <br>";
    }
    echo '<br/><a href="index.php">返回主页</a></p>';
}
?>
</body>
</html>