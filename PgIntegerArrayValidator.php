<?php
/**
 * Created by PhpStorm.
 * User: vision
 * Date: 18.12.16
 * Time: 14:29
 */

namespace vision\yii_pg_int_array;


use yii\validators\Validator;

class PgIntegerArrayValidator extends Validator
{

    /**
     * Валидируем поле
     *
     * @param $model
     * @param $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$this->isCorrectArray($model->$attribute)) {
            $this->addError($model, $attribute, 'Поле должно быть массивом с int значениями.');
        }
    }


    /**
     * Проверяем что массив корректен
     * @param $data
     * @return bool
     */
    protected function isCorrectArray($data)
    {
        if(is_array($data)){
            return $data == array_filter($data, 'is_int');
        }
        return false;
    }

}