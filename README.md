
Установка
-----------

Выполните

```
composer require vision/yii_pg_int_arr
```

или добавьте в ваш composer.json

```
"vision/yii_pg_int_arr": "^2.1"
```

Использование
-----
Указываем в AR поля для модификации, прикрепляем поведение, а также валидатор:


    use vision\yii_pg_int_array\PgIntegerArrayBehavior;
    use vision\yii_pg_int_array\PgIntegerArrayValidator;
    
    
    public function attributesIntArray()
    {
        return [
        'field_name'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            PgIntegerArrayBehavior::className()
        ];
    }
    
    public function rules()
    {
        return [
            ['field_name', PgIntegerArrayValidator::className()],
        ];
    }