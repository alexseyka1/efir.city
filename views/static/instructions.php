<?php
$this->title = 'Инструкция по использованию сервиса';
?>
<div class="items big" id="items" style="height:100% !important;">
    <div class="page-content">
        <?php
        if(!empty($content) && $content != 0){
            echo $content['content'];
        }
        ?>
    </div>
</div>