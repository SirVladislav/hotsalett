<!doctype html>
<html>
<head>
    <title>Test Task </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center ">
    <form class="m-5 p-2 p-3 border border-info rounded" id="loginform" style="width: 300px;">
        <div class="alert alert-warning" style="display: none;" id="alerts">
            A simple warning alert—check it out!
        </div>
        <div class="col-md">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="col-md">
            <label class="form-label">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname">
        </div>
        <div class="col-md">
            <label class="form-label">Email</label>
<!--            add type = email to set html validation-->
            <input type="text" class="form-control" id="email" name="email">
        </div>
        <div class="col-md">
            <label  class="form-label">Password</label>
            <input type="text" class="form-control" id="password" name="password">
        </div>
        <div class="col-md">
            <label class="form-label">Repeat Password</label>
            <input type="text" class="form-control" id="rpassword" name="rpassword">
        </div>
        <br>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Create Account</button>
        </div>
    </form>
    <div class="alert alert-success m-5" id="loginmsg" style="display: none;">
        You are successfully registered!
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#loginform').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'requestController.php',
                data: $(this).serializeArray(),
                success: function (response) {
                    let res = JSON.parse(response);
                    if (res.success) {
                        $('#loginmsg').show();
                        $('#loginform').hide();
                    } else {
                        let errors = '';
                        res.msg.forEach(function (el) {
                            errors += el + '<br>';
                        })
                        $('#alerts').html(errors);
                        $('#alerts').show();
                    }
                }
            });
        });
    });
</script>
</body>
</html>