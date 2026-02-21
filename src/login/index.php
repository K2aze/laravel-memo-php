<!DOCTYPE html>
<html lang="ja">
    <?php
    session_start();
    require "../common/auth.php";
    include_once "../common/header.php";
    if (isLogin()) {
      header("Location: ../memo/");
      exit();
    }
    echo getHeader("ログイン");
    ?>
    <body>
      <main class="auth">
        <div class="main">

          <div class="image-container">
            <img src="../public/images/animal_stand_zou.png" class="image" alt="logo"/>
          </div>

          <form method="post" action="./action/login.php" class="form">

            <h1 class="title">SimpleMemo</h1>

            <?php if (isset($_SESSION["errors"])) {
              echo '<p role="alert" class="validation-error">';
              foreach ($_SESSION["errors"] as $error) {
                echo "<span class='error'>{$error}</span>";
              }
              echo "</p>";
              unset($_SESSION["errors"]);
            } ?>


            <div class="field">
              <label class="label" for="email">メールアドレス</label>
              <input type="text" id="email" name="user_email" class="input" placeholder="メールアドレス" autocomplete="off" />
            </div>


            <div class="field">
              <label class="label" for="password">パスワード</label>
              <input type="password" id="password" name="user_password" class="input" placeholder="パスワード" autocomplete="off" />
            </div>

            <button type="submit" class="btn btn-submit">
                ログイン
            </button>

          </form>

          <p class="anchor">
            <span>
              アカウントをお持ちではありませんか？
            </span>
            <a href="../user/" class="text-success">アカウントを作成</a>
          </p>

        </div>
      </main>
    </body>
</html>
