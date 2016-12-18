
Установка
-----------

Выполните

```
php composer.phar require --prefer-dist vision/yii_pg_int_array "dev-master"
```

или добавьте в ваш composer.json

```
"vision/yii_pg_int_array": "dev-master"
```

Использование
-----
Указываем в AR поля для модификации, а также валидатор:

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