<?
$email = $_POST['email'];

$email = htmlspecialchars($email);

$email = urldecode($email);

$email = trim($email);



if(mail("logika1c@mail.com",
"НОВОЕ ПИСЬМО С САЙТА.СОТРУДНИЧЕСТВО.",
"ПОЛУЧЕНА ЭЛЕКТРОННАЯ ПОЧТА ДЛЯ СОТРУДНИЧЕСТВА: ".$email."\r\n")
) {
header("Location: http://logika1c.ru/");
}
else {
    echo ('Ошибка');
}
?>