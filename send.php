<?

$name = $_POST['name'];
$email = $_POST['email'];
$header= $_POST['header'];
$tel= $_POST['tel'];
$text = $_POST['text'];



$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$header= htmlspecialchars($header);
$tel= htmlspecialchars($tel);
$text = htmlspecialchars($text);

$name = urldecode($name);
$email = urldecode($email);
$header= urldecode($header);
$tel= urldecode($tel);
$text = urldecode($text);

$name = trim($name);
$email = trim($email);
$header= trim($header);
$tel= trim($tel);
$text = trim($text);


if(mail("asutaiiiga@gmail.com",
"НОВОЕ ПИСЬМО С САЙТА",
"Тема: ".$header."\n".
"Имя: ".$name."\n".
"Электронная почта: ".$email."\n".
"Телефон: ".$tel."\n".
"СООБЩЕНИЕ: ".$text."\r\n")
) {
header("Location: http://logika1c.ru/");
}
else {
    echo ('Ошибка');
}
?>