<?php
/* 
【機能】
出荷で入力された個数を表示する。出荷を実行した場合は対象の書籍の在庫数から出荷数を
引いた数でデータベースの書籍の在庫数を更新する。

【エラー一覧（エラー表示：発生条件）】
なし
*/

//①セッションを開始する
if (!isset($_SESSION)) {
	session_start();
}

function getByid($id, $con)
{
	/* 
	 * ②書籍を取得するSQLを作成する実行する。
	 * その際にWHERE句でメソッドの引数の$idに一致する書籍のみ取得する。
	 * SQLの実行結果を変数に保存する。
	 */


	$query_get_book = "SELECT * FROM books WHERE id = {$id}";
	try {
		$query_ex = $con->query($query_get_book);
		$rows_results = $query_ex->fetch(PDO::FETCH_ASSOC);
		$query_ex->execute();
	} catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
	//⑫実行した結果から1レコード取得し、returnで値を返す。
	return $rows_results;
}

function updateByid($id, $con, $total)
{
	/*
	 * ④書籍情報の在庫数を更新するSQLを実行する。
	 * 引数で受け取った$totalの値で在庫数を上書く。
	 * その際にWHERE句でメソッドの引数に$idに一致する書籍のみ取得する。
	 */
	$updateQuery_byId = "UPDATE books SET stock = {$total} WHERE id = {$id}";
	// 引数で受け取った$totalの値で在庫数を上書く。
	// その際にWHERE句でメソッドの引数に$idに一致する書籍のみ取得する。
	try {
		$query_update = $con->query($updateQuery_byId);
		$rows_update_results = $query_update->fetch(PDO::FETCH_ASSOC);
		$query_update->execute();
	} catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
	return $rows_update_results;
}

//⑤SESSIONの「login」フラグがfalseか判定する。「login」フラグがfalseの場合はif文の中に入る。
if ($_SESSION["login"] == false) {
	//⑥SESSIONの「error2」に「ログインしてください」と設定する。
	$_SESSION["error2"] = "ログインしてください";
	//⑦ログイン画面へ遷移する。
	header("Location: login.php");
}
// xem lai cho nay
//⑧データベースへ接続し、接続情報を変数に保存する

//⑨データベースで使用する文字コードを「UTF8」にする

//⑩書籍数をカウントするための変数を宣言し、値を0で初期化する

//⑪POSTの「books」から値を取得し、変数に設定する。
$db_name = "zaiko2020_yse";
$host = "localhost";
$username = "zaiko2020_yse";
$password = "2020zaiko";
$result = "";
try {
	$pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
} catch (PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}

//⑨データベースで使用する文字コードを「UTF8」にする
$set_db_uf8 = "ALTER DATABASE zaiko2020 CHARACTER SET utf8 COLLATE utf8_general_ci";

//⑩書籍数をカウントするための変数を宣言し、値を0で初期化する
$count = 0;
//⑪POSTの「books」から値を取得し、変数に設定する。
$result_books = $_POST['books'];
foreach ($result_books as $result) {
	/*
	 * ⑫POSTの「stock」について⑩の変数の値を使用して値を取り出す。

	 * 半角数字以外の文字が設定されていないかを「is_numeric」関数を使用して確認する。
	 * 半角数字以外の文字が入っていた場合はif文の中に入る。
	 */
	if (!is_numeric($_POST['stock'][$count])) {
		// ⑬SESSIONの「error」に「数値以外が入力されています」と設定する。
		$_SESSION["error"] = "数値以外が入力されています";
		// ⑭「include」を使用して「syukka.php」を呼び出す。
		include 'syukka.php';
		// ⑮「exit」関数で処理を終了する。
		exit;
	}

	//⑯「getByid」関数を呼び出し、変数に戻り値を入れる。その際引数に⑪の処理で取得した値と⑧のDBの接続情報を渡す。
	$result_books_withByID = getByid($result, $pdo);
	//⑰ ⑯で取得した書籍の情報の「stock」と、⑩の変数を元にPOSTの「stock」から値を取り出して書籍情報の「stock」から値を引いた値を変数に保存する。
	$stock_value = $_POST['stock'][$count];
	//⑱ ⑰の値が0未満か判定する。0未満の場合はif文の中に入る。
	if ($stock_value <= 0) {
		//⑲SESSIONの「error」に「出荷する個数が在庫数を超えています」と設定する。
		$_SESSION["error"] = "出荷する個数が在庫数を超えています";
		//⑳「include」を使用して「syukka.php」を呼び出す。
		include 'syukka.php';
		//㉑「exit」関数で処理を終了する。
		exit();
	}

	$stock_in_zaiko = $result_books_withByID["stock"];


	if ($stock_value > $stock_in_zaiko) {
		$_SESSION["error"] = "出荷量は在庫量を超えることはできません";
		include 'syukka.php';
		exit();
	}

	$count++;

	//㉒ ⑩で宣言した変数をインクリメントで値を1増やす。
}


