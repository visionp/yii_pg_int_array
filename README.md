
Установка
-----------

Выполните

```
php composer.phar require --prefer-dist vision/yii_pg_int_arr "dev-master"
```

или добавьте в ваш composer.json

```
"vision/yii_pg_int_arr": "dev-master"
```

Использование
-----
Указываем в AR поля для модификации, а также валидатор:


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