<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tmp_s".
 *
 * @property integer $cid
 * @property string $fname
 * @property string $lname
 */
class TmpS extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tmp_s';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['cid'], 'required'],
            [['cid'], 'string', 'min' => 13,'max'=>13, 'tooShort' => 'กรอกเลขบัตรประชาชนให้ครบ 13 หลักครับผมมม'],
            [['fname', 'lname'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'year' => 'year',
            'm1' => 'm1',
            'm2' => 'm2',
        ];
    }
}
