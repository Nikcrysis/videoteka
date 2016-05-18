<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Library;

/**
 * This is the model class for table "actions".
 *
 * @property integer $id
 * @property string $type
 * @property integer $film_id
 * @property integer $user_id
 * @property integer $date
 *
 * @property User $user
 * @property Library $film
 */
class Actions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'actions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'film_id', 'date'], 'required'],
            [['film_id', 'user_id', 'date'], 'integer'],
            [['type'], 'string', 'max' => 100],
            /*[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],*/
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
            'type' => 'Тип',
            'film_id' => 'Фильм',
            'user_id' => 'Пользователь',
            'date' => 'Дата',
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
