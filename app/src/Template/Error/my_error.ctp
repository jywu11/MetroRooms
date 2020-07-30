<h1>Seems there's something wrong with the property you required</h1>
<?php
    echo $this->Html->link(
        'Back to home page',
        ['controller'=> 'Properties', 'action' => 'index'],
        ['class' => 'button']
    );
?>
