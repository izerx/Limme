<?php
    require 'include/rb_db.php';
?>
<?php $data = $_POST;?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Limme | Авторизация</title>
    
    <link rel="stylesheet" href="css/log.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
   
  </head>
  <body>
    <div class="wrapper">
       <div class="footer">
           Limme © 2018 <br>
           Тех. поддержка <span>support@limme.space</span>
       </div>
       <div class="block-info">
          <div class="main">
               <div class="about">
                   <h2 class="title">Добро пожаловать в Limme</h2>
                   <p class="discription">Limme - это простой, красивый и невероятно мощный мессенджер,<br> с расширенными возможностями передавать информацию другим людям.</p>
                   <a href="#" class="btn">Узнать больше</a>
               </div>
               <div class="news">
                   <h2 class="title">Последние обновления</h2>
                   <h4>Limme - скоро...</h4>
                   <p>Limme проходит этап разработки, официальное начало открытого тестирования намечено на 9 января 2018 года.</p>
                   <span>03.01.2018</span>
               </div>
           </div>
       </div>
       <div class="block-auth">
          <div class="main">
               <div class="logo">
                   Li<span style="color: #5CB85C;">mm</span>e
               </div>
               <div class="form-auth">
                    <form action="login.php" method="post">
                        <h2>Войти</h2>
                        <input type="text" placeholder="Логин" name="login" value="<?$data['login']?>">
                        <input type="password" placeholder="Пароль" name="password">
                        <input type="submit" class="btn" value="Войти" name="log" style="border: none;">
                        <p>Забыли пароль? <a href="#">Востановить</a></p>
                        <p>Нет аккаунта? <a href="register.php">Создать пользователя</a></p>
                        <hr>
                        <p>Мы в соц. сетях</p>
                        <p class="networks">
                            <a href="#"><i class="fa fa-vk"></i></a>
                            <a href="#"><i class="fa fa-instagram "></i></a>
                        </p>
                        <?php
                            if(isset($data['log'])){
                                $errors = array();
                                $user = R::findOne('users', 'login = ?', array($data['login']));
                                if($user){
                                    if(md5($data['password'])==$user->password){
                                        $_SESSION['logged_user'] = $user;
                                        echo '<script type="text/javascript">'; 
                                        echo 'window.location.href="index.php";'; 
                                        echo '</script>';
                                    }
                                    else{
                                        $errors[] = "Неверный пароль";
                                    }
                                }
                                else{
                                    $errors[] = "Пользователь не найден";
                                }
                                if(!empty($errors)){
                                    echo '<center><div style="color:red;">'.array_shift($errors).'</div></center>';
                                }
                            }
                        ?>
                    </form>
                </div>
           </div>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
  </body>
</html>