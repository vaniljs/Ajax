# AJAX отправка данных и получение ответа

<br>

##JSON 

Форма:
```html

<form action="" name="person">
    <input type="text" name="Имя" value="Иван"><br>
    <input type="text" name="Фамилия" value="Иванов"><br>
    <input type="text" name="Телефон" value="+7123456789"><br>
    <input type="text" name="test" value=""><br>
    <button>Отправить</button>
</form>

```

AJAX скрипт отправки:

```JavaScript

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

// Проверка работы с условиями
if ($param->test == "777")
echo "Бинго!";
else

// Ответ для скрипта AJAX
echo $param->Имя. " " .$param->Фамилия. " " .$param->Телефон. " " .$param->test;

```