'use strict';

var maxMessage = 140;

const month = {
    '01': 'янв',
    '02': 'фев',
    '03': 'мар',
    '04': 'апр',
    '05': 'мая',
    '06': 'июн',
    '07': 'июл',
    '08': 'авг',
    '09': 'сен',
    '10': 'окт',
    '11': 'ноя',
    '12': 'дек'
};
var sse;

window.onunload = function(){
    localStorage.removeItem('lastMessageId');
}
$(document).ready(function() {
    //$('#items').customScroll();
    setTimeout(function(){
        $('#selects').customScroll();
    }, 200);
    $('.header .menu-button').click(function() {
        $('.menu-bg').fadeIn(1);
        $('.left-side').addClass('opened');
    });
    $('.menu-bg').click(function() {
        $(this).fadeOut(1);
        $('.left-side').removeClass('opened');
    });
    $('.left-side .after').click(function() {
        $('.menu-bg').fadeOut(1);
        $('.left-side').removeClass('opened');
    });
    $('.popup .select').click(function() {
        $('#selects').customScroll();
        $('.popup .selects').fadeOut(1);
        $(this).next('.popup .selects').fadeIn(1);
    });
    $('.popup .selects .close-btn').click(function() {
        $('.popup .selects').fadeOut(1);
    });
    $('.header .city-select').click(function() {
        $('.popupbg').fadeIn(1);
        $('.popup').fadeIn(1);
    });
    $('.left-side .city-select').click(function() {
        $('.menu-bg').fadeOut(1);
        $('.left-side').removeClass('opened');
        $('.popupbg').fadeIn(1);
        $('.popup').fadeIn(1);
    });
    $('.popupbg').click(function() {
        $(this).fadeOut(1);
        $('.popup').fadeOut(1);
    });
    $('.popup .close').click(function() {
        $('.popupbg').fadeOut(1);
        $('.popup').fadeOut(1);
    });
    $('.spoiler-body').hide();
    $('body').on('click', '.spoiler-head', function(){
        $(this).toggleClass("folded").next().toggle();
    });

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
});

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
    var url = window.location.pathname.replace('#','');
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
                    let csrfToken = $('meta[name="csrf-token"]').attr("content");
                    $.post('/answer/message/' + $('input#answerMessageId[type=hidden][role=var]').val(), {_csrf: csrfToken})
                        .done(function (data) {
                            if (data) {
                                let dat = JSON.parse(data),
                                    datetime = dat.post_datetime.split(' '),
                                    date = datetime[0],
                                    day = date.split('-')[2],
                                    monthName = month[date.split('-')[1]],
                                    time = datetime[1].split(':')[0] +':'+ datetime[1].split(':')[1];
                                //console.log(dat);
                                let answerString = `
                                    <div class="wizard" data-initialize="wizard" id="myWizard" style="border:none;">
                                        <div class="steps-container">
                                            <ul class="steps message">
                                                <li data-step="1" data-name="country"  class="step1 active" style="max-height: 34px;max-width: 253px;border: none;line-height: 2.2rem;margin-right: 0 !important;margin-left: 1rem !important; margin-bottom: 0 !important;">
                                                    <span>1 шаг</span> Написание ответа
                                                </li>
                                                <li data-step="2" data-name="country"  class="step2" style="max-height: 34px;max-width: 243px;border: none;line-height: 2.2rem;margin-right: 0 !important;margin-left: 0 !important; margin-bottom: 0 !important;">
                                                    <span>2 шаг</span> Выбор способа оплаты
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="step-content" style="width:auto;float:none;padding:0;border:none;">
                                            <div class="step-pane active sample-pane alert" data-step="1">
                                                <div class="message" style="padding-top: 0!important;">
                                                    <div class="item">
                                                        <div class="info">
                                                            <div class="content">
                                                                <div class="name">
                                                                    `+dat.author_name+`
                                                                    <span>`+day+' '+monthName+` в `+time+`</span>
                                                                </div>
                                                                <div class="text">
                                                                    `+dat.message_text+`
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="info">
                                                            <div class="content">
                                                                <div class="name">
                                                                    Пример ответа
                                                                </div>
                                                                <div class="text">
                                                                    Привет! Меня заинтересовало твое сообщение.<br>Можем обсудить - 8 920 823 93 12
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <form>
                                                        <div class="left nom">Текст ответного сообщения</div>
                                                        <div class="right nom">Осталось <span id="maxMessage">`+maxMessage+`</span> символов</div>
                                                        <div class="clear"></div>
                                                        <textarea id="answerText"></textarea>
                                                        <div class="bottom-text">
                                                            <p>ВНИМАНИЕ! Мы никому не показываем ваш номер телефона. На этот номер телефона будут приходить SMS с ответами на ваше сообщение опубликованное эфире.</p>
                                                            <p><label><input type="checkbox" id="applyRules"> Я ознакомился и согласен с правилами и условиями использования данного сервиса.</label></p>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="step-pane sample-pane sample-pane alert" data-step="2">
                                                <div class="message" style="padding-top:0 !important;">
                                                        <div class="payment">
                                                            <p>Выберите способ оплаты</p>
                                                            <div class="item">
                                                                <div class="image">
                                                                    <img src="/img/payment1.jpg" style="margin-top: 1.4rem !important;">
                                                                </div>
                                                                <div class="radios">
                                                                    <label><input type="radio" name="paymentType"> Банковская карта</label>
                                                                </div>
                                                                <div class="price">
                                                                    10 р.
                                                                </div>
                                                                <div class="clear"></div>
                                                                <div class="spoiler-head"></div>
                                                                <div class="spoiler-body">
                                                                    <span>Требования для абонентов</span>
                                                                    С каждого успешного платежа МТС взимает с абонента комиссию в размере 10 рублей (в том числе НДС)<br/>Неснижаемый остаток на лицевом счете после совершения оплаты — 10 руб.<br/>Для абонентов Санкт-Петербурга и Ленинградской области — 20 руб.<br/>Максимальное число платежей в сутки: 10 или не более 50 месяц.
                                                                </div>
                                                            </div>
                                                            <div class="item">
                                                                <div class="image">
                                                                    <img src="/img/payment2.jpg" style="margin-top: 1.4rem !important;">
                                                                </div>
                                                                <div class="radios">
                                                                    <label><input type="radio" name="paymentType"> Мобильный телефон МТС</label>
                                                                </div>
                                                                <div class="price">
                                                                    15 р.
                                                                </div>
                                                                <div class="clear"></div>
                                                                <div class="spoiler-head"></div>
                                                                <div class="spoiler-body">
                                                                    <span>Требования для абонентов</span>
                                                                    С каждого успешного платежа МТС взимает с абонента комиссию в размере 10 рублей (в том числе НДС)<br/>Неснижаемый остаток на лицевом счете после совершения оплаты — 10 руб.<br/>Для абонентов Санкт-Петербурга и Ленинградской области — 20 руб.<br/>Максимальное число платежей в сутки: 10 или не более 50 месяц.
                                                                </div>
                                                            </div>
                                                            <div class="item">
                                                                <div class="image">
                                                                    <img src="/img/payment3.jpg" style="margin-top: 1.4rem !important;">
                                                                </div>
                                                                <div class="radios">
                                                                    <label><input type="radio" name="paymentType"> Мобильный телефон Билайн</label>
                                                                </div>
                                                                <div class="price">
                                                                    15 р.
                                                                </div>
                                                                <div class="clear"></div>
                                                                <div class="spoiler-head"></div>
                                                                <div class="spoiler-body">
                                                                    <span>Требования для абонентов</span>
                                                                    С каждого успешного платежа МТС взимает с абонента комиссию в размере 10 рублей (в том числе НДС)<br/>Неснижаемый остаток на лицевом счете после совершения оплаты — 10 руб.<br/>Для абонентов Санкт-Петербурга и Ленинградской области — 20 руб.<br/>Максимальное число платежей в сутки: 10 или не более 50 месяц.
                                                                </div>
                                                            </div>
                                                            <div class="item">
                                                                <div class="image">
                                                                    <img src="/img/payment4.jpg" style="margin-top: .9rem !important;">
                                                                </div>
                                                                <div class="radios">
                                                                    <label><input type="radio" name="paymentType"> Мобильный телефон Мегафон</label>
                                                                </div>
                                                                <div class="price">
                                                                    15 р.
                                                                </div>
                                                                <div class="clear"></div>
                                                                <div class="spoiler-head"></div>
                                                                <div class="spoiler-body">
                                                                    <span>Требования для абонентов</span>
                                                                    С каждого успешного платежа МТС взимает с абонента комиссию в размере 10 рублей (в том числе НДС)<br/>Неснижаемый остаток на лицевом счете после совершения оплаты — 10 руб.<br/>Для абонентов Санкт-Петербурга и Ленинградской области — 20 руб.<br/>Максимальное число платежей в сутки: 10 или не более 50 месяц.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                           
                                        </div>
                                    </div> 
                                `;
                                $('#bottomButtonWrite').text('отправить');
                                $('div.items').addClass('fuelux').html(answerString);
                                $('#items').customScroll();
                            }
                        });
                }

                /*$('body').on('click', '.payment .item', function(){
                    $(this).find('.radios input').click();
                });*/

                $('body').on('keyup', 'textarea#answerText', function() {
                    if (this.value.length > maxMessage) {
                        this.value = this.value.substr(0, maxMessage);
                    }else{
                        let wordCount = $('#answerText').val().length;
                        $('#maxMessage').text(Number(maxMessage) - Number(wordCount));
                    }
                });
                
                $('body').on('click', '#bottomButtonWrite', function(){
                    if(isAnswering){
                        localStorage.setItem('answerText', $('textarea#answerText').val());
                        if($('#myWizard').wizard('selectedItem').step == 1){
                            if(!$('#answerName').length || $('#answerName').val().length > 0){

                                $('#answerName').css('border','1px solid #cecece');

                                if($('#answerText').val().length > 0/* || !$('#answerText').length*/){

                                    $('#answerText').css('border','1px solid #cecece');
                                    if(!$('#messageTel').length || $('#messageTel').val().length > 9){

                                        $('#messageTel').css('border','1px solid #cecece');
                                        if($('#applyRules').is(':checked') === true){
                                            $('#bottomButtonWrite').text('оплатить и отправить сообщение в эфир');
                                            $('#myWizard').wizard('next');
                                            $('.wizard li[data-step="1"]').addClass('active');
                                            $('.spoiler-body').hide();
                                        }else{
                                            $('#applyRules').parents('p').css('border-bottom','1px dashed red');
                                            //$('#items').scrollTo($('#applyRules'));
                                        }

                                    }else{
                                        $('#messageTel').css('border','1px solid red').focus();
                                    }

                                }else{
                                    $('#answerText').css('border','1px solid red').focus();
                                }

                            }else{
                                $('#answerName').css('border','1px solid red').focus();
                            }
                        }else{
                            let name = /*localStorage.getItem('answerName') ? localStorage.getItem('answerName') : */$('#answerName').val() ? $('#answerName').val() : 'Гость',
                                text = /*localStorage.getItem('answerText') ? localStorage.getItem('answerText') : */$('#answerText').val(),
                                tel = /*localStorage.getItem('answerTel') ? localStorage.getItem('answerTel') : */$('#messageTel').val() ? $('#messageTel').val() : '0',
                                result = {
                                    name : name,
                                    messageText : text,
                                    payPhone : tel,
                                    connectPhone : tel,
                                    allowRules : 1,
                                    jsSessionId : getCookie('JSESSIONID'),
                                    messageTo : $('input#answerMessageId[role="var"]') ? $('input#answerMessageId[role="var"]').val() : 0,
                                },
                                cityId = $('input#cityId[role=var]').val(),
                                categoryId = $('input#categoryId[role=var]').val();
                            let csrfToken = $('meta[name="csrf-token"]').attr("content");
                            $.post( "/new/message/"+cityId+"/"+categoryId, {data : JSON.stringify(result), _csrf: csrfToken})
                                .done(function( data ) {
                                    if(data){
                                        localStorage.setItem('name',name);
                                        localStorage.setItem('payPhone',tel);
                                        localStorage.setItem('connectPhone',tel);
                                        //noty({text: '<div class="trayMessage"><p>Сообщение успешно отправлено!</p><p>Оно будет опубликовано сразу после вашей <strong>оплаты</strong>!</p></div>',layout: 'topRight',theme: 'defaultTheme',timeout: 6000,/*killer: false,*/closeWith: ['click'],type: 'success'});
                                        window.location.reload();
                                    }
                                });
                        }   
                    }else if(!isAnswering && $('textarea#answerText').val() === undefined){
                        maxMessage = 300;
                        addNewMessage();
                    }else{
                        //localStorage.setItem('answerName', $('input#answerName').val());
                        //localStorage.setItem('answerTel', $('input#messageTel').val());
                        //localStorage.setItem('answerText', $('textarea#answerText').val());
                        if($('#myWizard').wizard('selectedItem').step == 1){
                            if($('#applyRules').is(':checked') === true){
                                $('#bottomButtonWrite').text('оплатить и отправить сообщение в эфир');
                                $('#myWizard').wizard('next');
                                $('.spoiler-body').hide();
                            }else{
                                $('#applyRules').parents('p').css('border-bottom','1px dashed red');
                                $('#items').scrollTo($('#applyRules'));
                            }
                        }
                    }
                });
                $('body').on('changed.fu.wizard', '#myWizard', function (evt, data) {
                    if($('#myWizard').wizard('selectedItem').step == 1){
                        $('#bottomButtonWrite').text('отправить');
                    }
                });

                $('.modal #newMessageName').val(name);
                $('.modal #newMessagePayPhone').val(payPhone);
                $('.modal #newMessageConnectPhone').val(connectPhone);
            });
            setTimeout(function(){
                chat();
            }, 300);
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

            //setCookie('countryId', $('select#selectCountry').val());
            //setCookie('regionId', $('select#selectRegion').val());
            //setCookie('cityId', $('select#selectCity').val());

            window.location.reload();
        }
    });

}

