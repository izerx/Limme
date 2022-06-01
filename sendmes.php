<?php
require 'include/rb_db.php';

if(!empty($_POST['message'])){
    $chat_db =  R::dispense($_SESSION['logged_user']->ch);
    $chat_db->who = $_SESSION['logged_user']->id;
    $chat_db->message = $_POST['message'];
    $chat_db->data = date("G:i");
    R::store($chat_db);
}

?>

<?php
if(!empty($_POST['message'])){
    $user = R::load('users', $_SESSION['logged_user']->id);
    $user_favorite = explode('!', $user->favorite);
    if(!in_array($_POST['fav_user'], $user_favorite)){
        $user->favorite .= $_POST['fav_user'] . '!';
        R::store($user);
    }
}
?>

