<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[Categorydefault]].
 *
 * @see Categorydefault
 */
class CategorydefaultQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Categorydefault[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Categorydefault|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
