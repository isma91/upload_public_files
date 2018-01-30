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
            <h1>Welcome back <?php echo $this->firstname; ?> <?php echo $this->lastname; ?> !!</h1>
        </div>
    </div>
    <div class="row failed">
        <?php if ($this->error !== null) { echo $this->error; } ?>
    </div>
    <div class="row success">
        <?php if ($this->success !== null) { echo $this->success; } ?>
    </div>
    <div class="container">
        <form id="loginForm" action="/logout" method="POST" class="row">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" >
            <div class="row center">
                <button class="btn waves-effect waves-red" type="submit">Logout</button>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="row">
            <form id="createFolderForm" action="/createFolder" method="POST" class="col s12">
                <div class="row">
                    <h4 class="center">You can create a folder here</h4>
                    <div class="input-field">
                        <i class="material-icons prefix">folder</i>
                        <input id="folder" name="folder" type="text" >
                        <label for="folder">Folder Name</label>
                    </div>
                </div>
                <div class="row input-field">
                    <select name="target" id="target">
                        <option value="1">Option 1</option>
                    </select>
                    <label for="target">Materialize Select</label>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
