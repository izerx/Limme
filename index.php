<?php
    require 'include/rb_db.php';
?>
<?php if(!isset($_SESSION['logged_user'])){
    echo '<script type="text/javascript">'; 
    echo 'window.location.href="login.php";'; 
    echo '</script>';
}
?>

<?php $data=$_GET;?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Limme</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <script>
    function AjaxFormRequest(formMain,url) {
                jQuery.ajax({
                    url:     url,
                    type:     "POST",
                    dataType: "html",
                    data: jQuery("#"+formMain).serialize(), 
                    success: function(response) {
                    
                },
                error: function(response) {
                    
                }
             });

             $(':input','#chatForm')
 				.not(':button, :submit, :reset, :hidden')
 				.val('')
 				.removeAttr('checked')
 				.removeAttr('selected');
    }
    function show()  
    {  
        $.ajax({  
            url: "test.php",  
            cache: false,
            success: function(html){  
                $("#chatdiv").html(html);  
            }  
        });  
    }  
    setInterval('show()',1000);  
    </script>
  </head>
  <body>
    <div class="wrapper">
       <div class="right-menu">
            <div class="header">
                Li<span>mm</span>e
            </div>
            <div class="user">
                <div class="avatar">
                    <img src="<?php echo $_SESSION['logged_user']->avatar?>" alt="user" width="64px" height="64px">
                </div>
                <div class="data">
                    <div class="user-name">
                        <span>
                            <?php echo $_SESSION['logged_user']->name ?> <?php echo $_SESSION['logged_user']->surname ?>
                        </span>
                    </div>
                    <div class="user-set">
                        <a href="#settings" data-toggle="modal">Настройки</a>
                        <a href="logout.php">Выйти</a>
                    </div>
                </div>
            </div>
            <div class="user-search">
                <form action="">
                    <div class="search">
                        <input type="text" placeholder="Поиск" maxlength="50" class="search-i">
                        <button class="search-b"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="chat-list">
                <ul>
                    <?php
                        $favorite_user_array = explode('!', $_SESSION['logged_user']->favorite);
                        $tmp_pop = array_pop($favorite_user_array);
                        unset($tmp_pop);
                    ?>
                    <?php if(count($favorite_user_array) != 0):?>
                        <center><h5>Недавнее</h5></center>
                        <?php foreach($favorite_user_array as $fav_us):?>
                        <?php $fav_user = R::findOne('users', 'login = ?', array($fav_us));?>
                            <li>
                                <div class="avatar">
                                <img src="<? echo $fav_user->avatar?>" alt="avatar" width="50px" height="50px">
                                </div>
                                <div class="main">
                                    <div class="contact-name">
                                        <span><?php echo $fav_user->name?> <?php echo $fav_user->surname?></span>
                                    </div>
                                    <div class="contact-set">
                                        <form action="index.php" method="get">
                                            <input type="text" value="<?php echo $fav_user->login?>" name="userlogin" class="user-id">
                                            <input type="submit" value="Перейти к чату" name="createchat">
                                        </form>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach;?>
                    <?php endif;?>
                    <center><h5>Все пользователи</h5></center>
                    <?php $users = R::findAll( 'users' );?>
                    <?php  if(count($users) === 0): ?>
                      <center><h3>Пользователи не найдены</h3></center>
                    <?php else: ?>
                    <?php foreach($users as $user): ?>
                        <li>
                            <div class="avatar">
                            <img src="<? echo $user['avatar']?>" alt="avatar" width="50px" height="50px">
                            </div>
                            <div class="main">
                                <div class="contact-name">
                                    <span><?php echo $user['name']?> <?php echo $user['surname']?></span>
                                </div>
                                <div class="contact-set">
                                    <form action="index.php" method="get">
                                        <input type="text" value="<?php echo $user['login']?>" name="userlogin" class="user-id">
                                        <input type="submit" value="Перейти к чату" name="createchat">
                                    </form>
                                </div>
                            </div>
                        </li>
                    <?php endforeach;?>
                    <?php endif;?>

                </ul>
            </div>
            <div class="main-footer">
                <span>
                    Limme © 2018 <br>
                    Тех. поддержка <span>support@limme.space</span>
                </span>
            </div>
        </div>
        <div class="main-container">
           <?php if(isset($data['createchat'])):?>
               <?php $username = R::findOne('users', 'login = ?', array($data['userlogin']));?>
               <?php $_SESSION['logged_user']->fav_login = $username->login;?>
               <?php $_SESSION['logged_user']->now_fav = $username->login;?>
               <?php $_SESSION['logged_user']->loc_ch = $data['userlogin'];?>
               <div class="text"><h5>чат с <?php echo $username->name;?> <?php echo $username->surname;?></h5></div>
            <?php else:?>
               <div class="text"><h5> </h5></div>
            <?php endif;?>
            <div class="chat">
                <div class="chat-text" id="chatdiv">

                  <?php if(isset($data['createchat'])):?>
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
                </div>
                <div class="chat-send">
                    <form action="" method="post" name="chatForm" id="chatForm">
                        <div class="mesarea">
                            <textarea name="message" id="message" rows="3" required></textarea>
<!--
                            <div class="chat-send-set">
                                <i class="glyphicon glyphicon-paperclip"></i>
                                <i>🐼</i>
                            </div>
-->
                            <input type="text" name="fav_user" value="<?php echo $_SESSION['logged_user']->fav_login?>" style="display: none;">
                        </div>
                        <div class="text-menu">
                            <button type="button" class="send-mes" onclick="AjaxFormRequest('chatForm', 'sendmes.php')"><i class="fa fa-share"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
    <div id="settings" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Заголовок модального окна -->
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <center><h4 class="modal-title">Настройки</h4></center>
          </div>
          <!-- Основное содержимое модального окна -->
          <form action="index.php" method="post" class="settings">
              <div class="modal-body">
                    <center><h5>Основные</h5></center>
                    <input type="text" value="<?php echo $_SESSION['logged_user']->name?>" name="set_name">
                    <input type="text" value="<?php echo $_SESSION['logged_user']->surname?>" name="set_surname">
                    <input type="email" value="<?php echo $_SESSION['logged_user']->email?>" name="set_email">
                    <hr>
                    <center><h5>Смена пароля</h5></center>
                    <input type="password" placeholder="Старый пароль" name="set_oldpass">
                    <input type="password" placeholder="Новый пароль" name="set_newpass">
                    <input type="password" placeholder="Подтвердите пароль" name="set_conf_newpass">
                    <hr>
                    <center>
                        <button class="btn btn-danger">Удалить аккаунт</button>
                    </center>
              </div>
              <!-- Футер модального окна -->
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <input type="submit" name="set" class="btn btn-success" value="Сохранить изменения">
              </div>
          </form>
        </div>
      </div>
    </div>  
      
       
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>