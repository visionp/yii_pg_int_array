<?php
/**
 * Created by PhpStorm.
 * User: vision
 * Date: 18.12.16
 * Time: 12:51
 */

namespace vision\yii_pg_int_array;


use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class PgIntegerArrayBehavior extends Behavior
{

    /**
     * Прикрепляем обработчики к событиям
     *
     * @return array
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'toIntArray',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'toIntArray',
            BaseActiveRecord::EVENT_AFTER_FIND => 'fromIntArray'
        ];
    }


    /**
     * Выполняем при событиях insert/update
     * @param $event
     */
    public function toIntArray($event)
    {
        foreach($this->getNameAttributes($event) as $attr){
            if($this->isCorrectArray($this->owner->{$attr})){
                $this->owner->{$attr} = $this->fromArrayToString($this->owner->{$attr});
            }
        }
    }


    /**
     * Выполняем при событиях find...
     * @param $event
     */
    public function fromIntArray($event)
    {
        foreach($this->getNameAttributes($event) as $attr){
            $this->owner->{$attr} = $this->fromStringToArray($this->owner->{$attr});
        }
    }


    /**
     * Проверяем массив (на случай если не установлен валидатор)
     *
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


    /**
     * Конвеортируем массив в строку
     *
     * @param $data
     * @return string
     */
    protected function fromArrayToString( $data)
    {
        return json_encode($data);
    }


    /**
     * Строку в массив
     *
     * @param $string
     * @return mixed
     */
    protected function fromStringToArray($string)
    {
        $result = json_decode($string);
        return $result ? $result : $string;
    }


    /**
     * Возвращает аттрибуты указанные в AR классе
     *
     * @return array
     */
    protected function getModifiedAttr()
    {
        if(method_exists( $this->owner, 'attributesIntArray' )){
            return $this->owner->attributesIntArray();
        }
        return [];
    }


    /**
     * Возвращает изменившиеся аттрибуты
     * @param $event
     * @return array
     */
    protected function getAttributesByEvent($event)
    {
        if ( $event->name == ActiveRecord::EVENT_BEFORE_UPDATE ) {
            return empty($this->owner->dirtyAttributes) ? [] : $this->owner->dirtyAttributes;
        }
        return $event->sender->attributes;
    }


    /**
     * Возвращает те аттрибуты которые требуют модификации
     *
     * @param $event
     * @return array
     */
    protected function getNameAttributes($event)
    {
        $senderAttributes = $this->getAttributesByEvent($event);
        $modifiedAttr = $this->getModifiedAttr();
        return array_intersect(
            array_keys($senderAttributes),
            $modifiedAttr
        );
    }


}