<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class ChangePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    private $_user;

    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'confirmPassword'], 'required'],

            [
                'currentPassword',
                'validateCurrentPassword',
            ],

            [
                'newPassword',
                'string',
                'min' => Yii::$app->params['user.passwordMinLength'],
            ],

            [
                'confirmPassword',
                'compare',
                'compareAttribute' => 'newPassword',
                'message' => 'Passwords do not match.',
            ],

            [
                'newPassword',
                'compare',
                'compareAttribute' => 'currentPassword',
                'operator' => '!=',
                'message' => 'Your new password must be different from your current password.',
            ],
        ];
    }

    public function validateCurrentPassword($attribute)
    {
        if ($this->hasErrors()) {
            return;
        }

        if (!$this->_user->validatePassword($this->currentPassword)) {
            $this->addError(
                $attribute,
                'Your current password is incorrect.'
            );
        }
    }

    public function changePassword()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_user->setPassword($this->newPassword);
        $this->_user->generateAuthKey();

        return $this->_user->save(false);
    }
}