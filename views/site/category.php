<?php

/* @var $this yii\web\View */

$this->title = !empty($seoPage) ? $seoPage['title'] : 'Общение в ' . $this->context->city;
?>

<audio id="newMessageSound">
    <source src="/vk.mp3" type="audio/mpeg">
</audio>
<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Отправить сообщение</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="newMessageTo">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" class="form-control" placeholder="Ваше имя" id="newMessageName">
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <textarea class="form-control" id="newMessageText" placeholder="Текст сообщения"></textarea>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <div class="input-group">
                            <span class="input-group-addon">+</span>
                            <input type="text" class="form-control" id="newMessagePayPhone" placeholder="Номер телефона для оплаты">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <div class="input-group">
                            <span class="input-group-addon">+</span>
                            <input type="text" class="form-control" id="newMessageConnectPhone" placeholder="Номер телефона для связи">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                        <input type="checkbox" id="newMessageAllowRules" checked> Я согласен с <strong style="font-style: italic">правилами</strong> сервиса
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary" id="sendNewMessageToChat">Отправить</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row" style="margin:0;">
    <?php $index = 1; foreach ($allCategories as $category) { ?>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 centerTab" data-tab="<?=!empty($category['id']) ? $category['id'] : $index;?>">
            <div>
                <span class="<?=!empty($category['icon']) ? $category['icon'] : 'glyphicon glyphicon-asterisk' ;?> categoryImage"></span>
            </div>
            <?=!empty($category['category_name']) ? $category['category_name'] : '...';?>
        </div>
    <? $index++; } ?>
</div>

<div class="row windowChat" style="margin:0;">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="emptyChatMessage info">Здесь еще пусто! Напиши сообщение, будь первым!</div>
        </div>
    </div>
</div>
