<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_address".
 *
 * @property int $id
 * @property int $client_id
 * @property string $city
 * @property string $street
 * @property string $number
 *
 * @property Clients $client
 */
class ClientAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'city', 'street', 'number'], 'required'],
            [['client_id'], 'integer'],
            [['city', 'street', 'number'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'city' => 'City',
            'street' => 'Street',
            'number' => 'Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }
}
