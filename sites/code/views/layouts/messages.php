<?php if (isset($_SESSION["message"])): ?>
    <h3 style="color: #294c7a;"><?php echo $_SESSION["message"]; ?></h2>
    <?php unset($_SESSION["message"]); ?>
<?php endif; ?>