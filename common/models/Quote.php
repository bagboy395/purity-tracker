<?php

namespace common\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "quotes".
 *
 * @property int $id
 * @property string $quote
 * @property string $author
 * @property int|null $is_active
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Quote extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quotes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['is_active'], 'default', 'value' => 1],
            [['quote', 'author'], 'required'],
            [['quote'], 'string'],
            [['is_active', 'created_at', 'updated_at'], 'integer'],
            [['author'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quote' => 'Quote',
            'author' => 'Author',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public static function getRandomActiveQuote() 
    {
        // Look for quotes that are active,
        // shuffle them randomly,
        // then return just one quote.
        Quote::find()
        -> where(['is_active'=>1])
        ->orderBy(new Expression('RAND()'))
        ->one();


    }
}
