'use strict';
var eventSource,
    okPayPhone =0,
    okConnectPhone=0,
    isLoaded = false,
    isAnswering = false;

if(!getCookie('JSESSIONID') || getCookie('JSESSIONID') === null){
	setCookie('JSESSIONID', guid());
}

window.onunload = function(){
    localStorage.removeItem('lastMessageId');
}
window.addEventListener('popstate', function(e){
  window.location.reload();
}, false);

$(document).ready(function(){
    var url = window.location.pathname;
    switch (url){
        case '/':
            root();
            break;
        default: break;
    }
    switch(true){
        case /\d+\/\d+/.test(url):
            $(document).ready(function(){
                let name = localStorage.getItem('name') ? localStorage.getItem('name') : '';
                let payPhone = localStorage.getItem('payPhone') ? localStorage.getItem('payPhone') : '';
                let connectPhone = localStorage.getItem('connectPhone') ? localStorage.getItem('connectPhone') : '';
                
                if($('input#answerMessageId[type=hidden][role=var]').length > 0) {
                    isAnswering = true;
                    $('button#bottomButtonWrite').css('display','none');
                    $.post('/answer/message/' + $('input#answerMessageId[type=hidden][role=var]').val())
                        .done(function (data) {
                            if (data) {
                                let dat = JSON.parse(data),
                                    datetime = dat.post_datetime.split(' '),
                                    date = datetime[0],
                                    time = datetime[1];
                                console.log(dat);
                                let answerString = `
                                    <div class="wizard" data-initialize="wizard" id="myWizard">
                                        <div class="steps-container">
                                            <ul class="steps">
                                                <li data-step="1" data-name="country" class="active">
                                                    <span class="badge">1 шаг</span>Написание ответа
                                                    <span class="chevron"></span>
                                                </li>
                                                <li data-step="2" data-name="region">
                                                    <span class="badge">2 шаг</span>Выбор способа оплаты
                                                    <span class="chevron"></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="step-content">
                                            <div class="step-pane active sample-pane alert" data-step="1">
                                                <div class="row message">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="display: flex;align-items: center;justify-content: center;">
                                                        <span class="time">
                                                            <div class="timeDate">` + date + `</div>
                                                            <div class="timetime">` + time + `</div>
                                                         </span>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                        <p class="messageTitle">Алексей2</p>
                                                        <p class="messageText">321123</p>
                                                    </div>
                                                </div>
                                                <div class="row message">
                                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="display: flex;align-items: center;justify-content: center;">
                                                        <span class="time">
                                                            <div class="timeDate">&nbsp;</div>
                                                            <div class="timetime">Пример ответа</div>
                                                        </span>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                        <p class="messageTitle">&nbsp;</p>
                                                        <p class="messageText">Привет! Меня заинтересовало твое сообщение.<br>Можем обсудить - 8 920 823 93 12</p>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 30px;">
                                                    <p>Текст ответного сообщения</p>
                                                    <p><textarea style="width: 100%; height: 100px;"/></p>
                                                    <button class="btn btn-info btn-block" onclick="$('#myWizard').wizard('next');">ОТПРАВИТЬ СООБЩЕНИЕ</button>
                                                </div>
                                            </div>
                                            <div class="step-pane sample-pane sample-pane alert" data-step="2">
                                                <h2>Теперь выберите ваш регион из доступных ниже:</h2>
                                                <p>
                                                    <select id="selectRegion" class="form-control">
                                                        <option value="-1">...</option>
                                                    </select>
                                                </p>
                                            </div>
                                           
                                        </div>
                                    </div> 
                                `;
                                $('div.windowChat').html(answerString);
                            }
                        });
                }

                $('.modal #newMessageName').val(name);
                $('.modal #newMessagePayPhone').val(payPhone);
                $('.modal #newMessageConnectPhone').val(connectPhone);
            });
            chat();
            break;
        //case /\d+\/\d+/.test(url):
        default:
        //case /^[A-Za-zА-Яа-яЁё]+\/[A-Za-zА-Яа-яЁё]+$/.test(url):
            $(document).ready(function(){
                let name = localStorage.getItem('name') ? localStorage.getItem('name') : '';
                let payPhone = localStorage.getItem('payPhone') ? localStorage.getItem('payPhone') : '';
                let connectPhone = localStorage.getItem('connectPhone') ? localStorage.getItem('connectPhone') : '';

                $('.modal #newMessageName').val(name);
                $('.modal #newMessagePayPhone').val(payPhone);
                $('.modal #newMessageConnectPhone').val(connectPhone);
            });
            chat();
            break;
        //default: if(eventSource) { eventSource.close();} break;
    }
});

