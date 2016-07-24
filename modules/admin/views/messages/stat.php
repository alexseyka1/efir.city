<style>
    html, body {
        font-family: Arial;
    }
    .panel-body {
        padding: 0;
    }
</style>
<?php
$texts = [
    'city_id' => '#',
    'name' => 'Город',
    'messages_day' => 'Сегодня',
    'messages_yesterday' => 'Вчера',
    'messages_week' => 'За неделю',
    'messages_month' => 'За месяц'
];
    if(!empty($q)){
        $region_id = 0;
        $region_name = '';
        foreach ($q as $cities){
            if(!empty($cities)){
                $region_id = $cities[0]['region_id'];
                $region_name = $cities[0]['region_name'];
                echo '
                    <div class="panel panel-default">
                    <div class="panel-heading" data-toggle="collapse" href="#'.$region_id.'" aria-expanded="false" aria-controls="'.$region_id.'">
                        <div class="row"><div class="col-md-1">#'.$region_id.'</div><div class="col-md-11">'.$region_name.'</div></div>
                    </div>
                    <div class="panel-body collapse" id="'.$region_id.'">
                        <table class="table table-striped table-hover">
                            <thead class="colored">
                ';
                foreach ($cities as $city){
                    echo "<tr>";
                    foreach ($city as $k => $v){
                        if(!in_array($k,['region_id','region_name','messages_all'])) {
                            echo "<td>{$texts[$k]}</td>";
                        }
                    }
                    echo "</tr>";
                    break;
                }
                echo "</thead><tbody>";
                foreach ($cities as $city){
                    echo "<tr>";
                    foreach ($city as $k => $v) {
                        if(!in_array($k,['region_id','region_name','messages_all'])) {
                            echo "<td>{$v}</td>";
                        }
                    }
                    echo "</tr>";
                }
                echo "</tbody></table></div>";

                echo '
                    </div>
                ';
            }
        }
    }
?>
