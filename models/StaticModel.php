<?php

namespace app\models;


class StaticModel
{
    private $db;

    public function __construct()
    {
        $this->db = \Yii::$app->db;
    }
    
    public function getStaticPage($page_name){
        if(!empty($page_name)){
            try{
                $sql = "
                    SELECT
                    *
                    FROM workslimfr.static s 
                    WHERE s.page_name = '{$page_name}'
                    LIMIT 1
                ";
                $result = $this->db->createCommand($sql)->queryAll();
                if(!$result){
                    throw new \Exception(0);
                }else{
                    return $result[0];
                }
            }catch (\Exception $e){
                return $e->getMessage();
            }
        }
    }
    
    
}