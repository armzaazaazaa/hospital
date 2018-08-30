<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "send".
 *
 * @property int $id
 * @property int $id_doctor
 * @property int $id_patient
 * @property string $date
 * @property int $id_doctor_ receive
 */
class Send extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'send';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_doctor', 'id_patient', 'date', 'id_doctor_ receive'], 'required'],
            [['id_doctor', 'id_patient', 'id_doctor_ receive'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_doctor' => 'Id Doctor',
            'id_patient' => 'Id Patient',
            'date' => 'Date',
            'id_doctor_ receive' => 'Id Doctor  Receive',
        ];
    }
}