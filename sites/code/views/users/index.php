<ul>    
    <?php foreach ($users as $user): ?>
        <li>
            <a href="#"><?php echo htmlspecialchars($user->user_name, ENT_QUOTES); ?></a>
        </li>
    <?php endforeach; ?>
</ul>