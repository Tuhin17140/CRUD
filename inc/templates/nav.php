<div style="...">
  <div class="float-left">
    <p>
    <a href="/php/CRUD/index.php?task=report">ALL students</a> |
    <a href="/php/CRUD/index.php?task=add">Add new students</a>
    <?php if(isAdmin()): ?>
     |
    <a href="/php/CRUD/index.php?task=seed">Seed</a>
  <?php endif; ?>
    </p>
  </div>


<div class="float-right">
  <?php
    if(!$_SESSION['loggedin']):
   ?>
  <a href="auth.php">Log in</a>
  <?php
else:
   ?>
  <a href="auth.php?logout=true">Log out <?php echo $_SESSION['role']; ?></a>
  <?php
endif;
   ?>
</div>
</div>
