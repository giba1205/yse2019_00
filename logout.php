<?php
/* 
【機能】
	セッション情報を削除しログイン画面に遷移する。
*/
session_start();
unset($_SESSION['user']);
header("Location: login.php");
//THAY DOI TY
//①セッションを開始する。

//②セッションを削除する。

//③ログイン画面へ遷移する。
?>