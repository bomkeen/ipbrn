<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "m_list".
 *
 * @property string $m_num
 * @property string $m_name
 */
class MList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_num'], 'string', 'max' => 11],
            [['m_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'm_num' => 'M Num',
            'm_name' => 'M Name',
        ];
    }
}
