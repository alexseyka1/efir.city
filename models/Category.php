<?php

namespace app\models;


use yii\base\Exception;

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
                        c.name as city_name,
                        c.weather as weather
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
                    WHERE url = :uri
                    OR rus_url = :url
                    LIMIT 1
                ";
            $result = $this->db->createCommand($sql)
                ->bindValues([':uri' => $uri, ':url' => urldecode($uri)])
                ->queryAll();
            if (!$result) {
                throw new \Exception(null);
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
                        AND c.active = 1
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
                    if(empty($dataObj->messageTo) || $dataObj->messageTo == 0){
                        return $result;
                    }else{
                        $msgNumber = $this->db->createCommand()
                            ->select('connect_phone')
                            ->from('messages')
                            ->where('id = :id')
                            ->bindValues([':id' => $dataObj->messageTo])
                            ->queryScalar();

                        if(!empty($msgNumber)){
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL , 'https://gate.smsaero.ru/send');
                            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.6 (KHTML, like Gecko) Chrome/16.0.897.0 Safari/535.6');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt_array($ch, [
                                'user' => 'work.slimfreelance@gmail.com',
                                'password' => 'Pe0POlgeoPPK7H03fiPpSzzPGQdV',
                                'to' => $msgNumber,
                                'text' => $dataObj->messageText,
                                    'from' => 'Efir city',
                                'answer' => 'json',
                            ]);
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                            $result = curl_exec($ch);
                            curl_close($ch);
                            $res = json_decode($result);
                            //if(!empty($res) && $res->result == 'accepted'){
                                return 1;
                            //}
                        }
                    }
                }
            }catch (\Exception $e){
                return $e->getMessage();
            }
        }
    }

    public function getCityFromSeo($city)
    {
        try {
            if (!empty($city) && preg_match('/^[A-Za-zА-Яа-яЁё]+$/u', $city)) {
                $sql = "
                    SELECT
                        city_id
                    FROM workslimfr.city s 
                    WHERE s.name = :url
                    AND s.active = 1
                    LIMIT 1
                ";
                $result = $this->db->createCommand($sql)
                    ->bindValues([':url' => $city])
                    ->queryScalar();
                if(!$result){
                    $sql = "
                        SELECT
                            city_id
                        FROM workslimfr.city s 
                        WHERE s.name LIKE (:like)
                        AND s.active = 1
                        LIMIT 1
                    ";
                    $result = $this->db->createCommand($sql)
                        ->bindValues([':like' => "%{$city}%"])
                        ->queryScalar();
                    if(!$result){
                        throw new \Exception('Не удалось найти id города');
                    }else{
                        return $result;
                    }
                }else{
                    return $result;
                }
            } else {
                throw new \Exception('Не удалось найти id города');
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    public function getUrlBySeo($url)
    {
        try{
            if(!empty($url) && preg_match('/^[A-Za-zА-Яа-яЁё_-]+\/[A-Za-zА-Яа-яЁё_-]+$/u', $url)){
                $sql = "
                    SELECT
                        url
                    FROM workslimfr.seo s 
                    WHERE s.rus_url = :url
                    LIMIT 1
                ";
                $result = $this->db->createCommand($sql)
                    ->bindValues([':url' => "/" . $url])
                    ->queryScalar();
                if(!$result){
                    throw new \Exception('Не удалось найти url по ЧПУ');
                }else{
                    return $result;
                }
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    
    public function getMessageInfo($messageId){
        if(preg_match_all('/^\d+$/',$messageId)){
            try{
                $sql = "
                    SELECT
                        *
                    FROM workslimfr.messages m
                    WHERE m.id = :messageId
                ";
                $result = $this->db->createCommand($sql)
                    ->bindValues([':messageId' => $messageId])
                    ->queryOne();
                if(!$result){
                    throw new \Exception('Не удалось найти сообщение!');
                }else{
                    return $result;
                }
            }catch (\Exception $e){
                return $e->getMessage();
            }
        }else{
            return false;
        }
    }

    public static function renderAllCities(){
        $cities = [
            'Москва',
            'Краснодар',
            'Ростов-на-Дону',
            'Санкт-Петербург',
            'Красноярск',
            'Рязань',
            'Астрахань',
            'Липецк',
            'Самара',
            'Барнаул',
            'Махачкала',
            'Саратов',
            'Владивосток',
            'Набережные Челны',
            'Тольятти',
            'Волгоград',
            'Нижний Новгород',
            'Томск',
            'Воронеж',
            'Новокузнецк',
            'Тюмень',
            'Екатеринбург',
            'Новосибирск',
            'Ульяновск',
            'Ижевск',
            'Омск',
            'Уфа',
            'Иркутск',
            'Оренбург',
            'Хабаровск',
            'Казань',
            'Пенза',
            'Челябинск',
            'Кемерово',
            'Пермь',
            'Ярославль',
        ];
        try{
            $allCities = (new \yii\db\Query())
                ->select('*')
                ->from('city')
                ->where(['active' => 1])
                ->limit(30)
                ->all();
            if(!$allCities){
                throw new \Exception('Не удалось вывести все города!');
            }else{
                /*foreach ($allCities as $allCity) {
                    echo '<div class="item" onclick="window.location=\'/'.$allCity['city_id'].'\'">'.$allCity['name'].'</div>';
                }*/
                foreach ($cities as $city) {
                    echo '<div class="item">'.$city.'</div>';
                }
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }


}