$('button#sendNewMessageToChat').click(sendNewMessageToChat);

function chat(){
    $('div#items').bind('scroll', onAjaxScroll);
    //$('.modal input#newMessagePayPhone').inputmask("99999999999[9][9][9]");

    $('#efirsNav li').click(function(){
        let uri = $(this).attr('data-tab');
        if(uri.length > 0){
            var cityId = $('input#cityId[role=var]').val();
            var categoryId = $('input#categoryId[role=var]').val();
            window.location = '/' + cityId + '/' + uri;
        }
    });
    
    var cityId = $('input#cityId[role=var]').val();
    var categoryId = $('input#categoryId[role=var]').val();

    if(!isAnswering) {
        getMessages(cityId, categoryId);
    }
}
function onAjaxScroll(e){
    let fromTop = $(this).scrollTop(),
        itemsScroll = $('#items .item').first().height() - 120,
        nowDate = new Date();
    //console.log(fromTop, itemsScroll);
    if(fromTop > itemsScroll &&
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
        let ajaxScroll = getAjaxScroll(cityId, categoryId);
        if(ajaxScroll !== undefined){
            ajaxScroll.then(response => {
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
                                /*if (datetime.getMonth().length == 1) {
                                    var dateString = datetime.getFullYear()
                                        + '-' + (datetime.getMonth() + 1)
                                        + '-' + datetime.getDate();
                                } else {
                                    var dateString = datetime.getFullYear()
                                        + '-0' + (datetime.getMonth() + 1)
                                        + '-' + datetime.getDate();
                                }
                                messageDatetime[0] = messageDatetime[0].replace(dateString, "Сегодня");*/

                                datetime = result[message].post_datetime.split(' ');
                                let date = datetime[0],
                                    day = date.split('-')[2],
                                    monthName = month[date.split('-')[1]],
                                    time = datetime[1].split(':')[0] +':'+ datetime[1].split(':')[1];


                                newMessagesString += `
                                <div class="item" data-id="` + result[message].id + `">
                                    <div class="button">
                                        <button onclick="window.location='/`+$('input#cityId').val()+`/`+$('input#categoryId').val()+`/answer/` + result[message].id + `'">Ответить</button>
                                    </div>
                                    <div class="info">
                                        <div class="content">
                                            <div class="name">
                                                ` + result[message].author_name + `
                                                <span>`+day+` `+monthName+` в `+time+`</span>
                                            </div>
                                            <div class="text">
                                                ` + result[message].message_text + `
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            `;
                                //localStorage.setItem('firsttMessageId',result[message].id);
                            }
                        };
                        $('div#items').append(newMessagesString);
                        setTimeout(function() {
                            //$('div#items').customScroll();
                        }, 200);
                        //$('div#items').scrollTo($('div#items div.item').eq(10), 0);

                        let datetime = new Date();
                        localStorage.setItem('lastAjaxScroll',
                            datetime.getFullYear()
                            +datetime.getDate()
                            +datetime.getDay()
                            +datetime.getHours()
                            +datetime.getMinutes()
                            +datetime.getSeconds());
                        setTimeout(function(){
                            $('#items').bind('scroll', onAjaxScroll);
                        },1000);
                    }
                });
        }
    }
}
function getMessages(cityId, categoryId) {
    if(!isAnswering){
        return new Promise(function(resolve, reject) {
            var lastMessage = localStorage.getItem('lastMessageId') ? localStorage.getItem('lastMessageId') : 0;
            if(lastMessage === undefined || lastMessage == 'undefined'){
                lastMessage = 0;
            }
            var evtSource = new EventSource("/ajax/getMessages/"+cityId+"/"+categoryId+"/"+lastMessage);
            sse = evtSource;
            try{
                evtSource.addEventListener("ping", function(e) {
                    var obj = JSON.parse(e.data);
                    if(obj != '0'){
                        let result = obj;
                        if (result && result !== false && typeof result == 'object') {

                            /*if ($('div#items').text().trim().indexOf("Здесь еще пусто! Напиши сообщение, будь первым!") != -1) {
                             $('div#items').last().html('');
                             }*/

                            let l = $('div#items div.item').length;
                            if(l == 1){
                                $('div#items').html('');
                            }

                            for (let message in result) {
                                let newMessagesString = '';
                                let datetime = new Date(),
                                    messageDatetime = result[message].post_datetime.split(' '),
                                    messageTo = result[message].to,
                                    messageToPhone = result[message].toPhone;
                                /*if (datetime.getMonth().length == 1) {
                                    var dateString = datetime.getFullYear()
                                        + '-' + (datetime.getMonth() + 1)
                                        + '-' + datetime.getDate();
                                } else {
                                    var dateString = datetime.getFullYear()
                                        + '-0' + (datetime.getMonth() + 1)
                                        + '-' + datetime.getDate();
                                }
                                messageDatetime[0] = messageDatetime[0].replace(dateString, "Сегодня");*/

                                datetime = result[message].post_datetime.split(' ');
                                let date = datetime[0],
                                    day = date.split('-')[2],
                                    monthName = month[date.split('-')[1]],
                                    time = datetime[1].split(':')[0] +':'+ datetime[1].split(':')[1];

                                newMessagesString += `
                                <div class="item" data-id="` + result[message].id + `">
                                    <div class="button">
                                        <button onclick="window.location='/`+$('input#cityId').val()+`/`+$('input#categoryId').val()+`/answer/` + result[message].id + `'">Ответить</button>
                                    </div>
                                    <div class="info">
                                        <div class="content">
                                            <div class="name">
                                                ` + result[message].author_name + `
                                                <span>`+day+` `+monthName+` в `+time+`</span>
                                            </div>
                                            <div class="text">
                                                ` + result[message].message_text + `
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            `;

                                localStorage.setItem('lastMessageId', result[message].id);
                                if (isLoaded) {
                                    if (messageTo == getCookie('JSESSIONID') || messageToPhone == localStorage.getItem('connectPhone')) {
                                        /*noty({
                                            text: `<div class="trayMessage">
                                                <h2>Вам ответили!</h2>
                                                <div class="items">
                                                    <div class="item" data-id="181" style="border:none;">
                                                        <div class="info">
                                                            <div class="content">
                                                                <div class="name" style="display: inline-block;">
                                                                    ` + result[message].author_name + `
                                                                </div>
                                                                <div class="text" style="display: inline-block;margin-left: 10px;">
                                                                    ` + result[message].message_text + `
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>`,
                                            layout: 'topRight',
                                            theme: 'defaultTheme',
                                            //timeout: 6000, 
                                            killer: false,
                                            closeWith: ['click'],
                                            type: 'info'
                                        });

                                        $('ul#noty_topRight_layout_container').css({'width': '25vw','top': '8px'});
                                        $('ul#noty_topRight_layout_container li').css({'border-radius': '0px','background': '#fff','width': '100%'});*/
                                    }
                                }
                                $('div#items').prepend(newMessagesString);
                                /*$('#items').emoticonize();*/
                                setTimeout(function() {
                                    //$('div#items').customScroll();
                                    //console.log($('div#items').customScroll());
                                }, 200);
                            }
                            //$('div#items').scrollTo($('div#items div.item').last());
                            isLoaded = true;
                        }
                    }
                }, false);

                evtSource.onopen = function(e) {
                    console.log("Соединение открыто");
                };
                evtSource.onerror = function(e) {
                    throw new Error('Ошибка соединения!');
                    if (this.readyState == EventSource.CONNECTING) {
                        reject(new Error("Соединение порвалось, пересоединяемся..."));
                    } else {
                        reject(new Error("Ошибка, состояние: " + this.readyState));
                    }
                };
                /* xhr.open('GET', "/ajax/getMessages/"+cityId+"/"+categoryId+"/"+lastMessage, true);

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

                 xhr.send();*/
            }catch(e){
                //getMessages(cityId, categoryId);
            }
        });   
    }
}
function getAjaxScroll(cityId, categoryId) {
    if(!isAnswering) {
        return new Promise(function (resolve, reject) {

            var xhr = new XMLHttpRequest(),
                last = $('#items .item').last().attr('data-id');
            
            if(last !== undefined) {

                //console.log(last);
                if (!xhr) {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xhr.open('GET', "/ajax/getAjaxScroll/" + cityId + "/" + categoryId + "/" + last, true);

                xhr.onload = function () {
                    if (this.status == 200) {
                        resolve(this.response);
                    } else {
                        var error = new Error(this.statusText);
                        error.code = this.status;
                        reject(error);
                    }
                };

                xhr.onerror = function () {
                    reject(new Error("Network Error"));
                };

                xhr.send();
            }else{
                reject(new Error("Ошибка! last = undefined!"));
            }
        });
    }
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
            && messageText !== undefined
            && messageText.val() !== undefined
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

function addNewMessage(){
    isAnswering = true;
    let answerString = `
        <div class="wizard" data-initialize="wizard" id="myWizard" style="border:none;">
            <div class="steps-container">
                <ul class="steps message">
                    <li data-step="1" data-name="country"  class="step1 active" style="max-height: 34px;max-width: 253px;border: none;line-height: 2.2rem;margin-right: 0 !important;margin-left: 1rem !important; margin-bottom: 0 !important;">
                        <span>1 шаг</span> Написание сообщения
                    </li>
                    <li data-step="2" data-name="country"  class="step2" style="max-height: 34px;max-width: 243px;border: none;line-height: 2.2rem;margin-right: 0 !important;margin-left: 0 !important; margin-bottom: 0 !important;">
                        <span>2 шаг</span> Выбор способа оплаты
                    </li>
                </ul>
            </div>
            <div class="step-content" style="width:auto;float:none;padding:0;border:none;">
                <div class="step-pane active sample-pane alert" data-step="1">
                    <div class="message" style="padding-top: 0!important;">
                        <form>
                            <input type="text" id="answerName" placeholder="Ваше имя" style="margin-bottom: 1.5rem" required><br>
                            <div class="left nom">Текст сообщения</div>
                            <div class="right nom">Осталось <span id="maxMessage">`+maxMessage+`</span> символов</div>
                            <div class="clear"></div>
                            <textarea id="answerText"></textarea>
                            <br>
                            +7 &nbsp; <input type="text" id="messageTel" placeholder="953-423-42-34">
                            <div class="phone-text">Номер мобильного для получения SMS-ответов<br>на ваше сообщение</div>
                            <div class="bottom-text">
                                <p>ВНИМАНИЕ! Мы никому не показываем ваш номер телефона. На этот номер телефона будут приходить SMS с ответами на ваше сообщение опубликованное эфире.</p>
                                <p><label><input type="checkbox" id="applyRules"> Я ознакомился и согласен с правилами и условиями использования данного сервиса.</label></p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="step-pane sample-pane sample-pane alert" data-step="2">
                    <div class="message" style="padding-top:0 !important;">
                            <div class="payment">
                                <p>Выберите способ оплаты</p>
                                <div class="item">
                                    <div class="image">
                                        <img src="/img/payment1.jpg" style="margin-top: 1.4rem !important;">
                                    </div>
                                    <div class="radios">
                                        <label><input type="radio" name="paymentType"> Банковская карта</label>
                                    </div>
                                    <div class="price">
                                        10 р.
                                    </div>
                                    <div class="clear"></div>
                                    <div class="spoiler-head"></div>
                                    <div class="spoiler-body">
                                        <span>Требования для абонентов</span>
                                        С каждого успешного платежа МТС взимает с абонента комиссию в размере 10 рублей (в том числе НДС)<br/>Неснижаемый остаток на лицевом счете после совершения оплаты — 10 руб.<br/>Для абонентов Санкт-Петербурга и Ленинградской области — 20 руб.<br/>Максимальное число платежей в сутки: 10 или не более 50 месяц.
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="image">
                                        <img src="/img/payment2.jpg" style="margin-top: 1.4rem !important;">
                                    </div>
                                    <div class="radios">
                                        <label><input type="radio" name="paymentType"> Мобильный телефон МТС</label>
                                    </div>
                                    <div class="price">
                                        15 р.
                                    </div>
                                    <div class="clear"></div>
                                    <div class="spoiler-head"></div>
                                    <div class="spoiler-body">
                                        <span>Требования для абонентов</span>
                                        С каждого успешного платежа МТС взимает с абонента комиссию в размере 10 рублей (в том числе НДС)<br/>Неснижаемый остаток на лицевом счете после совершения оплаты — 10 руб.<br/>Для абонентов Санкт-Петербурга и Ленинградской области — 20 руб.<br/>Максимальное число платежей в сутки: 10 или не более 50 месяц.
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="image">
                                        <img src="/img/payment3.jpg" style="margin-top: 1.4rem !important;">
                                    </div>
                                    <div class="radios">
                                        <label><input type="radio" name="paymentType"> Мобильный телефон Билайн</label>
                                    </div>
                                    <div class="price">
                                        15 р.
                                    </div>
                                    <div class="clear"></div>
                                    <div class="spoiler-head"></div>
                                    <div class="spoiler-body">
                                        <span>Требования для абонентов</span>
                                        С каждого успешного платежа МТС взимает с абонента комиссию в размере 10 рублей (в том числе НДС)<br/>Неснижаемый остаток на лицевом счете после совершения оплаты — 10 руб.<br/>Для абонентов Санкт-Петербурга и Ленинградской области — 20 руб.<br/>Максимальное число платежей в сутки: 10 или не более 50 месяц.
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="image">
                                        <img src="/img/payment4.jpg" style="margin-top: .9rem !important;">
                                    </div>
                                    <div class="radios">
                                        <label><input type="radio" name="paymentType"> Мобильный телефон Мегафон</label>
                                    </div>
                                    <div class="price">
                                        15 р.
                                    </div>
                                    <div class="clear"></div>
                                    <div class="spoiler-head"></div>
                                    <div class="spoiler-body">
                                        <span>Требования для абонентов</span>
                                        С каждого успешного платежа МТС взимает с абонента комиссию в размере 10 рублей (в том числе НДС)<br/>Неснижаемый остаток на лицевом счете после совершения оплаты — 10 руб.<br/>Для абонентов Санкт-Петербурга и Ленинградской области — 20 руб.<br/>Максимальное число платежей в сутки: 10 или не более 50 месяц.
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
               
            </div>
        </div> 
    `;
    $('#bottomButtonWrite').text('отправить');
    $('div.items').addClass('fuelux').html(answerString);
    //$('#items').customScroll();
}

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

$('body').on('click', 'a.regionsLinks', function(){
    $('.popup .selects').fadeOut(1);
    $('div#selectedRegion').text($(this).text());
    localStorage.setItem('selectedRegion', $(this).attr('data-id'));
    let csrfToken = $('meta[name="csrf-token"]').attr("content");
    $.post( "/get/all/cities", { regionId: $(this).attr('data-id'), _csrf: csrfToken })
        .done(function( data ) {
            if(data && data.length > 0){
                var dat = JSON.parse(data),
                    //options = '<option value="-1">...</option>';
                    options = '';
                for(var option in dat){
                    if(dat[option].city_id && dat[option].name){
                        options += '<a class="citiesLinks" data-id="' + dat[option].city_id + '">' +dat[option].name+ '</a>';
                    }
                }
                if(options.length > 0) {
                    $('div.sss#selects2').css('padding-left','20px').html(options);
                    $('div#selectedCity').removeClass('disabled');
                }

                if(!$('#selects2').hasClass('custom-scroll_container')) {
                    setTimeout(function () {
                        $('#selects2').customScroll();
                    }, 200);
                }else{
                    $('#selects2').removeClass('custom-scroll_container');
                    setTimeout(function(){
                        $('#selects2').customScroll();
                    }, 200);
                }
            }
        });
});

$('body').on('click', 'a.citiesLinks', function(){
    $('.popup .selects').fadeOut(1);
    $('div#selectedCity').text($(this).text());
    localStorage.setItem('selectedCity', $(this).attr('data-id'));
    if($('button#goToChatButton').css('display') == 'none'){
        let region = localStorage.getItem('selectedRegion'),
            city = localStorage.getItem('selectedCity');
        if(region && city){
            window.location = '/' + city + '/1';
            //setCookie('countryId',1);
            //setCookie('regionId', region);
            //setCookie('cityId', city);
        }
    }
    $(this).parents('.popup').find('button#goToChatButton').removeAttr('disabled');
});

$('body').on('click', 'button#goToChatButton', function(){
    let region = localStorage.getItem('selectedRegion'),
        city = localStorage.getItem('selectedCity');
    if(region && city){
        window.location = '/' + city + '/1';
        //setCookie('countryId',1);
        //setCookie('regionId', region);
        //setCookie('cityId', city);
    }
});

$('body').on('click', 'nav#staticPages li', function(){
    let url = $(this).attr('data-url');
    if(url && url.length > 0){
        $.post('/' + url)
            .done(function(data){
                if(data){
                    console.log(data);
                }
            });
    }
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
        d.setTime(d.getTime() + expires * 100000);
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