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
            <h2>Please full in the form to reset your password</h2>
        </div>
    </div>
    <div class="container">
        <form id="registerForm" action="/resetPassword" method="POST" class="row">
            <div class="row center">
                <button class="btn waves-effect waves-light" id="register" type="submit">Reset Password</button>
            </div>
            <div class="row">
                <a href="/login" class="left">Already have an account ?</a>
                <a href="/register" class="right">Don't have an account ?</a>
            </div>
        </form>
    </div>
</body>
</html>
