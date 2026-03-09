<?php
include('conection.php');
session_start();
if (empty($_SESSION['username']) ||  empty($_SESSION['password'])) {
    header('location:index.php');
}
$sql = "SELECT * FROM messages 
WHERE id IN (
    SELECT MAX(id) 
    FROM messages 
    WHERE sender_id = {$_SESSION['id']} OR receiver_id = {$_SESSION['id']} 
    GROUP BY tool_id, LEAST(sender_id, receiver_id), GREATEST(sender_id, receiver_id)
)
ORDER BY sent_at DESC";
$reponce = mysqli_query($conection, $sql);
$tool='';

if (!empty($_GET['tool_id'])) {
    $tool=$_GET['tool_id'];
    $sql3 = 'select * from tools where id=' . $_GET['tool_id'];
    $reponce3 = mysqli_query($conection, $sql3);
    $detail3 = mysqli_fetch_assoc($reponce3);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="my-bootstrap.css">


    <title>Document</title>
</head>
<script src="JQuery.js"></script>
<script>
     let selectedTool= <?= isset($tool) && is_numeric($tool)? $tool  : 'null' ?> ;
     let selectedReceiver = <?= isset($detail3['owner_id']) ? $detail3['owner_id'] : 'null' ?> ;
     let currenUser= <?= $_SESSION['id'] ?> ;
                 console.log(selectedTool,selectedReceiver)
 
        function select(toolId,receiverId){
            selectedTool=toolId;
            selectedReceiver=receiverId;
            console.log(selectedTool,selectedReceiver)
            receive()
            highlightselectedcard(document.querySelector('.cart-message[data-id="' + toolId +'-' + receiverId + '"] ' ) );

        //     selectedTool=toolId;
        //     selectedReceiver=receiverId;

        // $.ajax('receive.php', {
        //     method: 'POST',
        //     data: {
        //         tool: toolId,
        //         receiver:receiverId,
        //         sender:currenUser

        //     },
        //     success: function(data) {

        //         if (data == '') {
        //             document.getElementById('content').innerHTML = 'send new message';
        //         } else {
        //             document.getElementById('content').innerHTML = data;
        //         }
        //     },
        //     error: function() {
        //         $('#content').html('<p>حدث خطأ أثناء جلب البيانات.</p>');
        //     }
        // })
    }
 




    function send() {
        const msg = document.getElementById('message').value;
        // if(!window.selectedTool || !window.selectedReceiver){
        //     alert('')
        // }
                    console.log(selectedTool,selectedReceiver)

        $.ajax({
            url: 'send.php',
            method: 'POST',
            data: {
                msg: msg,
                tool: selectedTool,
                receiver : selectedReceiver,
                sender: currenUser
            },
            success: function(data, status, xhr) {
                receive()
                document.getElementById('message').value = '';
                
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        })
    }


    function receive() {
       if (!selectedTool || !selectedReceiver){
        document.getElementById('content').innerHTML='<p>nothing negotiation</p>';
        return;
       }

        $.ajax('receive.php', {
            method: 'POST',
            data: {
                tool: selectedTool,
                receiver:selectedReceiver,
                sender: "<?= $_SESSION['id'] ?>"
            },
            success: function(data, status, xhr) {

                if (data == '') {
                    document.getElementById('content').innerHTML = 'send new message';
                } else {
                    document.getElementById('content').innerHTML = data;
                }
            },
            error: function(data) {
                $('#content').html('<p>حدث خطأ أثناء جلب البيانات.</p>');

            }
        })
    }
 
    function highlightselectedcard(cardelement){
        $('.cart-message').removeClass('active');
        cardelement.classList.add('active');
    }
    
    window.onload = function(){
        if (selectedTool && selectedReceiver){
            receive();
        }
    }

</script>

<style>
    body {
        background-color: #f0f2f5 !important;
    }

    .cart-message {
        background-color: #f9f9f9;
        border-radius: 15px;
        box-shadow: 1px 1px 6px 1px rgba(173, 174, 183, 0.39);
        padding: 10px;
        margin-bottom: 10px;
    }
    .cart-message.active{
        background-color:rgb(203, 207, 216);
        box-shadow: 1px 3px 10px rgb(184, 185, 187);
        margin-bottom: 8px;
    }
    .sender-pctr {
        border: solid 2px #fd7924;
        margin-bottom: 5px;
        height: 63px;
        width: 63px;
        padding: 2px;
        border-radius: 40px;

    }

    .sender-info {
        display: flex;
        justify-content: space-between;
    }

    .sender-name {
        font-size: large;
        font-weight: bold;
    }

    .creat_at {
        text-align: end;
    }

    .main {
        flex: 1;
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        padding-top: 3px;
        background-color: #f9f9f9;
        height: 87vh;
        box-shadow: 1px 1px 6px 1px rgba(173, 174, 183, 0.39);
        width: 99%;


    }

    .messages {
        overflow: auto;
        scrollbar-width: none;

    }

    .user_comment {
        text-align: center;
    }

    .toot-msg {
        height: 90%;
        margin: 7px;
        overflow: auto;
        scrollbar-width: none;
        padding-left: 13px;

    }

    .msg-input {
        margin: 5px;
        margin-bottom: 10px;
        height: 10%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .msg-input input {
        width: 93% !important;
        background-color: rgb(219, 219, 223);
        border: none;
        border-radius: 18px;
        height: 40px;
        padding: 0px 20px;
        margin: 0 2px;
    }

    .msg-input button {
        width: 10% !important;
        background-color: rgb(219, 219, 223);
        border: none;
        border-radius: 18px;
        height: 40px;
        padding: 0px 20px;
        margin: 0 2px;

    }

    .fw {
        font-weight: 700;
        font-size: large;
    }

    .msgcont {
        width: 100%;

    }

    .msgcont p {
        margin: 0;
        padding: 0;
    }

    .sender,
    .receiver {
        height: fit-content;
        max-width: 48%;
        display: flex;
        flex-wrap: wrap;
        border-radius: 25px;
        margin: 3px;

    }

    .sender {
        display: flex;
        justify-content: start;
        background-color: rgba(255, 201, 162, 0.88);
        padding: 0px 20px;
        width: fit-content;
        font-size: 15px;
    }

    .receiver {
        display: flex;
        justify-content: end;
        background-color: rgba(199, 201, 251, 0.88);
        padding: 0px 20px;
        width: fit-content;
        font-size: 15px;
    }

    .msgcont .receiver {
        display: flex;
        justify-self: end;
    }

    .msgcont .sender {
        display: flex;
        justify-self: start;
    }

    .msgcont .col-12 {
        padding: 0;
        margin: 1px !important;
        margin-top: 3px !important;

    }



    .date {
        width: 100% !important;
        background-color: transparent !important;
        padding: 1px !important;
        font-size: 9px !important;
    }

    .sender .date {
        text-align: end;

    }
</style>

<body>

    <div class=""><?php include('menu.php') ?></div>
    <div class="container-fluid row">
        <div class="messages col-lg-5   p-4">
            <?php
            $rows = [];
            $filtered = [];
            while ($detail = mysqli_fetch_array($reponce)) {
                $tool_id=$detail['tool_id'];
                $id1=intval($detail['sender_id']);
                $id2=intval($detail['receiver_id']);
                $u1=min($id1, $id2);
                $u2=max($id1, $id2);

                $key = $tool_id . '|' . $u1  . '|' . $u2 ; ;

                if (!isset($rows[$key])) {
                    $rows[$key] = true;
                    $filtered[] = $detail;
                }
            }
            foreach ($filtered as $item) {
                $other_id = ($_SESSION['id'] == $item['sender_id'] )? $item['receiver_id'] : $item['sender_id'] ;
                $sql1='select *from users where id ='.$other_id;
                $reponce1 = mysqli_query($conection, $sql1);
                while ($detail1 = mysqli_fetch_assoc($reponce1)) {
                    $sql2 = 'select * from tools where id=' . $item['tool_id'];
                    $reponce2 = mysqli_query($conection, $sql2);
                    $detail2 = mysqli_fetch_assoc($reponce2);
                    
            ?>
                    <div class='cart-message col-lg-12    m-6 '   data-id="<?= $item['tool_id'] ?>-<?= $other_id ?>" onclick="select(<?= $item['tool_id']?>,<?= $other_id ?>); highlightselectedcard(this) " >
                        <div class='sender-info' >
                            <div class='rating-msg'><img class='sender-pctr ' src="<?= $detail1['profile_picture'] ?>"><span class='sender-name ms-2'><?= $detail1['username'] ?></span> </div>
                            <div class="my-3 fw"><?= $detail2['title'] ?></div>
                            <div class='user_rating m-3'><?= date('Y-m-d', strtotime($item['sent_at'])) ?> </div>
                        </div>


                        <div class='user_comment'><?= $item['content'] ?> </div>



                    </div>
            <?php  }
            }
            ?>
            <div aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only"></span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class=" col-lg-7 p-4 ">
            <div class="main">
                <div class="toot-msg " id="content">

                </div>
                <div class="msg-input">
                    <input type="text" name="sendmsg" id="message" placeholder="send massege">
                    <button onclick="send()">send</button>
                </div>
            </div>
        </div>
    </div>
</body>



</html>


