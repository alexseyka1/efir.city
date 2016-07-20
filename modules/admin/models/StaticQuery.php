<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[Statics]].
 *
 * @see Statics
 */
class StaticQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Statics[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Statics|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
