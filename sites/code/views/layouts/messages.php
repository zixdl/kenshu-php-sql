<?php if (isset($_SESSION["message"])): ?>
    <p style="color: #294c7a;"><?php echo $_SESSION["message"]; ?></p>
    <?php unset($_SESSION["message"]); ?>
<?php endif; ?>