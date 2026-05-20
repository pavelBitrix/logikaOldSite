<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Оставить заявку");

?><div class="about">
	<div class="main_title about">
		свяжитесь с нами в один клик
	</div>
</div>
<!-- <div class="about-bold-text" style="width: 100%;">
	<iframe id="helpdeskFrame" src="https://1os.su/helpdesk/ticket.php?domain=logika1c.bitrix24.ru" height="1200px" width="100%"></iframe>
</div> -->

<div class="about-bold-text" style="width: 100%;">


	<div class="container mt-5">
		<h2 class="mb-4">Оформление заявки</h2>
		<form id="ticketForm" action="https://1os.su/helpdesk/createTicket.php?domain=logika1c.bitrix24.ru" method="POST" target="_blank">
			<input name="LANG" value="ru" type="hidden" />
			<input name="TYPE" value="external,customform" type="hidden" />
			<input name="RESPONSIBLE_ID" value="131" type="hidden" />
			<input name="AUDITORS" value="1,10,16,45,165" type="hidden" />
			<input name="ACCOMPLICES" value="" type="hidden" />
			<input name="GROUP_ID" value="75" type="hidden" />
			<input name="SLA" value="24" type="hidden" /> <!--Время обработки задачи-->
			<input name="verbose" value="1" type="hidden" />

			<div class="form-group" id="typeDiv" style="display: none;">
				<label for="typelist">Выберите тип заявки:</label>
				<select id="typelist" class="form-control">
					<option value="Заявка в Логику">Заявка в Логику</option>
				</select>
			</div>

			<div style="position: absolute; left: -9999px;" aria-hidden="true">
				<label for="company_website">Оставьте это поле пустым</label>
				<input type="text" id="company_website" name="company_website" tabindex="-1" autocomplete="off">
			</div>

			<div id="title-block" class="form-group">
				<label for="titlelist">Укажите заголовок заявки:</label>
				<select id="titlelist" class="form-control" name="TITLE">
					<option value="1. Обслуживание 1с">1. Обслуживание 1с</option>
					<option value="2. Обслуживание кассы">2. Обслуживание кассы</option>
					<option value="3. Бухобслуживание 1С">3. Бухобслуживание 1С</option>
					<option value="4. Системное администрирование">4. Системное администрирование</option>
					<option value="5. Web-разработка">5. Web-разработка</option>
					<option value="none">Произвольная заявка</option>
				</select>
				<input id="title" style="display: none;" class="form-control" value="1. Обслуживание 1с" placeholder="Введите заголовок..." name="TITLE">
			</div>

			<div class="form-group" id="nameGroup">
				<label for="name">Укажите ФИО *:</label>
				<input id="name" class="form-control" placeholder="Введите Ваше имя..." required="" name="NAME">
			</div>

			<div class="form-group" id="telGroup">
				<label for="contact">Укажите Контакт по которому с вами могут связаться *:</label>
				<input id="contact" class="form-control" placeholder="Введите телефон или email..." required="" name="CONTACT">
			</div>

			<div class="form-group">
				<label for="desc">Укажите комментарий к заявке *:</label>
				<textarea id="desc" rows="10" class="form-control" required="" name="DESCRIPTION"></textarea>
			</div>

			<div class="form-group">
				<label for="exampleInputFile">Файлы к заявке:</label>
				<div class="custom-file mb-1">
					<input type="file" accept="*/*" capture="camera" class="custom-file-input file" id="customFile1">
					<label class="custom-file-label" for="customFile1">Выберите файл...</label>
				</div>
				<div class="custom-file mb-1">
					<input type="file" accept="*/*" capture="camera" class="custom-file-input file" id="customFile2">
					<label class="custom-file-label" for="customFile2">Выберите файл...</label>
				</div>
				<!-- <div class="custom-file mb-1">
					<input type="file" accept="*/*" capture="camera" class="custom-file-input file" id="customFile3">
					<label class="custom-file-label" for="customFile3">Выберите файл...</label>
				</div>
				<div class="custom-file">
					<input type="file" accept="*/*" capture="camera" class="custom-file-input file" id="customFile4">
					<label class="custom-file-label" for="customFile4">Выберите файл...</label>
				</div> -->
			</div>

			<p id="error" class="bg-danger"></p>
			<p style="text-align: left;">* - Обязательно заполните</p>
			<p style="text-align: left;">ВАЖНО!!! Общий размер файлов не должен превышать 750Кб</p>

			<button type="submit" class="btn btn-success float-right">Отправить</button>
			<!-- <a id="addTicketPopup_cancel" class="btn btn-link float-right" href="#" role="button">Отменить</a> -->
		</form>
	</div>

	<!-- Модальное окно для уведомления об успешной отправке -->
	<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="successModalLabel">Успешно</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Ваша заявка успешно отправлена!
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Подключение Bootstrap JS и jQuery -->
	<script
		src="https://code.jquery.com/jquery-3.7.1.js"
		integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
	<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
	<script>
		$(document).ready(function($) {
			// Пример JavaScript для скрытия/отображения поля "Произвольная заявка"
			document.getElementById('titlelist').addEventListener('change', function() {
				if (this.value === 'none') {
					document.getElementById('title').style.display = 'block';
				} else {
					document.getElementById('title').style.display = 'none';
				}
			});

			document.getElementById('titlelist').addEventListener('change', function() {
				var selectValue = this.value;
				var inputField = document.getElementById('title');

				if (selectValue === 'none') {
					inputField.style.display = 'block';
					inputField.value = ''; // Очищаем значение, если выбрана "Произвольная заявка"
				} else {
					inputField.style.display = 'none';
					inputField.value = selectValue; // Устанавливаем значение из выпадающего списка
				}
			});

			var fileNames = [];
			var files = [];
			$(".file").change(function() {
				if (this.files && this.files[0]) {
					var FR = new FileReader();
					FR.onload = function(e) {
						files.push(btoa(e.target.result)); // Преобразуем файл в Base64 и добавляем в массив
					};
					FR.readAsBinaryString(this.files[0]); // Читаем файл как бинарную строку
					fileNames.push(this.files[0].name); // Добавляем имя файла в массив
					console.log(this.files[0].name);
					$("label[for='" + this.id + "']").text(this.files[0].name); // Обновляем текст метки
				}
			});



			function logFormData(formData) {
				for (var pair of formData.entries()) {
					console.log(pair[0] + ': ' + pair[1]);
				}
			}

			var formLoadTime = new Date().getTime();
			// Обработка отправки формы
			document.getElementById('ticketForm').addEventListener('submit', function(event) {
				event.preventDefault(); // Предотвращаем стандартное поведение формы

				// --- Проверка времени ---
				var submitTime = new Date().getTime();
				var timeDiff = submitTime - formLoadTime;
				
				// Если форма заполнена быстрее чем за 4 секунды (4000 мс) - это точно бот
				if (timeDiff < 4000) {
					console.warn('Обнаружен бот (форма заполнена слишком быстро).');
					return false; 
				}
				// ------------------------

				// --- Honeypot проверка ---
				if ($('#company_website').val() !== '') {
					console.warn('Обнаружен бот (заполнено скрытое поле).');
					// Имитируем успешную отправку для бота, чтобы он отстал, но ничего не отправляем
					$('#successModal').modal('show'); 
					return false; 
				}
				// -------------------------


				var formData = new FormData();

				// Добавляем данные из скрытых полей
				formData.append('LANG', $('input[name="LANG"]').val());
				formData.append('TYPE', $('input[name="TYPE"]').val());
				formData.append('RESPONSIBLE_ID', $('input[name="RESPONSIBLE_ID"]').val());
				formData.append('AUDITORS', $('input[name="AUDITORS"]').val());
				formData.append('ACCOMPLICES', $('input[name="ACCOMPLICES"]').val());
				formData.append('GROUP_ID', $('input[name="GROUP_ID"]').val());
				formData.append('SLA', $('input[name="SLA"]').val());
				formData.append('verbose', $('input[name="verbose"]').val());

				// Добавляем данные из текстовых полей
				formData.append('NAME', $('#name').val());
				formData.append('CONTACT', $('#contact').val());
				formData.append('DESCRIPTION', $('#desc').val());

				// Добавляем данные из выпадающего списка
				var titleValue = $('#titlelist').val();
				if (titleValue === 'none') {
					formData.append('TITLE', $('#title').val());
				} else {
					formData.append('TITLE', titleValue);
				}

				// Добавляем файлы в FormData
				// $('.file').each(function() {
				// 	if (this.files.length > 0) {
				// 		formData.append('files[]', this.files[0]);
				// 	}
				// });
				// Добавляем файлы в FormData
				$.each(files, function(index, item) {
					formData.append("file[]", item);
				});
				$.each(fileNames, function(index, item) {
					formData.append("fileName[]", item);
				});



				// logFormData(formData);





				// Отправка формы через AJAX
				$('#successModal').modal('show');
				$.ajax({
					url: 'https://1os.su/helpdesk/createTicket.php?domain=logika1c.bitrix24.ru',
					method: 'POST',
					type: 'POST',
					// data: $(this).serialize(),
					data: formData,
					cache: false,
					processData: false,
					contentType: false,
					success: function(response) {
						// Показываем модальное окно об успешной отправке
						jQuery.noConflict();
						$('#successModal').modal('show');
						console.log("Ответ от 1os.su:", response);

						// --- НАЧАЛО НОВОЙ ЛОГИКИ ---
						// Извлекаем ID заявки из текстового ответа с помощью регулярного выражения
						var matches = response.match(/\d+/);
						var ticketId = matches ? matches[0] : null; // Получаем ID или null, если не найдено

						// Выводим в консоль для проверки
						console.log('Ответ от сервера:', response);
						console.log('Извлеченный ID заявки:', ticketId);

						// Если ID был успешно извлечен, добавляем его к данным для отправки в Telegram
						if (ticketId) {
							formData.append('ticket_id', ticketId);
						}

						// !!! НАЧАЛО ИЗМЕНЕНИЙ: Отправка данных в Telegram !!!
						$.ajax({
							url: '/zayavka/telegram_sender.php', // Путь к PHP-обработчику
							type: 'POST',
							data: formData,
							processData: false,
							contentType: false,
							success: function(response) {
								console.log('Заявка успешно отправлена в Telegram.');
							},
							error: function(jqXHR, textStatus, errorThrown) {
								console.error('Ошибка при отправке в Telegram:', textStatus, errorThrown);
							}
						});
						// !!! КОНЕЦ ИЗМЕНЕНИЙ !!!

					},
					error: function() {
						alert('Произошла ошибка при отправке заявки. Общий размер файлов превышает 750Кб.');
					}
				});
			});


			// Резервная копия формы
			$('#ticketForm').on('submit', function(event) {
				event.preventDefault(); // Предотвращаем стандартное поведение формы

				// Собираем данные формы
				var formData = new FormData(this);

				// Отправляем данные на сервер через AJAX
				$.ajax({
					url: '/zayavka/save_data.php',
					type: 'POST',
					data: formData,
					processData: false,
					contentType: false,
					success: function(response) {
						var data = JSON.parse(response);
						// console.log(data);
						if (data.status === 'success') {
							// Если данные успешно сохранены, отправляем форму на сервер
							// $('#ticketForm')[0].submit();
						} else {
							// alert('Ошибка при сохранении данных: ' + data.message);
							console.error('Ошибка при сохранении данных: ' + data.message);
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.error('Ошибка:', textStatus, errorThrown);
						// alert('Произошла ошибка при отправке данных.');
					}
				});
			});
		});
	</script>

</div>
<div class="container contacts_" style="width: 90%;">
	<div class="main_rekv">
		Контакты
	</div>
	<div class="row">
		<div class="col-lg-6" style="width: 50%;">
			<div class="rekv_title">
				Отдел продаж
			</div>
			<div class="rekv_text">
				+7 (4112) 505-675
			</div>
		</div>
		<div class="col-lg-6" style="width: 50%;">
			<div class="rekv_title">
				Режим работы
			</div>
			<div class="rekv_text">
				Пн-Пт: 09:00-18:00, <br>
				Сб: 10:00 - 13:00, <br>
				Вс - выходной
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-6" style="width: 50%;">
			<div class="rekv_title">
				Техподдержка
			</div>
			<div class="rekv_text">
				+7 (4112) 505-589
			</div>
		</div>
		<div class="col-lg-6" style="width: 50%;">
			<div class="rekv_title">
				Email
			</div>
			<div class="rekv_text">
				logika1c@mail.ru
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="rekv_title">
				г. Якутск, проспект Ленина д.1, 6 этаж, офис 609
			</div>
		</div>
	</div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
<!-- 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оставить заявку");

<div class="container mb-5">
    <div class="row mb-3 about">
        <div class="col-lg-6">
            <div class="main_title about">
               свяжитесь с нами в один клик
            </div>
        </div>
            <div class="col-lg-6 about-bold-text">
<iframe id="helpdeskFrame" src="https://1os.su/helpdesk/ticket.php?domain=logika1c.bitrix24.ru" height="1200px" width="100%"></iframe>
            </div>
    </div>
</div>

 <div class="container contacts_">
    <div class="main_rekv">Контакты</div>
    <div class="row">
    <div class="col-lg-6">
        <div class="rekv_title">Отдел продаж</div>
        <div class="rekv_text">+7 (4112) 505-675</div>
    </div>
    <div class="col-lg-6">
        <div class="rekv_title">Режим работы</div>
        <div class="rekv_text">Пн-Пт: 09:00-18:00, <br>
        Сб: 10:00 - 13:00, <br> Вс - выходной
        </div>
    </div>
    <div class="col-lg-6">
        <div class="rekv_title">Техподдержка</div>
        <div class="rekv_text">+7 (4112) 505-589 </div>
    </div>
    <div class="col-lg-6">

    </div>
    <div class="col-lg-6">
        <div class="rekv_title">Email</div>
        <div class="rekv_text">logika1c@mail.ru</div>
    </div>
    <div class="col-lg-6">
        <div class="rekv_title">г. Якутск, проспект Ленина д.1, 6 этаж, офис 609</div>
    </div>

    </div>
    </div>
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); -->