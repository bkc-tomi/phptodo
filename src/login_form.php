<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" type="text/css" href="style/basic.css">
    <link rel="stylesheet" type="text/css" href="style/form.css">
</head>
<body>
    <div class="container">
        <div class="inner-container">
            <h1>ログイン</h1>
            <hr />
            <form method="POST" action="login.php">
                <div>
                    <label for="username">ユーザーネーム:</label>
                    <input type="text" id="username" name="username" />
                </div>
                <div>
                    <label for="password">パスワード:</label>
                    <input type="password" id="password" name="password" />
                </div>
                <input type="submit" value="ログイン" />
            </form>
            <a href="register_form.php">登録</a>

        </div>
    </div>
</body>
</html>