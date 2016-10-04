<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fundlist".
 *
 * @property string $fundcode
 * @property string $fundname
 */
class Fundlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fundlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fundcode', 'fundname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fundcode' => 'Fundcode',
            'fundname' => 'Fundname',
        ];
    }
}
