<?php if (isset($error)): ?>
    <p style="color: red">
        <?php echo htmlspecialchars($error, ENT_QUOTES); ?>
    </p>
<?php endif; ?>