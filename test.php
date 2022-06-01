<?php require 'include/rb_db.php'; ?>

<?php if(!empty($_SESSION['logged_user']->now_fav)):?>
<?php $username = R::findOne('users', 'login = ?', array($_SESSION['logged_user']->now_fav));?>

<?php $ch = $_SESSION['logged_user']->id;?>
<?php $ch .= 'i';?>
<?php $ch .=  $username->id;?>
<?php
    $tmp = $username->id;
    $tmp .= 'i';
    $tmp .= $_SESSION['logged_user']->id;
    if(R::findAll($tmp)){
        $ch = $tmp;
    }
?>    
<?php $_SESSION['logged_user']->ch = $ch;?>            
<?php $chat = R::findAll($ch);?>
<?php foreach($chat as $chat):?>
   <?php $user = R::findOne('users', 'id = ?', array($chat->who));?>
   <?php if($chat->who != $_SESSION['logged_user']->id):?>
        <div class="row">
            <div class="message-in pull-left">
                <?php echo '<span style="font-size: 12px;">', $user->name, ' ' , $chat->data,'</span><br>', $chat->message?>
            </div>
        </div>
    <?php else:?>
        <div class="row">
            <div class="message-out pull-right">
                <?php echo '<span style="font-size: 12px;">', $user->name, ' ' , $chat->data,'</span><br>', $chat->message?>
            </div>
        </div>
   <?php endif;?>                           
<?php endforeach;?>
<?php endif;?>