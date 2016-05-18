<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Library;

/**
 * This is the model class for table "taken".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $film_id
 * @property integer $return_before
 *
 * @property User $user
 * @property Library $film
 */
class Taken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'taken';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'film_id', 'return_before'], 'required'],
            [['user_id', 'film_id', 'return_before'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['film_id'], 'exist', 'skipOnError' => true, 'targetClass' => Library::className(), 'targetAttribute' => ['film_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'film_id' => 'Film ID',
            'return_before' => 'Return Before',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilm()
    {
        return $this->hasOne(Library::className(), ['id' => 'film_id']);
    }
}
