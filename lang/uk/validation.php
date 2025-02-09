<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Мовні рядки для валідації
    |--------------------------------------------------------------------------
    |
    | Наступні мовні рядки містять повідомлення про помилки за замовчуванням,
    | що використовуються класом валідатора. Деякі з цих правил мають кілька версій,
    | такі як правила розміру. Не соромтеся налаштовувати кожне з цих повідомлень тут.
    |
    */

    'accepted' => 'Ви повинні прийняти :attribute.',
    'accepted_if' => 'Ви повинні прийняти :attribute, коли :other дорівнює :value.',
    'active_url' => 'Поле :attribute має бути дійсною URL-адресою.',
    'after' => 'Поле :attribute має містити дату після :date.',
    'after_or_equal' => 'Поле :attribute має містити дату не раніше :date.',
    'alpha' => 'Поле :attribute може містити лише літери.',
    'alpha_dash' => 'Поле :attribute може містити лише літери, цифри, дефіси та підкреслення.',
    'alpha_num' => 'Поле :attribute може містити лише літери та цифри.',
    'array' => 'Поле :attribute має бути масивом.',
    'ascii' => 'Поле :attribute повинно містити тільки однобайтові алфавітно-цифрові символи та знаки.',
    'before' => 'Поле :attribute має містити дату до :date.',
    'before_or_equal' => 'Поле :attribute має містити дату не пізніше :date.',
    'between' => [
        'numeric' => 'Поле :attribute має бути між :min та :max.',
        'file' => 'Розмір файлу в полі :attribute має бути між :min та :max кілобайт.',
        'string' => 'Текст в полі :attribute має містити від :min до :max символів.',
        'array' => 'Поле :attribute має містити від :min до :max елементів.',
    ],
    'boolean' => 'Поле :attribute повинно мати значення true або false.',
    'can' => 'Поле :attribute містить неавторизоване значення.',
    'confirmed' => 'Поле :attribute не співпадає з підтвердженням.',
    'current_password' => 'Неправильний пароль.',
    'date' => 'Поле :attribute не є дійсною датою.',
    'date_equals' => 'Поле :attribute має бути датою, рівною :date.',
    'date_format' => 'Поле :attribute не відповідає формату :format.',
    'decimal' => 'Поле :attribute повинно містити :decimal десяткових знаків.',
    'declined' => 'Поле :attribute повинно бути відхилено.',
    'declined_if' => 'Поле :attribute повинно бути відхилено, коли :other є :value.',
    'different' => 'Поле :attribute та :other повинні бути різними.',
    'digits' => 'Поле :attribute повинно містити :digits цифр.',
    'digits_between' => 'Поле :attribute повинно містити від :min до :max цифр.',
    'dimensions' => 'Поле :attribute має неприпустимі розміри зображення.',
    'distinct' => 'Поле :attribute має повторюване значення.',
    'doesnt_end_with' => 'Поле :attribute не повинно закінчуватися одним із наступних значень: :values.',
    'doesnt_start_with' => 'Поле :attribute не повинно починатися з одного із наступних значень: :values.',
    'email' => 'Поле :attribute має містити дійсну електронну адресу.',
    'ends_with' => 'Поле :attribute має закінчуватися одним із наступних: :values.',
    'enum' => 'Вибране значення для :attribute недійсне.',
    'exists' => 'Вибране значення для :attribute не дійсне.',
    'extensions' => 'Поле :attribute повинно мати одне з наступних розширень: :values.',
    'file' => 'Поле :attribute має бути файлом.',
    'filled' => 'Поле :attribute повинно мати значення.',
    'gt' => [
        'numeric' => 'Поле :attribute повинно бути більше ніж :value.',
        'file' => 'Розмір файлу в полі :attribute має бути більше ніж :value кілобайт.',
        'string' => 'Текст в полі :attribute має містити більше ніж :value символів.',
        'array' => 'Поле :attribute має містити більше ніж :value елементів.',
    ],

    'gte' => [
        'numeric' => 'Поле :attribute повинно бути не менше :value.',
        'file' => 'Розмір файлу в полі :attribute має бути не менше :value кілобайт.',
        'string' => 'Текст в полі :attribute має містити не менше :value символів.',
        'array' => 'Поле :attribute має містити не менше :value елементів.',
    ],
    'hex_color' => 'Поле :attribute повинно бути дійсним шестнадцятковим кольором.',
    'image' => 'Поле :attribute має бути зображенням.',
    'in' => 'Вибране значення для :attribute не дійсне.',
    'in_array' => 'Поле :attribute не існує в :other.',
    'integer' => 'Поле :attribute має бути цілим числом.',
    'ip' => 'Поле :attribute має бути дійсною IP-адресою.',
    'ipv4' => 'Поле :attribute має бути дійсною IPv4-адресою.',
    'ipv6' => 'Поле :attribute має бути дійсною IPv6-адресою.',
    'json' => 'Поле :attribute має бути дійсним JSON рядком.',
    'lowercase' => 'Поле :attribute повинно бути в нижньому регістрі.',
    'lt' => [
        'numeric' => 'Поле :attribute повинно бути менше :value.',
        'file' => 'Розмір файлу в полі :attribute має бути менше :value кілобайт.',
        'string' => 'Текст в полі :attribute має містити менше ніж :value символів.',
        'array' => 'Поле :attribute має містити менше ніж :value елементів.',
    ],
    'lte' => [
        'numeric' => 'Поле :attribute повинно бути не більше :value.',
        'file' => 'Розмір файлу в полі :attribute має бути не більше :value кілобайт.',
        'string' => 'Текст в полі :attribute має містити не більше :value символів.',
        'array' => 'Поле :attribute не повинно містити більше ніж :value елементів.',
    ],
    'mac_address' => 'Поле :attribute має бути дійсною MAC-адресою.',
    'max' => [
        'numeric' => 'Поле :attribute не може бути більше ніж :max.',
        'file' => 'Розмір файлу в полі :attribute не може перевищувати :max кілобайт.',
        'string' => 'Текст в полі :attribute не може містити більше ніж :max символів.',
        'array' => 'Поле :attribute не може містити більше ніж :max елементів.',
    ],
    'max_digits' => 'Поле :attribute не повинно містити більше ніж :max цифр.',
    'mimes' => 'Поле :attribute має бути файлом одного з типів: :values.',
    'mimetypes' => 'Поле :attribute має бути файлом одного з типів: :values.',
    'min' => [
        'numeric' => 'Поле :attribute має бути не менше :min.',
        'file' => 'Розмір файлу в полі :attribute має бути не менше :min кілобайт.',
        'string' => 'Текст в полі :attribute має містити не менше :min символів.',
        'array' => 'Поле :attribute повинно містити не менше :min елементів.',
    ],
    'min_digits' => 'Поле :attribute повинно містити щонайменше :min цифр.',
    'missing' => 'Поле :attribute повинно бути відсутнім.',
    'missing_if' => 'Поле :attribute повинно бути відсутнім, коли :other є :value.',
    'missing_unless' => 'Поле :attribute повинно бути відсутнім, якщо тільки :other не є :value.',
    'missing_with' => 'Поле :attribute повинно бути відсутнім, коли :values присутні.',
    'missing_with_all' => 'Поле :attribute повинно бути відсутнім, коли :values присутні.',
    'multiple_of' => 'Поле :attribute має бути кратним :value.',
    'not_in' => 'Вибране значення для :attribute помилкове.',
    'not_regex' => 'Формат поля :attribute помилковий.',
    'numeric' => 'Поле :attribute має бути числом.',
    'password' => [
        'letters' => 'Поле :attribute повинно містити принаймні одну літеру.',
        'mixed' => 'Поле :attribute повинно містити принаймні одну велику та одну малу літеру.',
        'numbers' => 'Поле :attribute повинно містити принаймні одну цифру.',
        'symbols' => 'Поле :attribute повинно містити принаймні один символ.',
        'uncompromised' => 'Значення поля :attribute було знайдено в витоку даних. Будь ласка, оберіть інше значення для :attribute.',
    ],
    'present' => 'Поле :attribute повинно бути присутнім.',
    'present_if' => 'Поле :attribute повинно бути присутнім, коли :other дорівнює :value.',
    'present_unless' => 'Поле :attribute повинно бути присутнім, якщо :other не дорівнює :value.',
    'present_with' => 'Поле :attribute повинно бути присутнім, коли присутнє значення :values.',
    'present_with_all' => 'Поле :attribute повинно бути присутнім, коли присутні всі значення :values.',
    'prohibited' => 'Поле :attribute заборонене.',
    'prohibited_if' => 'Поле :attribute заборонене, коли :other дорівнює :value.',
    'prohibited_unless' => 'Поле :attribute заборонене, якщо :other не входить до :values.',
    'prohibits' => 'Поле :attribute забороняє присутність :other.',
    'regex' => 'Формат поля :attribute помилковий.',
    'required' => 'Поле :attribute є обов\'язковим.',
    'required_array_keys' => 'Поле :attribute повинно містити записи для: :values.',
    'required_if' => 'Поле :attribute є обов\'язковим, коли :other дорівнює :value.',
    'required_unless' => 'Поле :attribute є обов\'язковим, якщо :other не входить до :values.',
    'required_with' => 'Поле :attribute є обов\'язковим, коли :values присутній.',
    'required_with_all' => 'Поле :attribute є обов\'язковим, коли :values присутні.',
    'required_without' => 'Поле :attribute є обов\'язковим, коли :values відсутній.',
    'required_without_all' => 'Поле :attribute є обов\'язковим, коли жодне з :values не присутнє.',
    'same' => 'Значення :attribute має співпадати з :other.',
    'size' => [
        'numeric' => 'Поле :attribute має бути :size.',
        'file' => 'Розмір файлу в полі :attribute має бути :size кілобайт.',
        'string' => 'Текст в полі :attribute має містити :size символів.',
        'array' => 'Поле :attribute повинно містити :size елементів.',
    ],
    'starts_with' => 'Поле :attribute повинно починатися з одного з наступних значень: :values.',
    'string' => 'Поле :attribute має бути рядком.',
    'timezone' => 'Поле :attribute має бути дійсною часовою зоною.',
    'unique' => 'Таке значення поля :attribute вже існує.',
    'uploaded' => 'Не вдалося завантажити :attribute.',
    'uppercase' => 'Поле :attribute повинно бути записане великими літерами.',
    'url' => 'Поле :attribute має бути дійсною URL-адресою.',
    'ulid' => 'Поле :attribute повинно бути дійсним ULID.',
    'uuid' => 'Поле :attribute має бути дійсним UUID.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'phone' => 'Поле :attribute повинно бути дійсним номером.',

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'Назва',
        'lastName' => 'Прізвище',
        'slug' => 'Slug',
        'article' => 'Артикул',
        'email' => 'Електронна пошта',
        'password' => 'Пароль',
        'phone' => 'Номер телефону',
        'category' => 'Категорія',
        'price' => 'Ціна',
        'oldPrice' => 'Стара Ціна',
        'isActive' => 'Активний',
        'isDiscount' => 'Акційний',
        'oldPassword' => 'Старий пароль',
        'newPassword' => 'Новий пароль',
        'poshtaForm.selectedCity' => 'Місто',
        'poshtaForm.selectedWarehouse' => 'Відділення',
        'count' => 'Кількість',
        'text' => 'Текст',
        'priority' => 'Пріоритет',
        'description' => 'Опис',
        'shortDescription' => 'Короткий опис',
        'comment' => 'Коментар',

        'data.name' => 'Назва',
        'data.lastName' => 'Прізвище',
        'data.slug' => 'Slug',
        'data.article' => 'Артикул',
        'data.email' => 'Електронна пошта',
        'data.password' => 'Пароль',
        'data.phone' => 'Номер телефону',
        'data.category' => 'Категорія',
        'data.price' => 'Ціна',
        'data.oldPrice' => 'Стара Ціна',
        'data.isActive' => 'Активний',
        'data.isDiscount' => 'Акційний',
        'data.oldPassword' => 'Старий пароль',
        'data.newPassword' => 'Новий пароль',
        'data.poshtaForm.selectedCity' => 'Місто',
        'data.poshtaForm.selectedWarehouse' => 'Відділення',
        'data.count' => 'Кількість',
        'data.text' => 'Текст',
        'data.priority' => 'Пріоритет',
        'data.description' => 'Опис',
        'data.shortDescription' => 'Короткий опис',
        'data.comment' => 'Коментар',
    ],
];
