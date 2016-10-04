<?php

namespace common\models;

use Yii;
class Reply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QuestionID', 'CreateDate', 'Details', 'Name'], 'required'],
            [['QuestionID'], 'integer'],
            [['CreateDate'], 'safe'],
            [['Details'], 'string'],
            [['Name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ReplyID' => 'Reply ID',
            'QuestionID' => 'Question ID',
            'CreateDate' => 'Create Date',
            'Details' => 'รายละเอียด',
            'Name' => 'ชื่อผู้แสดงความคิดเห็น',
        ];
    }
}
