<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="" />
    <title>Upload Public Files</title>
    <?php foreach ($this->css as $css) {
        echo $css . "\n";
    } foreach ($this->js as $js) {
        echo $js . "\n";
    } ?>
</head>
<body>
    <div class="container">
        <div class="row center">
            <h1>Welcome to Upload Public Files !!</h1>
            <h2>Please log in to begin</h2>
        </div>
    </div>
    <div class="row failed">
        <?php if ($this->error !== null) { echo $this->error; } ?>
    </div>
    <div class="row success">
        <?php if ($this->success !== null) { echo $this->success; } ?>
    </div>
    <div class="container">
        <form id="loginForm" action="/login" method="POST" class="row">
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">face</i>
                    <input id="username" name="username" type="text" value="<?php echo $this->usernameEmail ?>">
                    <label for="username">Username</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">vpn_key</i>
                    <i class="material-icons right" id="displayUserPass">visibility</i>
                    <input id="password" name="password" type="password" value="<?php echo $this->password ?>">
                    <label for="password">Mot de passe</label>
                </div>
            </div>
            <div class="row center">
                <button class="btn waves-effect waves-light" id="login" type="submit">Login</button>
            </div>
            <div class="row">
                <a href="/register" class="right">Don't have an account ?</a>
                <a href="/forgotPass" class="left">Forgot your password ?</a>
            </div>
        </form>
    </div>
</body>
</html>
