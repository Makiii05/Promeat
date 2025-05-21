<?PHP
include("conn.php");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
        body{
            background: #dde1e7
        }
        li::marker{
            color: #212529;
        }
        .profile-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            box-shadow: -5px -5px 9px rgba(255,255,255,0.45), 5px 5px 9px rgba(94,104,121,0.3);
        }
</style>
    <body>
    <form action="Account/PHP_account.php" method="post">
        <div class="container" style="width: 500px;">
            <div class="row my-5">
                <div class="list-group">
                    <div class="list-group-item profile-contaier">
                        <div class="col py-3">
                                <label for="user" class="form-label">Username:</label>
                                <div class="mb-2 input-group">
                                    <input required name="txtloginuser" type="text" id="user" class="form-control"/>
                                </div>

                                <label for="pass" class="form-label">Password:</label>
                                <div class="mb-2 input-group">
                                    <input required name="txtloginpass" type="password" id="pass" class="form-control"/>
                                </div>
                                <?PHP
                                if(isset($_GET["incorrect"])){
                                    echo "<small class='text-danger'>Incorrect Username or Password.</small>";
                                }
                                ?>
                        </div>
                    </div>
                    <div class="text-center list-group-item">
                        <div class="my-2 text-center">
                            <button type="submit" class="btn btn-secondary">Log In</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>