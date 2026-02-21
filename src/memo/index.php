<!DOCTYPE html>
<html lang="ja">
    <?php
    include_once "../common/header.php";
    echo getHeader("メモ投稿");
    require "../common/database.php";

    require "../common/auth.php";
    if (!isLogin()) {
      header("Location: ../login/");
      exit();
    }

    $user_name = getLoginUserName();
    $user_id = getLoginUserId();

    $memos = [];
    $database_handler = getDatabaseConnection();
    if (
      $statement = $database_handler->prepare(
        "SELECT id, title, content, updated_at
         FROM memos
         WHERE user_id = :user_id
         ORDER BY updated_at DESC",
      )
    ) {
      $statement->bindParam(":user_id", $user_id);
      $statement->execute();

      while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
        array_push($memos, $result);
      }
    }

    $edit_id = "";
    if (isset($_SESSION["select_memo"])) {
      $edit_memo = $_SESSION["select_memo"];
      $edit_id = $edit_memo["id"] ?? "";
      $edit_title = $edit_memo["title"] ?? "";
      $edit_content = $edit_memo["content"] ?? "";
    }
    ?>
    <body>

      <main class="dashboard">

        <div class="main">

          <aside class="aside">

              <div class="header">
                <p class="greeting">
                  <?php echo $user_name; ?>さん、こんにちは。
                </p>
                <a href="./action/add.php" class="btn btn-action btn-add">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path d="M5 12h14"/><path d="M12 5v14"/>
                  </svg>
                </a>
                <a href="./action/logout.php" class="btn btn-action btn-logout">
                  <svg xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path d="m16 17 5-5-5-5"/><path d="M21 12H9"/>
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                  </svg>
                </a>
              </div>

              <h1 class="title">
                  メモリスト
              </h1>

              <div class="memos">
                <?php if (empty($memos)): ?>
                  <p class="empty">メモがありません</p>
                <?php endif; ?>

                <?php foreach ($memos as $memo): ?>
                  <a
                  href="./action/select.php?id=<?php echo $memo["id"]; ?>"
                  class="item <?php echo $edit_id == $memo["id"]
                    ? "active"
                    : ""; ?>"
                  >
                    <h5 class="title"><?php echo $memo["title"]; ?></h5>
                    <date class="date">
                      <?php echo date(
                        "Y/m/d H:i",
                        strtotime($memo["updated_at"]),
                      ); ?>
                    </date>
                    <p class="content">
                      <?php echo mb_strlen($memo["content"]) <= 100
                        ? $memo["content"]
                        : mb_substr($memo["content"], 0, 100) . "..."; ?>
                    </p>
                  </a>
                <?php endforeach; ?>
              </div>
          </aside>

          <div class="board">

            <?php if (isset($_SESSION["select_memo"])): ?>

              <form method="post" class="board-form">

                  <button type="submit" class="btn btn-action save" formaction="./action/update.php">
                    <span>Save</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/>
                      <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"/>
                      <path d="M7 3v4a1 1 0 0 0 1 1h7"/>
                    </svg>
                  </button>

                  <input
                    class="title"
                    type="text"
                    name="edit_title"
                    placeholder="タイトルを入力する..."
                    value="<?php echo $edit_title; ?>"
                  />

                  <textarea
                    class="content"
                    name="edit_content"
                    placeholder="内容を入力する..."
                  ><?php echo $edit_content; ?></textarea>

                  <button type="submit" class="btn btn-action delete" formaction="./action/delete.php">
                    <span>Delete</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <path d="M10 11v6"/>
                      <path d="M14 11v6"/>
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                      <path d="M3 6h18"/>
                      <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    </svg>
                  </button>

                  <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />

              </form>
              <?php else: ?>
                <p class="empty">
                    メモを新規作成するか選択してください。
                </p>
              <?php endif; ?>
          </div>

        </div>

      </main>
    </body>
</html>
