<?php 
include('dbconnect.php');
$email ='';
$password = '';
$errorEmail = '';
$errorPassword = '';
$isLogin = false;

if( isset( $_POST['send'])){
  $email = $_POST['email'];
  $password = $_POST['password'];
  if ( ! $email ) {
    $errorEmail = 'To pole jest wymagane';
  } elseif ( $email && ! filter_var($email, FILTER_VALIDATE_EMAIL) ) {
    $errorEmail = 'Zły format adresu email';
  }  
  if ( ! $password ) {
    $errorPassword = 'Uzupełnij pole Hasło';
    } elseif ( $password && strlen($password) < 6) {
      $errorPassword = 'Hasło musi zawierać minimum 6 znaków';
    }
  if ( ! $errorEmail && ! $errorPassword ) {
     /* $to = 'patryk089@gmail.com';
      $subject = 'Rejestracja ze strony portfolio';
      $message = 'Rozmowa kwalifikacyjna, próba rejestracji';
      $emailSent = mail($to, $subject, $message); */
    $isLogin = true;
    }
    
}

 ?>






<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Adrian Wiśniewski</title>
    <link rel="stylesheet" href="resources/css/style.css">
  </head>
  <body>
    <div class="content">
      <header class="top">
        <div class="container">
          <div class="menu">
            <ul>
              <li><a class="" href="index.php">Start</a></li>                 
              <li><a class="" href="index.php">Portfolio</a></li>         
              <li><a class="" href="index.php">Funkcje</a></li>
              <?php if ( $isLogin == true ) { ?>
                <li><a class="" href="index.php">Wyloguj</a></li>
              <?php } ?>
           </ul>
          </div>  
        </div>
       </header>
      <div class="conten-center">   
    <div class="col-three-fourth">  <!--wyświetlanie postów-->
        <div class="news">
        <div class="one-shot">
        <?php $result = $mysqli->query("SELECT * FROM news ORDER BY id"); 
        while ($news = mysqli_fetch_array($result)) {
          echo '<h1>' . $news['title'] . '</h1>';
          echo '<img src="' . $news['image'] . '" alt="">';
          echo '<p>' . $news['content'] .  '</p>';
          echo '<a href="delete.php?id=' . $news['id'] . '">';
          echo '<div class="delete_button">Usuń </div>';
          echo '</a>';
        }
        ?>
     </div>
    </div>
    <!-- dodawanie news -->
      <?php if ( isset($_POST['add'])){
        $title = strip_tags($_POST['title']);
        $content = strip_tags( $_POST['content']);
        $image = strip_tags($_POST['image']);
        $statement = $mysqli->prepare("INSERT news (title, image, content) VALUES(?,?,?)");
        $statement->bind_param("sss", $title, $image, $content);
        $statement->execute();
        $statement->close();
        header("Location: index.php");
      }
      ?>
        <div class="new-article">
        
            <h2>Dodaj nowy artykuł</h2>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="title">
              <label>Tytuł</label>
              <input type="text" name="title" id="title">
            </div>
            <div class="content-news">
              <label>Treść artykułu</label>
              <textarea  name="content" id="content" cols="30" rows="10"></textarea>
            </div>
            <div class="img-news">
              <label>Obrazek</label>
              <input type="text" name="image" id="image">
            </div>
            <input type="submit" class="ui primary button" id="add" name="add" value="Dodaj artykuł"></input>
          </form> 
     

        </div>
      </div>    
     <!-- koniec postów -->
    
    <!--formularz logowania-->    
       <div class="col-one-fourth">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <?php if ($isLogin == false) { ?> 
                     <div class="center">
                     <div>
                     <label>Email (login)</label><br/>
                      <?php if ( $errorEmail  != null ){ ?>
                          <span class="errorfont">
                              <?php echo $errorEmail; ?>
                          </span>
                        <?php } ?>
                        
                        <input type="text" name="email" id="email" value="<?php echo $email; ?>">
                     </div><br/>


                    <div>
                      <label>Hasło</label></br>                   
                    <?php if ( $errorPassword  != null ){ ?>
                          <span class="errorfont">
                              <?php echo $errorPassword; ?>
                          </span>
                        <?php } ?>
                     <input type="text" name="password" id="password" value="<?php echo $password; ?>">
                    <!-- <?php echo $_POST['password'] ?> -->
                   </div>  
                 </div>
                 <input type="submit"  id="send" name="send" value="Loguj" />
               </form>
             
            <?php } ?>
              <div class="mine-img">
                <img src="img/foto.jpg">
              </div>

              <div class="call">
                <p>Kontakt</p>

                <i>tel: +48 512 820 870 <br>
                   email: adrian.wisniewski89@gmail.com</i>
              </div>
    </div>

    <div style="clear:both;"></div>
          
      
   <!-- konczy sie tutaj dzielenie -->

   </div></div>
    <footer class="footer">
      <div class="menu">
         <ul>
              <li><a class="" href="index.php">Logowanie</a></li>                 
              <li><a class="" href="index.php">Kontakt</a></li>         
          </ul>   
      </div>
    </footer>
  </body>
</html>
