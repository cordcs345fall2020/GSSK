<?php include_once 'templates/header.php'; ?>
<?php include_once 'functions/auth.php'; ?>
<!-- line 2?? -->

<?php 

if(isset($_SESSION['user']) && check_session($_SESSION['user'])){
    redirect("");
}

// Handle login


if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST)) {
    if(register($_POST['email'], $_POST['password'], $_POST['first_name'], $_POST['last_name'])){
        redirect("login");
    } else {
        $error = "Failed to login. Check email address and password, then try again.";
    }
}

?>

<div class="container">
    <!-- Error handling -->
    <?php if(isset($error)): ?>
    <div class="row pt-4 pb-4">
        <div class="col-sm-12 pt-4">
            <div class="alert alert-dismissible alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4 class="alert-heading">Heads up!</h4>
                <p class="mb-0"><?php echo $error; ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row pt-4 pb-4">
        <div class="col-sm-12 pb-4">
            <form action="" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">First Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="first_name" aria-describedby="emailHelp" placeholder="Enter first name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Last Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="last_name" aria-describedby="emailHelp" placeholder="Enter last name">
                </div>
                <button type="submit" class="btn btn-lg btn-info">Register</button>
            </form>
        </div>
    </div>
</div>    

<?php include_once 'templates/footer.php'; ?>
    

