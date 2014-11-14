<form action="" method="post">
    <ul>
        <?php foreach($config as $item => $value): ?>
            <li><?php var_dump($item, $value); ?></li>
        <?php endforeach; ?>
    </ul>
</form>
