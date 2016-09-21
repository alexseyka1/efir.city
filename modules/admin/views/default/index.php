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
    .pusher {
        position: relative;
        height: 100% !important;
    }
    
</style>

<!--<div class="container-fluid" style="padding-top: 20px">
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
</div>-->

<div class="ui main grid">
    <div class="ui fixed inverted main menu">
        <div class="ui container">
            <a class="launch icon item sidebar-toggle">
                <i class="sidebar icon"></i>
            </a>
        </div>
    </div>

    <!--<h1 class="ui header datetime">Current time</h1>-->

    <!--<div class="ui icon message">
        <i class="empty heart icon"></i>
        <div class="content">
            <div class="header">
                Welcome to our admin theme!
            </div>
            <p>You'll find a lot of common admin views here. For requests, just tweet <a href="https://twitter.com/SemanticKit">@SemanticKit</a> or <a href="https://twitter.com/travisvalentine">@travisvalentine</a>.</p>
        </div>
    </div>-->

    <div class="ui two column row">
        <div class="dashboard-stat column">
            <div class="ui segments">
                <div class="ui red segment">
                    <h3 class="ui blue header">Статистика сообщений</h3>
                </div>
                <div class="ui secondary olive green inverted dashboard center aligned segment">
                    <div class="ui dashboard statistic">
                        <div class="value" id="allMessages">
                            
                        </div>
                        <div class="label">
                            Всего
                        </div>

                        <div class="ui two mini statistics">
                            <div class="statistic">
                                <div class="value" id="paidMessages">
                                    
                                </div>
                                <div class="label">
                                    Оплачено
                                </div>
                            </div>
                            <div class="statistic">
                                <div class="value" id="publishedMessages">
                                    
                                </div>
                                <div class="label">
                                    Опубликовано
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui segment" style="padding: 0; border: none">
                    <div class="progress" style="margin: 0; border-radius: 0px; height: 48px;">
                        <div class="progress-bar" id="progressPaid" style="width: 0%; background: #00B5AD;"></div>
                        <div class="progress-bar" id="progressUnpaid" style="width: 0%; background: #A333C8;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-stat column">
            <div class="ui segments">
                <div class="ui blue segment">
                    <h3 class="ui blue header">3 самых популярных города</h3>
                </div>
                <div class="ui teal inverted dashboard center aligned segment">
                    <div class="ui segments popularCities">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Загрузка</div>
                        </div>
                    </div>
                </div>
                <div class="ui segment" style="padding: .4em">
                    <a href="/admin/city" class="fluid ui button">Смотреть все города</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!--<div class="top-table column">
            <div class="ui segments">
                <div class="ui segment">
                    <h3 class="ui blue header">Any Header</h3>
                </div>
                <div class="ui segment">
                    <table class="ui very basic table">
                        <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Item 1</td>
                            <td>$20</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Item 2</td>
                            <td>$22</td>
                            <td>24</td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>Item 3</td>
                            <td>$15</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td>Item 4</td>
                            <td>$10</td>
                            <td>18</td>
                        </tr>
                        <tr>
                            <td>5.</td>
                            <td>Item 5</td>
                            <td>$15</td>
                            <td>15</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>-->

        <div class="column">
            <div class="ui segments">
                <div class="ui orange segment">
                    <h3 class="ui blue header">Последние 50 сообщений</h3>
                </div>
                <div class="ui segment chatWindow" id="chatWindow">
                    
                </div>
            </div>
        </div>
    </div>
    <!--<div class="ui three column row">
        <div class="dashboard-stat column">
            <div class="ui segments">
                <div class="ui segment">
                    <h3 class="ui blue header">Any Header</h3>
                </div>
                <div class="ui violet inverted dashboard center aligned segment">
                    <div class="ui dashboard statistic">
                        <div class="value">
                            5,550
                        </div>
                        <div class="label">
                            Downloads
                        </div>
                    </div>
                </div>
                <div class="ui segment">
                    Footer
                </div>
            </div>
        </div>
    </div>-->
</div>


<script src="/js/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/jquery.noty.packaged.min.js"></script>
<script src="/js/scrollto.js"></script>
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
                                    <button class="ui circular icon button deleteMessage" style='margin-right: 2em' data-id="`+messages[message].id+`">
                                        <i class="trash icon"></i>
                                    </button>
                                </div>
                            </div>
                        </li>`;
                }
                let paidMessages = Math.round(Number(Number(countPaid)/ Number(countAll)) * 100),
                    unpaidMessages = Number(100 - paidMessages);
                $('#progressPaid').html(paidMessages + '% оплачено').css('width', paidMessages + '%');
                $('#progressUnpaid').html(unpaidMessages + '%').css('width', unpaidMessages + '%');
                $('#allMessages').text(countAll);
                $('#paidMessages').text(countPaid);
                $('#publishedMessages').text(countPublished);
                $('.chatWindow').html(newString);
                $('body').on('click', 'button.deleteMessage', function(){
                    var id = $(this).attr('data-id');
                    var that = $(this);
                    if(id){
                        $.post('/admin/index/deletemessage',{'_csrf' : '<?=Yii::$app->request->getCsrfToken()?>', id:id})
                            .done(function(data){
                                if(data && data == 1){
                                    noty({text: '<div class="trayMessage"><p>Сообщение #'+id+' успешно удалено!</p></div>',layout: 'topRight',theme: 'defaultTheme',timeout: 6000,/*killer: false,*/closeWith: ['click'],type: 'success'});
                                    that.parents('li').slideUp(300);
                                }
                            });
                    }
                });
                newString = '';
                for(var popCity in popularCities){
                    newString += `
                        <div class="ui segment">
                            <div class="row oneMessage">
                                <div class="col-md-3" style="color: black;"><strong>`+popularCities[popCity].city_id+`</strong></div>
                                <div class="col-md-6" style="color: black;">`+popularCities[popCity].name+`</div>
                                <div class="col-md-3" style="color: black;"><span class="badge" style="float:right">`+popularCities[popCity].max+`</span></div>
                            </div>
                        </div>
                    `;
                }
                $('.popularCities').html(newString);

                //document.getElementById('chatWindow').scrollIntoView(false);
                $('#chatWindow').animate({scrollTop: document.getElementById('chatWindow').scrollHeight},"fast");

                setTimeout(lastTenMssages, 10000);
            });
    }
</script>