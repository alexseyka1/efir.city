<?php
$this->title = 'Инструкция по использованию сервиса';
?>
<?php
    if(!empty($content) && $content != 0){
        echo $content['content'];
    }
?>