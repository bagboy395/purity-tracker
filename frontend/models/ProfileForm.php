<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;

class ProfileForm extends Model
{
    public $username;
    public $email;

    private $_user;

    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;

        $this->username = $user->username;
        $this->email = $user->email;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'required'],

            ['username', 'string', 'min' => 3, 'max' => 255],

            ['email', 'email'],

            [
                'username',
                'unique',
                'targetClass' => User::class,
                'targetAttribute' => 'username',
                'filter' => function ($query) {
                    $query->andWhere(['<>', 'id', $this->_user->id]);
                },
                'message' => 'This username is already taken.',
            ],

            [
                'email',
                'unique',
                'targetClass' => User::class,
                'targetAttribute' => 'email',
                'filter' => function ($query) {
                    $query->andWhere(['<>', 'id', $this->_user->id]);
                },
                'message' => 'This email address is already in use.',
            ],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_user->username = $this->username;
        $this->_user->email = $this->email;

        return $this->_user->save(false);
    }
}