function guid() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
}

function root(){
    
    $('select#selectCountry').change(function(){
        var countryId = $('select#selectCountry').val();
        if(countryId !== -1){
            $.post( "/get/all/regions", { countryId: countryId })
                .done(function( data ) {
                    if(data && data.length > 0){
                        var dat = JSON.parse(data),
                            options = '<option value="-1">...</option>';
                        for(var option in dat){
                            if(dat[option].region_id && dat[option].name){
                                options += '<option value="' + dat[option].region_id + '">' +dat[option].name+ '</option>';
                            }
                        }
                        if(options.length > 0) {
                            $('select#selectRegion').html(options);
                            $('#myWizard').wizard('next');
                        }
                    }
                });
        }
    });

    $('select#selectRegion').change(function(){
        var regionId = $('select#selectRegion').val();
        if(regionId !== -1){
            $.post( "/get/all/cities", { regionId: regionId })
                .done(function( data ) {
                    if(data && data.length > 0){
                        var dat = JSON.parse(data),
                            options = '<option value="-1">...</option>';
                        for(var option in dat){
                            if(dat[option].city_id && dat[option].name){
                                options += '<option value="' + dat[option].city_id + '">' +dat[option].name+ '</option>';
                            }
                        }
                        if(options.length > 0) {
                            $('select#selectCity').html(options);
                            $('#myWizard').wizard('next');
                        }
                    }
                });
        }
    });

    $('select#selectCity').change(function(){
        var regionId = $('select#selectCity').val();
        if(regionId !== -1){
            $('button#goChat').slideDown(300);
        }
    });

    $('button#goChat').click(function(){
        if($('select#selectCountry').val() && $('select#selectRegion').val() && $('select#selectCity').val()) {
            localStorage.setItem('countryId', $('select#selectCountry').val());
            localStorage.setItem('regionId', $('select#selectRegion').val());
            localStorage.setItem('cityId', $('select#selectCity').val());

            setCookie('countryId', $('select#selectCountry').val());
            setCookie('regionId', $('select#selectRegion').val());
            setCookie('cityId', $('select#selectCity').val());
            
            window.location.reload();
        }
    });

}

$('button#sendNewMessageToChat').click(sendNewMessageToChat);

