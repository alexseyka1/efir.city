<!--<div class="Admin-default-index">
    <h1>Привет, <strong><?/*=\Yii::$app->user->identity->username;*/?></strong></h1>
</div>-->
<style>
    .panel, .panel-heading {
        border-radius: 0px;
    }
    .badge {
        background-color: #673ab7;
    }
    .chatWindow {
        overflow-y: scroll;
        overflow-x: hidden;
        max-height: 300px;
    }
    .list-group {
        margin-bottom: 0;
    }
</style>

<div class="container-fluid" style="padding-top: 20px">
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h4 style="margin:0;">Статистика сообщений</h4></div>
                <ul class="list-group">
                    <li class="list-group-item">Всего <span class="badge" id="allMessages">...</span></li>
                    <li class="list-group-item">Оплачено <span class="badge" id="paidMessages">...</span></li>
                    <li class="list-group-item">Опубликовано <span class="badge" id="publishedMessages">...</span></li>
                </ul>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h4 style="margin:0;">3 самых популярных города</h4></div>
                <ul class="list-group popularCities"></ul>
            </div>
            
        </div>
        <div class="col-lg-8 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><h4 style="margin:0;">Последние 50 сообщений</h4></div>
                <ul class="list-group">
                    <li class="list-group-item" style="padding: 0;">
                        <ul class="list-group chatWindow">
                            
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="/js/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/jquery.noty.packaged.min.js"></script>
<script>
    $(document).ready(function(){
        lastTenMssages();
    });
    
    function lastTenMssages() {
        $.post('/admin/index/lasttenmessages',{'_csrf' : '<?=Yii::$app->request->getCsrfToken()?>'})
            .done(function(data){
                //noinspection JSUnresolvedVariable
                var dat = JSON.parse(data),
                    countAll = dat.countAll,
                    countPaid = dat.countPaid,
                    countPublished = dat.countPublished,
                    messages = dat.messages,
                    popularCities = dat.popularCities,
                    newString = '';
                for(var message in messages){
                    newString += `
                        <li class="list-group-item">
                            <div class="row oneMessage">
                                <div class="col-md-3"><strong>`+messages[message].author_name+`</strong></div>
                                <div class="col-md-8">`+messages[message].message_text+`</div>
                                <div class="col-md-1">
                                    <button class="btn btn-danger btn-block deleteMessage" style="padding: 8px 0; font-size: 18px;" data-id="`+messages[message].id+`">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </div>
                            </div>
                        </li>`;
                }
                $('#allMessages').text(countAll);
                $('#paidMessages').text(countPaid);
                $('#publishedMessages').text(countPublished);
                $('ul.chatWindow').html(newString);
                $('button.deleteMessage').click(function(){
                    var id = $(this).attr('data-id');
                    if(id){
                        $.post('/admin/index/deletemessage',{'_csrf' : '<?=Yii::$app->request->getCsrfToken()?>', id:id})
                            .done(function(data){
                                if(data && data == 1){
                                    noty({text: '<div class="trayMessage"><p>Сообщение #'+id+' успешно удалено!</p></div>',layout: 'topRight',theme: 'defaultTheme',timeout: 6000,/*killer: false,*/closeWith: ['click'],type: 'success'});
                                }
                            });
                    }
                });
                newString = '';
                for(var popCity in popularCities){
                    newString += `
                        <li class="list-group-item">
                            <div class="row oneMessage">
                                <div class="col-md-3"><strong>`+popularCities[popCity].city_id+`</strong></div>
                                <div class="col-md-6">`+popularCities[popCity].name+`</div>
                                <div class="col-md-3"><span class="badge" style="float:right">`+popularCities[popCity].max+`</span></div>
                            </div>
                        </li>
                    `;
                }
                $('ul.popularCities').html(newString);
                setTimeout(lastTenMssages, 1000);
            });
    }
</script>