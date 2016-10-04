<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hospital".
 *
 * @property string $HOSPCODE
 * @property string $HOSPNAME
 * @property string $HOSPTYPE
 * @property string $PROVINCE
 */
class Hospital extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hospital';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['HOSPCODE'], 'required'],
            [['HOSPCODE'], 'string', 'max' => 6],
            [['HOSPNAME'], 'string', 'max' => 50],
            [['HOSPTYPE', 'PROVINCE'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'HOSPCODE' => 'Hospcode',
            'HOSPNAME' => 'Hospname',
            'HOSPTYPE' => 'Hosptype',
            'PROVINCE' => 'Province',
        ];
    }
}
