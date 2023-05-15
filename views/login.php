<div class="wrapper">
    <?php 
    if(!empty($params[2])){
        echo '<div class="alert alert-danger">' . $params[2] . '</div>';
    }        
    ?>
  <div id="formContent">
    <form action="<?= SITEURL .'/?page=processlogin' ?>" method="POST">
      <input type="text" id="login" class="fadeIn second" name="email" placeholder="Email Address">
      <span class="invalid-feedback"><?= $params[0]; ?></span>
      <input type="text" id="password" class="fadeIn third" name="password" placeholder="Password">
      <span class="invalid-feedback"><?= $params[1]; ?></span>
      <input type="submit" class="btn btn-primary" value="Log In">
    </form>
  </div>
</div>