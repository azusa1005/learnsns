<?php
  // ここにDBに登録する処理を記述する

if(!empty($_POST)){
$nickname = htmlspecialchars($_POST['nickname']);
$comment = htmlspecialchars($_POST['comment']);

// １．データベースに接続する
$dsn = 'mysql:dbname=online_bbs;host=localhost';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);
$dbh->query('SET NAMES utf8');

// ２．SQL文を実行する
$sql = 'INSERT INTO `posts`( `nickname`, `comment`,`created`) VALUES (?,?,?)';

$data=array($nickname,$comment, date("Y-m-d H:i:s"));
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

}

// ３．データベースを切断する
$dbh = null;

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>
</head>
<body>
    <form method="post" action="">
      <p><input type="text" name="nickname" placeholder="nickname"></p>
      <p><textarea type="text" name="comment" placeholder="comment"></textarea></p>
      <p><button type="submit" >つぶやく</button></p>
    </form>
    <!-- ここにニックネーム、つぶやいた内容、日付を表示する -->

<?php 

$dsn = 'mysql:dbname=online_bbs;host=localhost';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);
$dbh->query('SET NAMES utf8');

//データベースにつなげる処理は重いから最初に一回やって、
//最後にnullで切れば良い。
//htmlよりphpのが強い　どこで区切られていてもphpの処理がされてからhtmlが処理される

$sql = 'SELECT * FROM `posts` ORDER BY created DESC';

//DESK→最新の投稿から表示される。ASC 古いものから表示　
//どちらも書かない場合はASCになる
//created 以外にnickname とかだとアイウエオ順、年齢だと若い順とか

$stmt = $dbh->prepare($sql);
$stmt->execute();

while(1){
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if($rec == false){
        break;
    }

echo $rec['nickname'] . '<br>';
echo $rec['comment'] . '<br>';
echo $rec['created'] . '<br>';
echo '<hr>';

}

$dbh = null;

?>



</body>
</html>


