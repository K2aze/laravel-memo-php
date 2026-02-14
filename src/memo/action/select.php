<?php
require "../../common/auth.php";
require "../../common/database.php";

if (!isLogin()) {
  header("Location: ../login/");
  exit();
}

$id = $_GET["id"]; // クリックされたメモID（URLパラメータ）
$user_id = getLoginUserId(); // ログインユーザーID

$database_handler = getDatabaseConnection();
if (
  $statement = $database_handler->prepare(
    "SELECT id, title, content FROM memos WHERE id = :id AND user_id = :user_id",
  )
) {
  $statement->bindParam(":id", $id);
  $statement->bindParam(":user_id", $user_id);
  $statement->execute();
  $result = $statement->fetch(PDO::FETCH_ASSOC);
}

// 選択中メモをセッションに保存
$_SESSION["select_memo"] = [
  "id" => $result["id"],
  "title" => $result["title"],
  "content" => $result["content"],
];

// メモ画面へ戻す
header("Location: ../../memo/");
exit();
