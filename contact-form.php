<?
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once($_SERVER['DOCUMENT_ROOT'].'/local/vendor/autoload.php');

/* Контакты*/
$name = htmlspecialchars($_POST["name"]);
$email = htmlspecialchars($_POST["email"]);
$tel = htmlspecialchars($_POST["tel"]);


$website = htmlspecialchars($_POST["website"]);
$bezspama = htmlspecialchars($_POST["bezspama"]);

/* Вопросы */
$three = htmlspecialchars($_POST["three"]);
$four = htmlspecialchars($_POST["four"]);
$five = htmlspecialchars($_POST["five"]);
$six= htmlspecialchars($_POST["six"]);


/* Адрес и тема сообщения */
$address = "Logikaweb@mail.ru";
$sub = "Заявка на разработку сайта";

/* Формат письма */
$mes = "Заявка на разработку сайта<br>
Лендинг/Корпоративный сайт <br>
Имя отправителя: $name <br>
Электронный адрес отправителя: $email<br>
Телефон отправителя: $tel<br>
Сайты конкурентов: $website<br>
Для наполнения сайта есть:$three<br>
Размещение информации на сайте: $four<br>
Запуск сайта через: $six<br>
Тематика бизнеса: $five";

$mail = new PHPMailer(true); //Argument true in constructor enables exceptions`\
try{
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 1;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.yandex.ru';
    $mail->Port = 465; // 587
    $mail->Username = 'sandal.skv12@yandex.ru';
    $mail->Password = base64_decode('YXB1dnViX3hvdHRhYmljaC1zYW5kYWw5NA==');
    $mail->CharSet =  'UTF-8'; // 'Windows-1251'
    $mail->SetFrom($mail->Username);
    $mail->addAddress("Logikaweb@mail.ru");
    $mail->addReplyTo($email, $email);
    $mail->isHTML(true);
    $mail->Subject = $sub;
    $mail->Body = $mes;
    $mail->Send();
    header('Location: http://logika1c.ru/thanks.php');
    exit();    
}
catch (Exception $e) {
     echo '<script>alert("Письмо не отправлено, через 5 секунд вы вернетесь на страницу")</script>';
  header('Refresh: 5; Location: http://logika1c.ru/site.php');
   exit();
}

// if (empty($bezspama)) /* Оценка поля bezspama - должно быть пустым*/
// {
// /* Отправляем сообщение, используя mail() функцию */
// $from = "Reply-To: $email \r\\n";
// if (mail($address, $sub, $mes, $from)) {
// 	header('Refresh: 1; URL=http://logika1c.ru/thanks.php');}
// else {
// 	header('Refresh: 5; URL=http://logika1c.ru/thanks.php');
// 	echo '<head>
//     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
//     <body>Письмо не отправлено, через 5 секунд вы вернетесь на страницу </body>';}
// }
// exit; /* Выход без сообщения, если поле bezspama чем-то заполнено */
?>