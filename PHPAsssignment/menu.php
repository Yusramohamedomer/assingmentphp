<?php
$menu = [
    'home' => 'home.php',
    'patient' => 'patients.php',
    'dentist' => 'dentist.php',
    'employee' => 'employee.php',
    'logout' => 'lagout.php',
];
?>

<form style="border: 2px solid; padding: 10px; background-color: pink;">
    <ol style="display: flex; gap: 20px; list-style: none; color: white; margin: 0; padding: 0;">
        <?php foreach ($menu as $key => $value): ?>
            <li style="color: white; display: grid; place-content: center; margin: 0;">
                <a href="<?= $value ?>"><?= $key ?></a>
            </li>
        <?php endforeach ?>
    </ol>
</form>