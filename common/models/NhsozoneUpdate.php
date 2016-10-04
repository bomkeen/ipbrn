<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nhsozone_update".
 *
 * @property string $NHSO_ZONE
 * @property string $NHSO_ZONENAME
 * @property string $PROVINCE_ID
 * @property string $PROVINCE_NAME
 */
class NhsozoneUpdate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nhsozone_update';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NHSO_ZONE', 'NHSO_ZONENAME', 'PROVINCE_ID', 'PROVINCE_NAME'], 'string', 'max' => 255],
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
        ];
    }
}