///* 
// * ㉓POSTでこの画面のボタンの「add」に値が入ってるか確認する。
// * 値が入っている場合は中身に「ok」が設定されていることを確認する。
// */
//if(/* ㉓の処理を書く */){
//	//㉔書籍数をカウントするための変数を宣言し、値を0で初期化する。
//
//	//㉕POSTの「books」から値を取得し、変数に設定する。
//	foreach(/* ㉕の処理を書く */){
//		//㉖「getByid」関数を呼び出し、変数に戻り値を入れる。その際引数に㉕の処理で取得した値と⑧のDBの接続情報を渡す。
//		//㉗ ㉖で取得した書籍の情報の「stock」と、㉔の変数を元にPOSTの「stock」から値を取り出して書籍情報の「stock」から値を引いた値を変数に保存する。
//		//㉘「updateByid」関数を呼び出す。その際に引数に㉕の処理で取得した値と⑧のDBの接続情報と㉗で計算した値を渡す。
//		//㉙ ㉔で宣言した変数をインクリメントで値を1増やす。
//	}
//
//	//㉚SESSIONの「success」に「入荷が完了しました」と設定する。
//	//㉛「header」関数を使用して在庫一覧画面へ遷移する。
//}


if (isset($_POST['add'])) {
	if ($_POST['add'] === 'ok') {
		$count_update = 0;
		//㉕POSTの「books」から値を取得し、変数に設定する。
		foreach ($_POST['books'] as $book_up) {
			//㉖「getByid」関数を呼び出し、変数に戻り値を入れる。その際引数に㉕の処理で取得した値と⑧のDBの接続情報を渡す。
			$result_by_id = getByid($book_up, $pdo);
			//㉗ ㉖で取得した書籍の情報の「stock」と、㉔の変数を元にPOSTの「stock」から値を取り出し、足した値を変数に保存する。
			$stock_up = $_POST['books'][$count_update];
			$stock_zaiko = $result_by_id["stock"];
			$total_update = $stock_zaiko-$_POST['stock'][$count_update];
			///㉘「updateByid」関数を呼び出す。その際に引数に㉕の処理で取得した値と⑧のDBの接続情報と㉗で計算した値を渡す。
			updateByid($book_up["stock"]['id'], $pdo, $total_update);
			//㉙ ㉔で宣言した変数をインクリメントで値を1増やす。
			$count_update++;
		}

		//㉚SESSIONの「success」に「入荷が完了しました」と設定する。
		$_SESSION["success"] = "入荷が完了しました";
		//㉛「header」関数を使用して在庫一覧画面へ遷移する。
		header("Location: zaiko_ichiran.php");
	}
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<title>出荷確認</title>
	<link rel="stylesheet" href="css/ichiran.css" type="text/css" />
</head>

<body>
	<div id="header">
		<h1>出荷確認</h1>
	</div>
	<form action="syukka_kakunin.php" method="post" id="test">
		<div id="pagebody">
			<div id="center">
				<table>
					<thead>
						<tr>
							<th id="book_name">書籍名</th>
							<th id="stock">在庫数</th>
							<th id="stock">出荷数</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count_stock = 0;
						//㉜書籍数をカウントするための変数を宣言し、値を0で初期化する。
						$books_result = $_POST['books'];

						//㉝POSTの「books」から値を取得し、変数に設定する。
						if (isset($_POST['books'])) {
							foreach ($_POST['books'] as $book_id) {
								$result_book_byId = getByid($book_id, $pdo);

								//㉞「getByid」関数を呼び出し、変数に戻り値を入れる。その際引数に㉜の処理で取得した値と⑧のDBの接続情報を渡す。
						?>
								<tr>
									<td><?php echo	$result_book_byId["title"]/* ㉟ ㉞で取得した書籍情報からtitleを表示する。 */; ?></td>
									<td><?php echo	$result_book_byId["stock"]/* ㊱ ㉞で取得した書籍情報からstockを表示する。 */; ?></td>
									<td><?php echo	$_POST['stock'][$count_stock]/* ㊲ POSTの「stock」に設定されている値を㉜の変数を使用して呼び出す。 */; ?></td>
								</tr>
								<input type="hidden" name="books[]" value="<?php echo $result_book_byId["id"]/* ㊳ ㉝で取得した値を設定する */; ?>">
								<input type="hidden" name="stock[]" value='<?php echo $_POST['stock'][$count_stock]/* ㊴「POSTの「stock」に設定されている値を㉜の変数を使用して設定する。 */; ?>'>
						<?php
								//㊵ ㉜で宣言した変数をインクリメントで値を1増やす。
								$count_stock++;
							}
						}
						?>
					</tbody>
				</table>
				<div id="kakunin">
					<p>
						上記の書籍を出荷します。<br>
						よろしいですか？
					</p>
					<button type="submit" id="message" formmethod="POST" name="add" value="ok">はい</button>
					<button type="submit" id="message" formaction="syukka.php">いいえ</button>
				</div>
			</div>
		</div>
	</form>
	<div id="footer">
		<footer>株式会社アクロイト</footer>
	</div>
</body>

</html>