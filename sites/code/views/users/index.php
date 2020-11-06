<?php
    echo '<ul>';
    foreach ($users as $user) {
        echo '<li>
        <a href="#">' . $user->user_name . '</a>
        </li>';
}
    echo '</ul>';
?>