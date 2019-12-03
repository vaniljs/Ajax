# AJAX отправка данных и получение ответа

<br>

##JSON 

Форма:
```html

<form action="" name="person">
    <input type="text" name="theme" value="">
    <input type="text" name="Имя" value="Иван">
    <input type="text" name="Фамилия" value="Иванов">
    <input type="text" name="Телефон" value="+7123456789">
    <button>Отправить</button>
</form>

```

AJAX скрипт отправки:

```JavaScript

/* Задаем тему сообщения */
document.querySelector('input[name="theme"]').value = 'Заявка с сайта ' + document.location.host; 

/* Объект, в котором будут все поля формы */
var object = {};

document.querySelector('button').addEventListener('click', (e) => {
    e.preventDefault();

    /* Создаем объект из формы name="person" */
    var formData = new FormData(document.forms.person);

    /* Перебор и добавление в объект ключей */
    formData.forEach(function (value, key) {
        object[key] = value;
    });

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'func.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    /* Param указывается для POST,  как имя переменной */
    xhr.send('param=' + JSON.stringify(object));

    xhr.addEventListener("readystatechange", () => {

        // Коды readyState https://developer.mozilla.org/ru/docs/Web/API/XMLHttpRequest/readyState
        // Коды status https://developer.mozilla.org/ru/docs/Web/API/XMLHttpRequest/status
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.response);
        }
    });
});

```

PHP обработчик:

```php

// Принимаем строку POST с ключем param и декодируем json
$param = json_decode($_REQUEST["param"]);

// Указываем свой email
$admin_email = 'mail@yandex.ru';

// Чекер для чередования строк
$c = true;

// Перебор всех ключей из формы в полученном json
foreach ( $param as $key => $value ) {

// Пропускаем пустые и технические поля
    if ( $value != "" && $key != "theme") {
        $message .= "
        // чередование цвета. Чекеру присваивается его обратное значение
        " . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "

            // Название ключа
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
            // Значение ключа
            <td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
        </tr>
        ";
    }
}

// Собираем тело письма
$message = "<table style='width: auto;'>$message</table>";

function adopt($text) {
    return '=?UTF-8?B?'.Base64_encode($text).'?=';
}

$headers = "MIME-Version: 1.0" . PHP_EOL .
"Content-Type: text/html; charset=utf-8" . PHP_EOL .
'From: '.adopt($param->theme).' <'.$admin_email.'>' . PHP_EOL .
'Reply-To: '.$admin_email.'' . PHP_EOL;

mail($admin_email, adopt($param->theme), $message, $headers );

// Ответ сервера
echo "Отправлено";

```