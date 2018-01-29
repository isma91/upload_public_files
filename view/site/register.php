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
            <h2>Please full in the form to create an account</h2>
        </div>
    </div>
    <div class="container">
        <form id="registerForm" action="/register" method="POST" class="row">
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="firstname" name="firstname" type="text">
                    <label for="firstname">Firstname</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="lastname" name="lastname" type="text">
                    <label for="lastname">Lastname</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">face</i>
                    <input id="username" name="username" type="text">
                    <label for="username">Username</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">email</i>
                    <input id="email" name="email" type="email">
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">vpn_key</i>
                    <i class="material-icons right" id="displayUserPass">visibility</i>
                    <input id="pass" name="password" type="password">
                    <label for="pass">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">vpn_key</i>
                    <i class="material-icons right" id="displayUserPass2">visibility</i>
                    <input id="pass2" name="password2" type="password">
                    <label for="pass2">Rewrite your Password</label>
                </div>
            </div>
            <div class="row center">
                <button class="btn waves-effect waves-light" id="register" type="submit">Register</button>
            </div>
            <div class="row">
                <a href="/login" class="right">Already have an account ?</a>
                <a href="/forgotPass" class="left">Forgot your password ?</a>
            </div>
        </form>
    </div>
</body>
</html>
