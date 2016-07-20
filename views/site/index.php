<?php

/* @var $this yii\web\View */

$this->title = 'Efir.cityt';
?>

<div class="wizard" data-initialize="wizard" id="myWizard">
    <div class="steps-container">
        <ul class="steps">
            <li data-step="1" data-name="country" class="active">
                <span class="badge">1</span>Выберите страну
                <span class="chevron"></span>
            </li>
            <li data-step="2" data-name="region">
                <span class="badge">2</span>Теперь регион
                <span class="chevron"></span>
            </li>
            <li data-step="3" data-name="city">
                <span class="badge">3</span>И остался только город
                <span class="chevron"></span>
            </li>
        </ul>
    </div>
    <div class="step-content">
        <div class="step-pane active sample-pane alert" data-step="1">
            <h2>Добро пожаловать!</h2>
            <p style="font-size: 1.5em; margin-bottom: 30px;">Для того чтобы начать общение выберите вашу страну:</p>
            <p>
                <select id="selectCountry" class="form-control">
                    <option value="-1">...</option>
                    <?php if(!empty($allCountries)){ foreach($allCountries as $country){ ?>
                        <option value="<?=$country['country_id'];?>"><?=$country['country_name'];?></option>
                    <? }} ?>
                </select>
            </p>
        </div>
        <div class="step-pane sample-pane sample-pane alert" data-step="2">
            <h2>Теперь выберите ваш регион из доступных ниже:</h2>
            <p>
                <select id="selectRegion" class="form-control">
                    <option value="-1">...</option>
                </select>
            </p>
        </div>
        <div class="step-pane sample-pane sample-pane alert" data-step="3">
            <h2>Вы всего в одном шаге от веселого общения!</h2>
            <p>
                <select id="selectCity" class="form-control" style="margin-bottom: 40px;">
                    <option value="-1">...</option>
                </select>
                <button class="btn btn-primary btn-lg btn-block" id="goChat" style="display: none;">Начать!</button>
            </p>
        </div>
    </div>


</div>