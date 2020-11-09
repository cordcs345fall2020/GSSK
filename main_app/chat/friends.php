<?php include_once 'templates/header.php'; ?>

<?php 

if(!isset($_SESSION['user']) || !check_session($_SESSION['user'])){
    redirect("login");
}

// User id
$id = get_id_session($_SESSION['user']);
$requests = get_requests($id);
$friends = get_friends($id);
$email = get_email_from_id($id);

// Handle request
if ($_SERVER['REQUEST_METHOD'] == "GET" && !empty($_GET)) {
    // Add friend
    if(isset($_GET['email'])){
        if($email === $_GET['email']){
            $error = "You can't add yourself as a friend.";
        } else {
            if(add_friend($id, get_id_from_email($_GET['email']))){
                redirect("friends");
            }
        }
    } else {
        $error = "Failed to add friend. Check spelling or user isn't a friend already";
    }

    // Approve request
    if(isset($_GET['approve'])){
        if(approveFriend($_GET['approve'])){
            redirect("friends");
        } else {
            $error = "Failed to accept friend. Try again";
        }
    }

    // Remove request
    if(isset($_GET['remove'])){
        if(deleteFriend($_GET['remove'])){
            redirect("friends");
        } else {
            $error = "Failed to remove friend from list.";
        }
    }
}

?>
<style>
::placeholder { /* Most modern browsers support this now. */
   color: #adafae!important;
}
</style>

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
        <div class="col-sm-12">
            <h2>Add Friend By Email</h2>
            <form method="get">
            <div class="form-group">
                <input type="email" name="email" class="form-control" style="background-color: #222!important; color: #adafae; border: 1px solid #282828;"id="exampleInputPassword1" placeholder="Add by email">
            </div>
            <button type="submit" class="btn btn-primary float-right">Add Friend</button>
            </form>
        </div>
    </div>

    <div class="row pt-4 pb-4">
        <div class="col-sm-12 pb-4">
            <h2>Friend Requests</h2>
            <ul class="list-group">
                <?php if(!empty($requests)): ?>
                    <?php foreach($requests as $request): ?>
                        <?php if($request['a'] != $id): ?>
                            <li class="list-group-item align-items-center">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <?php echo $request['AName'] . ' - ' . $request['AEmail']; ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <a href="?remove=<?php echo $request['id']; ?>" class="btn btn-danger float-right">Remove</a>
                                        <a href="?approve=<?php echo $request['id']; ?>" class="btn mr-1 btn-success float-right">Accept</a> 
                                    </div>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="list-group-item align-items-center">
                                <div class="row">
                                    <div class="col-sm-12">
                                        Sorry, there are no friend requests here.
                                    </div>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item align-items-center">
                        <div class="row">
                            <div class="col-sm-12">
                                Sorry, there are no friend requests here.
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="col-sm-12 pb-4">
            <h2>Friends</h2>
            <ul class="list-group">
                <?php if(!empty($friends)): ?>
                    <?php foreach($friends as $friend): ?>
                        <?php if($friend['a'] != $id): ?>
                            <li class="list-group-item align-items-center">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <?php echo $friend['AName'] . ' - ' . $friend['AEmail']; ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <a href="?remove=<?php echo $friend['id']; ?>" class="btn btn-danger float-right">Remove</a>
                                        <a href="<?php echo URL; ?>?chat=<?php echo $friend['a']; ?>" class="btn mr-1  btn-info float-right">Chat</a>
                                    </div>
                                </div>
                            </li>
                        <?php elseif($friend['b'] != $id): ?>
                            <li class="list-group-item align-items-center">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <?php echo $friend['BName'] . ' - ' . $friend['BEmail']; ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <a href="?remove=<?php echo $friend['id']; ?>" class="btn btn-danger float-right">Remove</a>
                                        <a href="<?php echo URL; ?>?chat=<?php echo $friend['b']; ?>" class="btn mr-1  btn-info float-right">Chat</a>
                                    </div>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item align-items-center">
                    <div class="row">
                        <div class="col-sm-12">
                            Sorry, there are no friends here.
                        </div>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>    

<?php include_once 'templates/footer.php'; ?>
    

