<?php
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
$_name = "";
$_password = "";
$error = "";
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = $_POST["name"];
	$password = $_POST["pass"];
	if (!empty($name) && !empty($password)) {
		if($name === 'yse' && $password === '2019'){	
			$_SESSION["name"] = $name;
			$_SESSION["login"] = true;
			header( "Location: http://localhost/yse2019_00/zaiko_ichiran.php" ) ;
		}else{
			$error = "ユーザー名かパスワードが間違っています";
		}
		$_name = test_input($name);
		$_password = test_input($password);
	} else {
		$error = "名前とパスワードを入力してください";
	}
}

//⑦名前が入力されているか判定する。入力されていた場合はif文の中に入る
// if (!empty($name) && !empty($password)) {
// 	//⑧名前に「yse」、パスワードに「2019」と設定されているか確認する。設定されていた場合はif文の中に入る
// 	if (/* ⑧の処理を書く */){
// 		//⑨SESSIONに名前を設定し、SESSIONの「login」フラグをtrueにする
// 		//⑩在庫一覧画面へ遷移する
// 		header(/* ⑩の遷移先を書く */);
// 	}else{
// 		//⑪名前もしくはパスワードが間違っていた場合は、「ユーザー名かパスワードが間違っています」という文言をメッセージを入れる変数に設定する
// 	}
// }

// //⑫SESSIONの「error2」に値が入っているか判定する。入っていた場合はif文の中に入る
// if (/* ⑫の処理を書く */) {
// 	//⑬SESSIONの「error2」の値をエラーメッセージを入れる変数に設定する。
// 	//⑭SESSIONの「error2」にnullを入れる。
// }
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<title>ログイン</title>
	<link rel="stylesheet" href="css/login.css" type="text/css" />
</head>

<body id="login">
	<div id="main">
		<h1>ログイン</h1>
		<?php
		//⑮エラーメッセージの変数に入っている値を表示する
		echo "<div id='error'>".$error."</div>";

		//⑯メッセージの変数に入っている値を表示する
		echo "<div id='msg'>".$msg."</div>";
		?>
		<form action="login.php" method="post" id="log">
			<p>
				<input type='text' name="name" size='5' placeholder="Username">
			</p>
			<p>
				<input type='password' name='pass' size='5' maxlength='20' placeholder="Password">
			</p>
			<p>
				<button type="submit" formmethod="POST" name="decision" value="1" id="button">Login</button>
			</p>
		</form>
	</div>
</body>

</html>