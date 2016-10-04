<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subtype".
 *
 * @property integer $SUBTYPE
 * @property string $SUBTYPEDESCR
 */
class Subtype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SUBTYPE'], 'integer'],
            [['SUBTYPEDESCR'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SUBTYPE' => 'Subtype',
            'SUBTYPEDESCR' => 'Subtypedescr',
        ];
    }
}
