<?php
require "../../common/auth.php";
require "../../common/database.php";

// ログインしていない場合はログイン画面へ
if (!isLogin()) {
  header("Location: ../login/");
  exit();
}

// メモIDとユーザーIDを取得
$edit_id = $_POST["edit_id"];
$user_id = getLoginUserId();

// データベース接続
$database_handler = getDatabaseConnection();

try {
  // メモ削除処理
  if (
    $statement = $database_handler->prepare(
      "DELETE FROM memos WHERE id = :edit_id AND user_id = :user_id",
    )
  ) {
    $statement->bindParam(":edit_id", $edit_id);
    $statement->bindParam(":user_id", $user_id);
    $statement->execute();
  }
} catch (Throwable $e) {
  echo $e->getMessage();
  exit();
}

// セッション上の選択中メモを削除
unset($_SESSION["select_memo"]);

// メモ投稿画面へリダイレクト
header("Location: ../../memo");
exit();
