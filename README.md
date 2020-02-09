# Fetch отправка данных и получение ответа

Fetch скрипт отправки:

```html
<button>
    Fetch
</button>
```

```JavaScript

document.querySelector('button').addEventListener('click', async () => {
    const data = { username1: 'example1', username2: 'example2' };
    const url = "functions.php";
    try {
        const response = await fetch(url, {
            method: 'POST',
            //body: 'username=example',
            body: ('param=' + JSON.stringify(data)),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });
        //const json = await response.json();
        //console.log('Успех:', json.username);
        const json = await response.text();
        console.log(json);
    } catch (error) {
        console.error('Ошибка:', error);
    }
});


```

PHP обработчик:

```php

// $data = json_encode($_POST);
// echo $data;

$param = json_decode($_REQUEST["param"]);
echo $param->username1;

```