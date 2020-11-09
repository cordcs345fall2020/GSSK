<?php include_once 'templates/header.php'; ?>

<?php 

if(!isset($_SESSION['user']) || !check_session($_SESSION['user'])){
    redirect("login");
}

$id = get_id_session($_SESSION['user']);
$friends = get_friends($id);

?>

<script>

function create_sent(data){
    var parent = document.getElementById("msg_history");
    var div1 = document.createElement("div");
    div1.classList.add("incoming_msg");
    div1.setAttribute("data-msg-id", data.id);
    var div2 = document.createElement("div");
    div2.classList.add("received_msg");
    var div3 = document.createElement("div");
    div3.classList.add("received_withd_msg");
    var p = document.createElement("p");
    var span = document.createElement("span");
    span.classList.add("time_date");
    div2.appendChild(div3);
    div3.appendChild(p);
    div3.appendChild(span);
    p.innerText = data.message;
    span.innerText = `${data.sent}`;
    div1.appendChild(div2);
    parent.appendChild(div1);
}

function create_received(data){
    var parent = document.getElementById("msg_history");
    var div1 = document.createElement("div");
    div1.classList.add("outgoing_msg");
    div1.setAttribute("data-msg-id", data.id);
    var div2 = document.createElement("div");
    div2.classList.add("sent_msg")
    var p = document.createElement("p");
    var span = document.createElement("span");
    span.classList.add("time_date")
    div2.appendChild(p);
    div2.appendChild(span);
    p.innerText = data.message;
    span.innerText = `${data.sent}`;
    div1.appendChild(div2);
    parent.appendChild(div1);
}

function get_last_id(){
    var nodes = document.querySelectorAll("[data-msg-id]");
    return nodes.length;
}

function send_message(){
    var message = document.getElementById("write_msg").value;
    var from = document.getElementById("write_from").value;
    var to = document.getElementById("write_to").value;
    
    fetch("functions/fetch/insert_message.php", {
        method: "POST",
        body: JSON.stringify({
            message,
            from,
            to
        }),
        headers: {
		    'Content-type': 'application/json'
	    }
    })
    .then(function(res){return res.json()})
    .then((data) => console.log(data))
    .catch((err) => console.log(err));
}

function get_messages(){
    var last_id = get_last_id();
    var id = <?php echo $id; ?>;
    var friend = <?php echo $_GET['chat']; ?>;

    console.log(last_id, id, friend);

    fetch("functions/fetch/get_messages.php", {
        method: "POST",
        body: JSON.stringify({
            last_id,
            id,
            friend
        }),
        headers: {
		    'Content-type': 'application/json'
	    }
    })
    .then(function(res){return res.json()})
    .then((data) => {
        console.log(data)
        if(data.length > 0){
            for(let i = 0; i <= data.length; i++){
                if(id != data[i].from){
                    create_sent(data[i]);
                } else {
                    create_received(data[i]);
                }
                var objDiv = document.getElementById("msg_history");
                objDiv.scrollTop = objDiv.scrollHeight;
            }
        }
    })
    .catch((err) => console.log("Error: " + err));
}

document.addEventListener("DOMContentLoaded", function(e){
    var objDiv = document.getElementById("msg_history");
    objDiv.scrollTop = objDiv.scrollHeight;
    document.getElementById("write_msg").addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            send_message();
            document.getElementById("write_msg").value = "";
        }
    });

    document.getElementById("msg_send_btn").addEventListener('click', function (e) {
            send_message();
            document.getElementById("write_msg").value = "";
    });   

    setInterval(() => {
        get_messages();
        console.log("Looking for messages");    
    }, 2000);
});

</script>

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
        <div class="container">
