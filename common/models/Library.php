<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "library".
 *
 * @property integer $id
 * @property string $name
 * @property string $art
 * @property string $genre
 * @property integer $year
 * @property integer $count_all
 * @property integer $count_taken
 * @property integer $prce_for_sale
 * @property integer $prce_for_take
 * @property integer $q_taken
 * @property integer $q_bought
 * @property integer $q_viewed
 *
 * @property Actions[] $actions
 * @property Taken[] $takens
 */
class Library extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'library';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'prce_for_sale', 'prce_for_take'], 'required'],
            [['year', 'count_all', 'count_taken', 'prce_for_sale', 'prce_for_take', 'q_taken', 'q_bought', 'q_viewed'], 'integer'],
            [['name', 'art', 'genre'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'genre' => 'Жанр',
            'year' => 'Год',
            'count_all' => 'В наличии всего',
            'count_taken' => 'На руках',
            'prce_for_sale' => 'Цена покупки, руб',
            'prce_for_take' => 'Цена проката, руб',
            'q_taken' => 'Взято в прокат',
            'q_bought' => 'Куплено',
            'q_viewed' => 'Просмотрено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActions()
    {
        return $this->hasMany(Actions::className(), ['film_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTakens()
    {
        return $this->hasMany(Taken::className(), ['film_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoughts()
    {
        return $this->hasMany(Bought::className(), ['film_id' => 'id']);
    }

    static function getLibrariesList()
    {
        return ['Во все тяжкие'];
    }

}
