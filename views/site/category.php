<?php

/* @var $this yii\web\View */

$this->title = !empty($seoPage) ? $seoPage['title'] : 'Общение в ' . $this->context->city;
?>

<nav id="efirsNav">
    <ul>
        <?php $index = 1; foreach ($allCategories as $category) { ?>
            <li data-tab="<?=!empty($category['id']) ? $category['id'] : $index;?>">
                <a>
                    <span></span>
                    <?=$category['category_name'];?>
                </a>
            </li>
        <? $index++;} ?>
        <div class="clear"></div>
    </ul>
</nav>
<div class="items" id="items">
    <div class="item">
        <div class="button" style="display: none;">
            <button>Ответить</button>
        </div>
        <div class="info">
            <div class="content">
                <div class="name">
                    &nbsp;
                    <span>&nbsp;</span>
                </div>
                <div class="text">
                    Здесь еще пусто! Напиши сообщение, будь первым!
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="answer">
    <button id="bottomButtonWrite">Написать сообщение</button>
</div>
