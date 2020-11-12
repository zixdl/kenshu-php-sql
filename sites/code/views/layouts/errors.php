<?php if (isset($error)): ?>
    <p style="color: red">
        <?php echo htmlspecialchars($error, ENT_QUOTES); ?>
    </p>
<?php endif; ?>

<!-- 各フォームのエラーをチェックする -->
<?php if (isset($form_errors)):
    foreach($form_errors as $error):
?>
    <p style="color: red;">
        <?php echo htmlspecialchars($error, ENT_QUOTES); ?>
    </p>
<?php endforeach; 
    endif;
?>

<?php if (!empty($_SESSION["errors"])): ?>
    <?php foreach($_SESSION["errors"] as $error):?>
        <p style="color: red;">
            <?php echo htmlspecialchars($error, ENT_QUOTES); ?>
        </p>
    <?php endforeach; ?>
    <?php unset($_SESSION["errors"]);?>
<?php endif; ?>