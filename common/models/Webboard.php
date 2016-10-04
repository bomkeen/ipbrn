<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "webboard".
 *
 * @property string $QuestionID
 * @property string $CreateDate
 * @property string $Question
 * @property string $Details
 * @property string $Name
 * @property integer $View
 * @property integer $Reply
 */
class Webboard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'webboard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CreateDate', 'Question', 'Details', 'Name'], 'required'],
            [['CreateDate'], 'safe'],
            [['Details'], 'string'],
            [['View', 'Reply'], 'integer'],
            [['Question'], 'string', 'max' => 255],
            [['Name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'QuestionID' => 'Question ID',
            'CreateDate' => 'วันที่สร้างข้อมูล',
            'Question' => 'หัวข้อคำถาม',
            'Details' => 'รายละเอียด',
            'Name' => 'ชื่อผู้ตั้คำถาม',
            'View' => 'View',
            'Reply' => 'Reply',
        ];
    }
}