<h3 class=" text-center">Chat</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Friends</h4>
            </div>
          </div>
          <div class="inbox_chat">
            <?php if(!empty($friends)): ?>
                <?php foreach($friends as $friend): ?>
                    <?php if($friend['a'] != $id): ?>
                        <a href="?chat=<?php echo $friend['a']; ?>">
                            <div id="chat_list" class="chat_list <?php echo ((int)$_GET['chat'] === $friend['a']) ? 'active_chat' : ''; ?>">
                                <div class="chat_people">
                                    <div class="chat_ib">
                                    <!-- <p>Test, which is a new approach to have all solutions 
                                        astrology under one roof.</p> -->
                                    <?php if(!empty(get_messages($id, $friend['a']))): ?>
                                        <h5><?php echo $friend['AName']; ?> 
                                        <?php foreach(get_messages($id, $friend['a']) as $message): ?>
                                            <span class="chat_date"><?php echo date('M j', strtotime($message['sent'])); ?></span></h5>
                                            <p><?php echo $message['message']; ?></p>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <h5><?php echo $friend['AName']; ?> 
                                        <span class="chat_date">NA - NA</span></h5>
                                            <p>No messages yet. Start a conversation.</p>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php elseif($friend['b'] != $id): ?>
                        <a href="?chat=<?php echo $friend['b']; ?>">
                        <div id="chat_list" class="chat_list <?php echo ((int)$_GET['chat'] === $friend['b']) ? 'active_chat' : ''; ?>">
                            <div class="chat_people">
                                <div class="chat_ib">
                                <!-- <p>Test, which is a new approach to have all solutions 
                                    astrology under one roof.</p> -->
                                <?php if(!empty(get_messages($id, $friend['b']))): ?>
                                    <h5><?php echo $friend['BName']; ?> 
                                    <?php foreach(get_messages($id, $friend['b']) as $message): ?>
                                        <span class="chat_date"><?php echo date('M j', strtotime($message['sent'])); ?></span></h5>
                                        <p><?php echo $message['message']; ?></p>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <h5><?php echo $friend['BName']; ?> 
                                    <span class="chat_date">NA - NA</span></h5>
                                        <p>No messages yet. Start a conversation.</p>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                No friends
            <?php endif; ?>
          </div>
        </div>
        <div class="mesgs">
          <div id="msg_history" class="msg_history">
            <?php if(isset($_GET['chat'])): ?>
                <?php if(!empty(get_messages($id, $_GET['chat']))): ?>
                    <?php foreach(get_messages($id, $_GET['chat'], 100) as $messages): ?>
                        <!-- If sent from logged user -->
                        <?php if((int)$messages['from'] === $id): ?>
                            <div class="outgoing_msg" data-msg-id="<?php echo $messages['id']; ?>">
                                <div class="sent_msg">
                                    <p><?php echo $messages['message']; ?></p>
                                    <span class="time_date"> <?php echo date('g:i A', strtotime($messages['sent'])); ?> | <?php echo date('M j', strtotime($messages['sent'])); ?></span> 
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="incoming_msg" data-msg-id="<?php echo $messages['id']; ?>">
                                <div class="received_msg">
                                    <div class="received_withd_msg">
                                        <p><?php echo $messages['message']; ?></p>
                                        <span class="time_date"><?php echo date('g:i A', strtotime($messages['sent'])); ?> | <?php echo date('M j', strtotime($messages['sent'])); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    There are no messages to retrieve. Try starting a conversation.
                <?php endif; ?>
            <?php else: ?>
                Click on a user to retrive messages.
            <?php endif; ?>
          </div>
          <?php if(isset($_GET['chat'])): ?>
        <div class="type_msg">
        <div class="input_msg_write">
            <div class="input-group">
                <input type="text" class="form-control" name="write_msg" id="write_msg" placeholder="Type a message...">
                <div class="input-group-append">
                    <span class="input-group-text" id="msg_send_btn"><i class="fas fa-paper-plane"></i></span>
                </div>
            </div>
            <input type="hidden" id="write_from" value="<?php echo $id; ?>">
            <input type="hidden" id="write_to" value="<?php echo (isset($_GET['chat'])) ? $_GET['chat'] : -1; ?>">
        </div>
    </div>
    <?php endif; ?>
        </div>
        
      </div>
      
        </div>
    </div>
    
</div>    

<?php include_once 'templates/footer.php'; ?>
    

