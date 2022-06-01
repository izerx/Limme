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
    
    <title>Limme | Регистрация</title>

    <link rel="stylesheet" href="css/log.css">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/font-awesome.min.css">
       
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
                    <form action="register.php" method="post">
                        <h2>Регистрация</h2>
                        <input type="text" placeholder="Имя" name="name" value="<?php echo $data['name'];?>" required>
                        <input type="text" placeholder="Фамилия" name="surname" value="<?php echo $data['surname'];?>" required>
                        <input type="text" placeholder="Логин" name="login" value="<?php echo $data['login'];?>" required>
                        <input type="email" placeholder="Email" name="email" value="<?php echo $data['email'];?>">
                        <input type="password" placeholder="Пароль" name="password" required>
                        <input type="password" placeholder="Повторите пароль" name="password_confirm" required>
                        <input type="submit" style="transition: 0.3s;" class="btn btn-success" value="Создать пользователя" name="reg">
                        <p>Есть аккаунт? <a href="login.php">Войти</a></p>
                        <?php
                                if(isset($data['reg'])){
                                    $errors = array();
                                    if(strlen($data['password'])<8){
                                        $errors[] = "Пароль должен быть не менее 8 символов!";
                                    }
                                    if($data['password'] != $data['password_confirm']){
                                        $errors[] = "Пароли не совпадают!";
                                    }
                                    if(R::count('users', "email = ?", array($data['email'])) > 0){
                                        $errors[] = "Пользователь с такой почтой уже зарегистрирован";
                                    }
                                    if(empty($errors)){
                                        $user = R::dispense('users');
                                        $user->name = $data['name'];
                                        $user->surname = $data['surname'];
                                        $user->email = $data['email'];
                                        $user->password = md5($data['password']);
                                        $user->login = $data['login'];
                                        $user->avatar = 'images/user.png';
                                        $user->favorite = '';
                                        R::store($user);
                                        $_SESSION['logged_user'] = $user;
                                        echo '<script type="text/javascript">'; 
                                        echo 'window.location.href="index.php";'; 
                                        echo '</script>';
                                    }   
                                    else
                                    {
                                        echo '<div style="color:red;">'.array_shift($errors).'</div>';
                                    }
                                }
                            ?>
                    </form>
                </div>
           </div>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap-formhelpers-phone.js"></script>
  </body>
</html>