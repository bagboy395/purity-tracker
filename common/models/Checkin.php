<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "checkins".
 *
 * @property int $id
 * @property int $user_id
 * @property string $checkin_date
 * @property int $created_at
 */
class Checkin extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'checkins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'checkin_date', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['checkin_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'checkin_date' => 'Checkin Date',
            'created_at' => 'Created At',
        ];
    }

}