function chat(){
    $('.windowChat').bind('scroll', onAjaxScroll);
    $('.modal input#newMessagePayPhone').inputmask("99999999999[9][9][9]");
    $('.modal input#newMessageConnectPhone').inputmask("99999999999[9][9][9]");
    if ($('.modal input#newMessagePayPhone').inputmask("isComplete")){
        $('.modal input#newMessagePayPhone')
            .css({'border':'1px solid green', 'border-left': 'none'})
            .parent()
                .find('span')
                .css({'border':'1px solid green','border-right':'1px solid #ddd'});
        okPayPhone = 1;
    }
    if ($('.modal input#newMessageConnectPhone').inputmask("isComplete")){
        $('.modal input#newMessageConnectPhone')
            .css({'border':'1px solid green', 'border-left': 'none'})
            .parent()
                .find('span')
                .css({'border':'1px solid green','border-right':'1px solid #ddd'});
        okConnectPhone = 1;
    }
    
    $('div.col-md-3.centerTab').click(function(){
        let uri = $(this).attr('data-tab');
        if(uri.length > 0){
            var cityId = $('input#cityId[role=var]').val();
            var categoryId = $('input#categoryId[role=var]').val();
            //window.location = uri;
            window.location = '/' + cityId + '/' + uri;
        }
    });
    $("#bottomButtonWrite").css('width',$('.centerWindowDiv').width());
    $('#bottomButtonWrite').click(function(){
        $('.modal').modal('show');
    });
    var uri = window.location.pathname.split('/');
    //if(uri && uri[(uri.length)-1] && /\d+/.test(uri[(uri.length-1)]) && uri[(uri.length)-2] && /\d+/.test(uri[(uri.length-2)])) {
        //var cityId = uri[(uri.length - 2)];
        //var categoryId = uri[(uri.length - 1)];
        var cityId = $('input#cityId[role=var]').val();
        var categoryId = $('input#categoryId[role=var]').val();
        
    if(!isAnswering) {
        getMessages(cityId, categoryId)
            .then(response => {
                if (response !== 'none') {
                    let result = JSON.parse(response);
                    return result;
                } else {
                    return false;
                }
            })
            .then(result => {
                if (result && result !== false && typeof result == 'object') {
                    let newMessagesString = '';
                    for (let message in result) {
                        let datetime = new Date(),
                            messageDatetime = result[message].post_datetime.split(' '),
                            messageTo = result[message].to,
                            messageToPhone = result[message].toPhone;
                        if (datetime.getMonth().length == 1) {
                            var dateString = datetime.getFullYear()
                                + '-' + (datetime.getMonth() + 1)
                                + '-' + datetime.getDate();
                        } else {
                            var dateString = datetime.getFullYear()
                                + '-0' + (datetime.getMonth() + 1)
                                + '-' + datetime.getDate();
                        }
                        messageDatetime[0] = messageDatetime[0].replace(dateString, "Сегодня");

                        newMessagesString += `
                            <div class="row message" data-id="` + result[message].id + `">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="display: flex;align-items: center;justify-content: center;">
                                    <span class="time">
                                        <div class="timeDate">` + messageDatetime[0] + `</div>
                                        <div class="timetime">` + messageDatetime[1] + `</div>
                                     </span>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <p class="messageTitle">` + result[message].author_name + `</p>
                                    <p class="messageText">` + result[message].message_text + `</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 answerBlock">
                                    <div class="answerMessage">
                                        <a href="/`+$('input#cityId').val()+`/`+$('input#categoryId').val()+`/answer/` + result[message].id + `" style="color:#3670b0;cursor:pointer;" class="buttonAnswerToMessage" target="_blank" data-to="` + result[message].id + `" data-toName="` + result[message].author_name + `">Ответить</a>    
                                    </div>
                                </div>
                                
                            </div>
                        `;
                        localStorage.setItem('lastMessageId', result[message].id);
                        if (isLoaded) {
                            if (messageTo == getCookie('JSESSIONID') || messageToPhone == localStorage.getItem('connectPhone')) {
                                noty({
                                    text: '<div class="trayMessage"><p>Вам ответили!</p><p>' + result[message].author_name + ':</p><p>' + result[message].message_text + '</p></div>',
                                    layout: 'topRight',
                                    theme: 'defaultTheme',
                                    timeout: 6000, /*killer: false,*/
                                    closeWith: ['click'],
                                    type: 'info'
                                });
                            }
                        }
                    }
                    if ($('div.windowChat').text().trim() == "Здесь еще пусто! Напиши сообщение, будь первым!") {
                        $('div.windowChat').last().html('');
                    }
                    if (isLoaded) {
                        document.getElementById('newMessageSound').play();
                    }
                    $('div.windowChat').last().append(newMessagesString);
                    //$('div.windowChat').scrollTo($('div.windowChat div').last());
                    isLoaded = true;
                }
            })
            .then(result => {
                setTimeout(function () {
                    chat();
                }, 1000);
            });
    }
    //}
}
function onAjaxScroll(e){
    let fromTop = $(this).scrollTop(),
        nowDate = new Date();
    if(fromTop == 0 &&
        nowDate.getFullYear()
        +nowDate.getDate()
        +nowDate.getDay()
        +nowDate.getHours()
        +nowDate.getMinutes()
        +nowDate.getSeconds() != localStorage.getItem('lastAjaxScroll')){
        $(this).unbind('scroll');

        /*let cityId = uri[(uri.length-2)],
            categoryId = uri[(uri.length-1)];*/
        let cityId = $('input#cityId[role=var]').val();
        let categoryId = $('input#categoryId[role=var]').val();
        
        getAjaxScroll(cityId, categoryId)
            .then(response => {
                if(response !== 'none') {
                    let result = JSON.parse(response);
                    return result;
                }else{
                    return false;
                }
            })
            .then(result => {
                if (result && result !== false && typeof result == 'object') {
                    let newMessagesString = '';
                    for(let message in result){
                        if(!$('.windowChat div[data-id="'+result[message].id+'"]').length) {
                            let datetime = new Date(),
                                messageDatetime = result[message].post_datetime.split(' ');
                            if (datetime.getMonth().length == 1) {
                                var dateString = datetime.getFullYear()
                                    + '-' + (datetime.getMonth() + 1)
                                    + '-' + datetime.getDate();
                            } else {
                                var dateString = datetime.getFullYear()
                                    + '-0' + (datetime.getMonth() + 1)
                                    + '-' + datetime.getDate();
                            }
                            messageDatetime[0] = messageDatetime[0].replace(dateString, "Сегодня");

                            newMessagesString += `
                                <div class="row message" data-id="` + result[message].id + `">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="display: flex;align-items: center;justify-content: center;">
                                        <span class="time">
                                            <div class="timeDate">` + messageDatetime[0] + `</div>
                                            <div class="timetime">` + messageDatetime[1] + `</div>
                                         </span>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <p class="messageTitle">` + result[message].author_name + `</p>
                                        <p class="messageText">` + result[message].message_text + `</p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 answerBlock">
                                        <div class="answerMessage">
                                            <a href="#">Ответить</a>    
                                        </div>
                                    </div>
                                    
                                </div>
                            `;
                            //localStorage.setItem('firsttMessageId',result[message].id);
                        }
                    };
                    $('div.windowChat').first().prepend(newMessagesString);
                    //$('div.windowChat').scrollTo($('div.windowChat div.row').eq(10), 0);

                    let datetime = new Date();
                    localStorage.setItem('lastAjaxScroll',
                        datetime.getFullYear()
                        +datetime.getDate()
                        +datetime.getDay()
                        +datetime.getHours()
                        +datetime.getMinutes()
                        +datetime.getSeconds());
                    setTimeout(function(){
                        $('.windowChat').bind('scroll', onAjaxScroll);
                    },1000);
                }
            });
    }
}
function getMessages(cityId, categoryId) {
    return new Promise(function(resolve, reject) {

        var xhr = new XMLHttpRequest(),
            lastMessage = localStorage.getItem('lastMessageId') ? localStorage.getItem('lastMessageId') : 0;
        if (!xhr) {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        try{
            xhr.open('GET', "/ajax/getMessages/"+cityId+"/"+categoryId+"/"+lastMessage, true);

            xhr.onload = function() {
                if (this.status == 200) {
                    resolve(this.response);
                } else {
                    var error = new Error(this.statusText);
                    error.code = this.status;
                    reject(error);
                }
            };

            xhr.onerror = function() {
                throw new Error();
                reject(new Error("Network Error"));
            };

            xhr.send();
        }catch(e){
            getMessages(cityId, categoryId);
        }
    });
}
function getAjaxScroll(cityId, categoryId) {
    return new Promise(function(resolve, reject) {

        var xhr = new XMLHttpRequest(),
            firstMessage = $('.windowChat div').eq(0).attr('data-id');
        if (!xhr) {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhr.open('GET', "/ajax/getAjaxScroll/"+cityId+"/"+categoryId+"/"+firstMessage, true);

        xhr.onload = function() {
            if (this.status == 200) {
                resolve(this.response);
            } else {
                var error = new Error(this.statusText);
                error.code = this.status;
                reject(error);
            }
        };

        xhr.onerror = function() {
            reject(new Error("Network Error"));
        };

        xhr.send();
    });
}
function sendNewMessageToChat() {
    $('.modal input, .modal textarea').each(function(e, elem){
        if($(elem).val().length && ['newMessagePayPhone','newMessageConnectPhone'].indexOf($(elem).attr('id')) == -1){
            $(elem).css('border','1px solid #ddd');
        }
    });
    let name = $('.modal #newMessageName'),
        messageText = $('.modal #newMessageText'),
        payPhone = $('.modal #newMessagePayPhone'),
        connectPhone = $('.modal #newMessageConnectPhone'),
        allowRules = $('.modal #newMessageAllowRules'),
        messageTo = $('.modal #newMessageTo');
    if(
        name.val().length > 0
        && messageText.val().length > 0
        && payPhone.val().length > 0
        && connectPhone.val().length > 0
        && allowRules.val()
    ){
        if(okConnectPhone && okPayPhone && allowRules.is(':checked')){
            let result = {
                name : name.val(),
                messageText : messageText.val(),
                payPhone : payPhone.val(),
                connectPhone : connectPhone.val(),
                allowRules : 1,
                jsSessionId : getCookie('JSESSIONID'),
                messageTo : messageTo.val() ? messageTo.val() : 0,
            };
            //let uri = window.location.pathname.split('/');
            let cityId = $('input#cityId[role=var]').val();
            let categoryId = $('input#categoryId[role=var]').val();
            $.post( "/new/message/"+cityId+"/"+categoryId, {data : JSON.stringify(result)})
                .done(function( data ) {
                    if(data == 1){
                        localStorage.setItem('name',name.val());
                        localStorage.setItem('payPhone',payPhone.val());
                        localStorage.setItem('connectPhone',connectPhone.val());

                        messageText.val('');
                        allowRules.removeAttr('checked');

                        $('.modal').modal('hide');
                        noty({text: '<div class="trayMessage"><p>Сообщение успешно отправлено!</p><p>Оно будет опубликовано сразу после вашей <strong>оплаты</strong>!</p></div>',layout: 'topRight',theme: 'defaultTheme',timeout: 6000,/*killer: false,*/closeWith: ['click'],type: 'success'});
                    }
                });
        }else if(allowRules.is(':not(:checked)')){
            allowRules.parent().css('background','rgba(244,67,54,.45)');
            noty({text: '<div class="trayMessage"><p>Для отправки нужно согласиться с <strong>правилами</strong> сервиса!</p></div>',layout: 'topRight',theme: 'defaultTheme',timeout: 6000,/*killer: false,*/closeWith: ['click'],type: 'info'});
        }
    }else if(!name.val()){
        name.css('border','1px solid red');
    }else if(!messageText.val()){
        messageText.css('border','1px solid red');
    }else if(!payPhone.val()){
        payPhone.css('border','1px solid red');
    }else if(!connectPhone.val()){
        connectPhone.css('border','1px solid red');
    }
}

$('#pageInstruction').click(function(){
    $.post( "/instructions")
        .done(function( data ) {
            if(data && data.length > 0){
                history.pushState('', '', '/instructions');
                $('div#mainContentWindow').html(data);
                $('.row.leftBarBlock.rightBarBlock .leftBarBlockHeader').each(function(i, elem){
                    var cityId = $('input#cityId[role=var]').val();
                    var categoryId = $('input#categoryId[role=var]').val();
                    if($(elem).attr('data-url') == window.location.pathname || $(elem).attr('data-url') == '/'+cityId+'/'+categoryId){
                        $(elem).removeClass('rightBarBlockHeaderNonActive').addClass('rightBarBlockHeaderActive');
                    }else{
                        $(elem).removeClass('rightBarBlockHeaderActive').addClass('rightBarBlockHeaderNonActive');
                    }
                });
            }
        });
});
$('#pageCost').click(function(){
    $.post( "/cost")
        .done(function( data ) {
            if(data && data.length > 0){
                history.pushState('', '', '/cost');
                $('div#mainContentWindow').html(data);
                $('.row.leftBarBlock.rightBarBlock .leftBarBlockHeader').each(function(i, elem){
                    var cityId = $('input#cityId[role=var]').val();
                    var categoryId = $('input#categoryId[role=var]').val();
                    if($(elem).attr('data-url') == window.location.pathname || $(elem).attr('data-url') == '/'+cityId+'/'+categoryId){
                        $(elem).removeClass('rightBarBlockHeaderNonActive').addClass('rightBarBlockHeaderActive');
                    }else{
                        $(elem).removeClass('rightBarBlockHeaderActive').addClass('rightBarBlockHeaderNonActive');
                    }
                });
            }
        });
});
$('#pageRules').click(function(){
    $.post( "/rules")
        .done(function( data ) {
            if(data && data.length > 0){
                history.pushState('', '', '/rules');
                $('div#mainContentWindow').html(data);
                $('.row.leftBarBlock.rightBarBlock .leftBarBlockHeader').each(function(i, elem){
                    var cityId = $('input#cityId[role=var]').val();
                    var categoryId = $('input#categoryId[role=var]').val();
                    if($(elem).attr('data-url') == window.location.pathname || $(elem).attr('data-url') == '/'+cityId+'/'+categoryId){
                        $(elem).removeClass('rightBarBlockHeaderNonActive').addClass('rightBarBlockHeaderActive');
                    }else{
                        $(elem).removeClass('rightBarBlockHeaderActive').addClass('rightBarBlockHeaderNonActive');
                    }
                });
            }
        });
});
$('#pageFaq').click(function(){
    $.post( "/faq")
        .done(function( data ) {
            if(data && data.length > 0){
                history.pushState('', '', '/faq');
                $('div#mainContentWindow').html(data);
                $('.row.leftBarBlock.rightBarBlock .leftBarBlockHeader').each(function(i, elem){
                    var cityId = $('input#cityId[role=var]').val();
                    var categoryId = $('input#categoryId[role=var]').val();
                    if($(elem).attr('data-url') == window.location.pathname || $(elem).attr('data-url') == '/'+cityId+'/'+categoryId){
                        $(elem).removeClass('rightBarBlockHeaderNonActive').addClass('rightBarBlockHeaderActive');
                    }else{
                        $(elem).removeClass('rightBarBlockHeaderActive').addClass('rightBarBlockHeaderNonActive');
                    }
                });
            }
        });
});

/*$('.row.leftBarBlock.rightBarBlock .leftBarBlockHeader').each(function(i, elem){
    var cityId = $('input#cityId[role=var]').val();
    var categoryId = $('input#categoryId[role=var]').val();
    if($(elem).attr('data-url') == window.location.pathname || $(elem).attr('data-url') == '/'+cityId+'/'+categoryId){
        $(elem).removeClass('rightBarBlockHeaderNonActive').addClass('rightBarBlockHeaderActive');
    }
});*/

$('#efirsNav li').each(function(i, elem){
    var uri = window.location.pathname.split('/');
    var cityId = $('input#cityId[role=var]').val();
    var categoryId = $('input#categoryId[role=var]').val();
    if($(elem).attr('data-tab') == uri[(uri.length-1)] || $(elem).attr('data-tab') == categoryId){
        $(elem).addClass('active');
    }else{
        $(elem).removeClass('active');
    }
});

/*$('div.socialBlock').click(function(){
    if($(this).attr('data-url').length > 0){
        window.location = $(this).attr('data-url');
    }
});*/

$('button#buttonBack').click(function(){
    window.location = '/removeAllCookies';
});


function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}
function deleteCookie(name) {
    setCookie(name, "", {
        expires: -1
    })
}
