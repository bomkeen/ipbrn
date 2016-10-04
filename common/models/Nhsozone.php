<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nhsozone".
 *
 * @property string $NHSO_ZONE
 * @property string $NHSO_ZONENAME
 * @property string $PROVINCE_ID
 * @property string $PROVINCE_NAME
 * @property string $HCODE
 */
class Nhsozone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nhsozone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NHSO_ZONE', 'NHSO_ZONENAME', 'PROVINCE_ID', 'PROVINCE_NAME', 'HCODE'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NHSO_ZONE' => 'Nhso  Zone',
            'NHSO_ZONENAME' => 'Nhso  Zonename',
            'PROVINCE_ID' => 'Province  ID',
            'PROVINCE_NAME' => 'Province  Name',
            'HCODE' => 'Hcode',
        ];
    }
}
