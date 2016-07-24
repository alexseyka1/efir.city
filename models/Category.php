<?php

namespace app\models;


class Category
{

private $db;
    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->db = \Yii::$app->db;
    }

    public function getCountry() {
        try {
            $sql = "
                SELECT
                  *
                FROM country c
                ORDER BY c.country_name
            ";
            $result = $this->db->createCommand($sql)->queryAll();
            if(!$result){
                throw new \Exception('Не удалось выполнить выборку стран');
            }else{
                return $result;
            }
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }

    public function getRegion($countryId) {
        if(preg_match_all('/^\d+$/',$countryId)){
            try {
                $sql = "
                    SELECT
                      *
                    FROM workslimfr.region r
                    WHERE r.country_id = '{$countryId}'
                    AND r.active = 1
                ";
                $result = $this->db->createCommand($sql)->queryAll();
                if (!$result) {
                    throw new \Exception('Не удалось выполнить выборку регионов');
                } else {
                    return $result;
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }else{
            return $countryId;
        }
    }

    public function getCities($regionId) {
        if(preg_match_all('/^\d+$/',$regionId)){
            try {
                $sql = "
                    SELECT
                      *
                    FROM workslimfr.city c
                    WHERE c.region_id = '{$regionId}'
                    AND c.active = 1
                ";
                $result = $this->db->createCommand($sql)->queryAll();
                if (!$result) {
                    throw new \Exception('Не удалось выполнить выборку регионов');
                } else {
                    return $result;
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }else{
            return $regionId;
        }
    }

    public function getCategoryByCity($cityId) {
        if(preg_match_all('/^\d+$/',$cityId)){
            try {
                $sql = "
                    SELECT
                      *
                    FROM workslimfr.category c
                    WHERE c.city_id = '{$cityId}'
                    AND c.active = 1
                    ORDER BY c.sort
                ";
                $result = $this->db->createCommand($sql)->queryAll();
                if (!$result) {
                    $sql = "
                        SELECT
                          *
                        FROM workslimfr.category_default c
                        WHERE c.active = 1
                        ORDER BY c.sort
                    ";
                    $result = $this->db->createCommand($sql)->queryAll();
                    if(!$result) {
                        throw new \Exception('Не удалось выполнить выборку категорий');
                    }else{
                        return $result;
                    }
                } else {
                    return $result;
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }else{
            return $cityId;
        }
    }
    
    public function getInfoFromCity($cityId) {
        if(preg_match_all('/^\d+$/',$cityId)){
            try {
                $sql = "
                    SELECT
                        co.country_name,
                        r.name as region_name,
                        c.name as city_name
                    FROM workslimfr.city c
                    LEFT JOIN workslimfr.region r ON c.region_id = r.region_id
                    LEFT JOIN workslimfr.country co ON c.country_id = co.country_id
                    WHERE c.city_id = {$cityId}
                    LIMIT 1
                ";
                $result = $this->db->createCommand($sql)->queryAll();
                if (!$result) {
                    throw new \Exception('Не удалось выполнить выборку категорий');
                } else {
                    return $result[0];
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }else{
            return $cityId;
        }
    }
    
    public function getSiteSettings() {
        try {
            $sql = "
                    SELECT
                        *
                    FROM workslimfr.site_settings
                ";
            $result = $this->db->createCommand($sql)->queryAll();
            if (!$result) {
                throw new \Exception('Не удалось выполнить выборку настроек');
            } else {
                return $result;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getSeoPage($uri){
        try {
            $sql = "
                    SELECT
                        *
                    FROM workslimfr.seo
                    WHERE url = '{$uri}'
                    LIMIT 1
                ";
            $result = $this->db->createCommand($sql)->queryAll();
            if (!$result) {
                throw new \Exception(0);
            } else {
                return $result[0];
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function getCategoryInfo($cityId, $categoryId){
        if(preg_match_all('/^\d+$/',$cityId) && preg_match_all('/^\d+$/',$categoryId)) {
            try {
                $sql = "
                        SELECT
                            *
                        FROM workslimfr.category c
                        WHERE c.city_id = {$cityId}
                        AND c.sort = {$categoryId}
                        LIMIT 1
                    ";
                $result = $this->db->createCommand($sql)->queryAll();
                if (!$result) {
                    $sql = "
                        SELECT
                            *
                        FROM workslimfr.category_default cd
                        WHERE cd.sort = {$categoryId}
                        LIMIT 1
                    ";
                    $result = $this->db->createCommand($sql)->queryAll();
                    if(!$result) {
                        throw new \Exception(0);
                    }else{
                        return $result[0];
                    }
                } else {
                    return $result[0];
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }else{
            return $cityId;
        }
    }
    
    public function getNewMessages($cityId, $categoryId, $lastMessageId)
    {
        if (preg_match_all('/^\d+$/', $cityId) && preg_match_all('/^\d+$/', $categoryId) && preg_match_all('/^\d+$/', $lastMessageId)) {
            try {
                $sql = "SELECT
                          *
                        FROM (
                            SELECT
                                m.id,
                                m.author_name,
                                m.author_uid,
                                m.message_text,
                                m.post_datetime,
                                (
                                  SELECT
                                    m2.author_uid
                                  FROM messages m2
                                  WHERE m2.id = m.message_to
                                  LIMIT 1
                                ) as `to`,
                                (
                                  SELECT
                                    m2.connect_phone
                                  FROM messages m2
                                  WHERE m2.id = m.message_to
                                  LIMIT 1
                                ) as `toPhone`
                            FROM workslimfr.messages m
                            WHERE m.id > {$lastMessageId}
                            AND m.is_paid = 1
                            AND m.city_id = {$cityId}
                            AND m.category_id = {$categoryId}
                            ORDER BY id DESC
                            LIMIT 10
                        ) a
                        ORDER BY a.id asc
                    ";
                $result = $this->db->createCommand($sql)->queryAll();
                if (!$result) {
                    throw new \Exception(0);
                } else {
                    return $result;
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function getPrevMessages($cityId, $categoryId, $firstMessageId){
            if (preg_match_all('/^\d+$/', $cityId) && preg_match_all('/^\d+$/', $categoryId) && preg_match_all('/^\d+$/', $firstMessageId)) {
                try {
                    $sql = "
                            SELECT * FROM (
                                SELECT * FROM (
                                    SELECT
                                        m.id,
                                        m.author_name,
                                        m.author_uid,
                                        m.message_text,
                                        m.post_datetime 
                                    FROM messages m
                                    WHERE id < {$firstMessageId}
                                    AND m.is_paid = 1
                                    AND m.city_id = {$cityId}
                                    AND m.category_id = {$categoryId}
                                    ORDER BY id asc
                                ) a
                                ORDER BY a.id desc
                                LIMIT 10
                            ) b
                            ORDER BY b.id asc
                        ";
                    $result = $this->db->createCommand($sql)->queryAll();
                    if (!$result) {
                        throw new \Exception(0);
                    } else {
                        return $result;
                    }
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }
        }

    public function addNewMessage($cityId, $categoryId, $data) {
        $dataObj = json_decode($data);
        if (preg_match_all('/^\d+$/', $cityId) && preg_match_all('/^\d+$/', $categoryId) && is_object($dataObj)) {
            try{
                $datetime = date('Y.m.d H:i:s');
                $result = $this->db->createCommand()->insert('messages', [
                    'post_datetime' => $datetime,
                    'author_name' => $dataObj->name,
                    'author_uid' => $dataObj->jsSessionId,
                    'message_to' => !empty($dataObj->messageTo) ? $dataObj->messageTo : null,
                    'message_text' => $dataObj->messageText,
                    'city_id' => $cityId,
                    'category_id' => $categoryId,
                    'pay_phone' => $dataObj->payPhone,
                    'connect_phone' => $dataObj->connectPhone,
                    'is_paid' => 1,
                    'is_published' => 1,
                ])->execute();
                if(!$result){
                    throw new \Exception(0);
                }else{
                    return $result;
                }
            }catch (\Exception $e){
                return $e->getMessage();
            }
        }
    }
    
}