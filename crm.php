<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "CRM Bitrix");

$APPLICATION->SetTitle("CRM Bitrix");
?>
<body>
<section class="crm_about d-none d-md-block" name="top">
	<canvas id="animated_banner" style="margin: 0 auto; 
background: linear-gradient(282.75deg, #114C6D -7%, #54D4FE 101.89%);"></canvas>
	<!-- <img src="/bitrix/templates/eshop_bootstrap_v4/images/mainbanner.png" style="width: 100%;" alt=""> -->
	<script>
		var canvas = document.getElementById('animated_banner');
		var ctx = canvas.getContext('2d');
		window.addEventListener('resize', resizeCanvas, false);

		function resizeCanvas() {
			canvas.width = window.innerWidth;
			canvas.height = window.innerHeight - window.innerHeight * 0.1;
		}
		resizeCanvas();
		setInterval(draw, 10);
		var balls = [{
				x: 150,
				y: canvas.height - 150,
				r: 150,
				xVelocity: -0.1,
				yVelocity: -0.1,
				color: {
					start: "#7034D1",
					middle: "#7034D1",
					end: "#D93C76"
				},
			},
			{
				x: canvas.width - 150,
				y: 100,
				r: 100,
				xVelocity: -0.1,
				yVelocity: 0.1,
				color: {
					start: "#6C306F",
					middle: "#F542FC",
					end: "#6C306F"
				},
			},
			{
				x: canvas.width - 150,
				y: canvas.height - 150,
				r: 60,
				xVelocity: 0.07,
				yVelocity: 0.1,
				color: {
					start: "#EBD041",
					middle: "#EBD041",
					end: "#FF4751"
				},
			},
			{
				x: 50,
				y: 50,
				r: 50,
				xVelocity: -0.1,
				yVelocity: 0.1,
				color: {
					start: "#F542FC",
					middle: "#F542FC",
					end: "#6C306F"
				},
			},
			{
				x: canvas.width - 100,
				y: canvas.height - 250,
				r: 30,
				xVelocity: -0.1,
				yVelocity: 0.1,
				color: {
					start: "#FFA8A8",
					middle: "#FFA8A8",
					end: "#F5445B"
				},
			},
		];

		function drawBall(x, y, r, color) {
			ctx.beginPath();

			var gradient = ctx.createRadialGradient(x, y, r, x + x * 0.8, y - y / 4, r);
			gradient.addColorStop(0, color.end);
			gradient.addColorStop(.5, color.middle);
			gradient.addColorStop(1, color.start);
			ctx.fillStyle = gradient;
			ctx.arc(x, y, r, 0, 2 * Math.PI);
			//ctx.fillStyle = color;
			ctx.fill();

			ctx.closePath();
		}

		function draw() {
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			balls.forEach((element) => {
				drawBall(element.x, element.y, element.r, element.color);
				if (element.x + element.r > canvas.width || element.x - element.r < 0) {
					element.xVelocity = -element.xVelocity;
				}
				if (element.y + element.r > canvas.height || element.y - element.r < 0) {
					element.yVelocity = -element.yVelocity;
				}
				element.x += element.xVelocity;
				element.y += element.yVelocity;
			});

		}
	</script>
    <div class="row banner">
      <div class="col-md-4">
        <img  class="bitrix24" src="<?= SITE_TEMPLATE_PATH ?>/images/Bitrix24.png">
      </div>
      <div class="col-md-8">
        <p class="bitrix1">Битрикс24 помогает бизнесу работать
          Вместо десятков сервисов и приложений — единая платформа для организации работы всей компании. </p>
      </div>
    </div>
</section>
  <section class="container">
    <div class="crm_title"> Офис </div>
    <p class="crm_main_title">Помогает работать вместе: чат, видеозвонки и видеоконференции до 48 человек, диск, календарь, группы, рабочие отчеты, бизнес-процессы и другие инструменты для работы в офисе или из дома. Мгновенно выходите на связь с любым сотрудником, согласовывайте документы и счета, общайтесь с коллегами.
    </p>
    <div class="container office_box" style="margin-top: 5%;">
      <div class="row">
        <div class="col crm_office_img"><img src="<?= SITE_TEMPLATE_PATH ?>/crm/Бесплатная неограниченная видеосвязь.png">

          <p class="office_text">
            Бесплатная неограниченная видеосвязь с сотрудниками, клиентами, подрядчиками, они быстро подключатся к звонку по ссылке, без регистрации в Битрикс24
          </p>
        </div>
        <div class="col crm_office_img"><img src="<?= SITE_TEMPLATE_PATH ?>/crm/облако.png">
          <p class="office_text">
            Все рабочие документы хранятся на Диске, с автоматической синхронизацией
          </p>
        </div>
        <div class="w-100"></div>
        <div class="col crm_office_img"><img src="<?= SITE_TEMPLATE_PATH ?>/crm/учет раб врем.png">
          <p class="office_text">
            Учет рабочего времени и отчеты в один клик
          </p>
        </div>
        <div class="col crm_office_img"><img src="<?= SITE_TEMPLATE_PATH ?>/crm/удоб план.png">
          <p class="office_text">
            Удобное планирование расписания и встреч с коллегами
          </p>
        </div>
      </div>
    </div>
    <div class="crm_title"> Задачи и проекты </div>
    <p class="crm_main_title">
      Помогают работать вместе и успевать вовремя. Если задача поставлена в Битрикс24, она будет выполнена.
      Работайте вместе над задачами и проектами с любого устройства.
    </p>
    <div class="crm_project">
      <img src="<?= SITE_TEMPLATE_PATH ?>/crm/битрикс поможет выпол задач в срок.png">
      <div class="crm_project_center_text">
        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Битрикс24 напомнит и поможет выполнить задачу в срок
        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Используйте разные методики: Мой план, канбан, диаграмму Ганта
        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Система фокусировки внимания — концентрируйтесь на важном
        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Объединяйте связанные задачи в проекты
        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
      </div>
    </div>
    <div class="crm_title">CRM </div>
    <p class="crm_main_title">
      Помогает продавать больше:
      берет под контроль все каналы коммуникаций с клиентами, подсказывает, что делать, автоматизирует продажи.
    </p>
    <div class="container">
      <div class="row">
        <div class="col-md-6 mb-5">

          <!--<img class="crm_box_img"  src="<?= SITE_TEMPLATE_PATH ?>/crm/все звонки письма.png" >-->

          <iframe class="crm_box_img" src="https://www.youtube.com/embed/WON4qYmW4MQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="col-12 col-md-6 mb-5 video-text">
          <p class="crm_box_text">
            Все звонки, письма, чаты с клиентами на сайте и в соцсетях сохраняются в CRM
          </p>
        </div>
        <div class="w-100"></div>
        <div class="col-12 col-md-6 video-text">
          <p class="crm_box_text">
            Автоматизация и встроенный генератор продаж, систематическая отправка писем и SMS клиентам
          </p>
        </div>
        <div class="col-md-6">

          <!--<img class="crm_box_img" src="<?= SITE_TEMPLATE_PATH ?>/crm/Автоматизац и встро.png" >-->
          <iframe class="crm_box_img" src="https://www.youtube.com/embed/4X09G41i71U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      </div>
    </div>
    <div class="crm_title"> Контакт-центр </div>
    <p class="crm_main_title">
      Объединяет в CRM каналы коммуникаций с клиентами: телефон, email, чат на сайте, Facebook, Instagram, ВКонтакте, Яндекс.Чат и другие.

    </p>
    <div class="crm_project">
      <img src="<?= SITE_TEMPLATE_PATH ?>/crm/Контакт центр.png">
      <div class="crm_project_center_text">
        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Ваши Facebook, Instagram, ВКонтакте, телефон и почта подключены к Битрикс24
        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Контакты, вся переписка и записи разговоров с клиентами сохраняется в CRM
        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Не теряйте клиентов: аналитика звонков, автоответчик и многое другое
        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Вы отвечаете клиентам быстро и там, где им удобно
        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
      </div>
    </div>

    <div class="crm_title"> Сайты и Магазины </div>
    <p class="crm_main_title">
      Сайты и лендинги должны быть не просто красивыми. Главная их задача — приводить клиентов. Сайты в Битрикс24 создаются, чтобы продавать!
      Создайте интернет-магазин без программирования за 2 минуты, разместите ссылку на него в соцсетях и начинайте продавать. Все заказы попадут в CRM.

    </p>
    <div class="crm_project">
      <img src="<?= SITE_TEMPLATE_PATH ?>/crm/Контакт центр.png">
      <div class="crm_project_center_text">
        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Создайте адаптивный магазин за 2 минуты с витриной товаров из вашей CRM

        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Размещайте ссылку на магазин в Instagram, Facebook, WhatsApp и других мессенджерах, быстро оформляйте заказы - нужны лишь имя и номер телефона

        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Накапливайте клиентскую базу и обрабатывайте заказы: интеграция продаж в Instagram, вся история клиента в CRM, настройка рекламы

        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
        Завершайте максимум сделок и добивайтесь повторных продаж: автоматизация продаж, оплата заказов по ссылке подходящим способом оплаты, отправка персональных предложений

        <svg width="0.7em" height="0.7em" viewBox="0 0 16 16" class="bi bi-circle-fill" fill="#2cc8f8" xmlns="http://www.w3.org/2000/svg">
          <circle cx="8" cy="8" r="8" />
        </svg>
      </div>
    </div>

    <!--<div class="question_crm"> Сколько это стоит?</div>-->
    <!--<div class="tarif_crm"> Тариф на облачный битрикс</div>-->
    <!--<div class="crm-cloud-table">-->
    <!--  <div class="crm-cloud-table__content">-->
    <!--    <div class="crm-cloud-table__column crm-cloud-table__column-first">-->
    <!--      <div class="crm-cloud-table__header">-->
    <!--        <div class="crm-cloud-table-header">-->
    <!--          <div class="crm-cloud-table-header__title">Бесплатный</div>-->
    <!--          <div class="crm-cloud-table-header__description">Начните работать онлайн и продавать больше с CRM</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__user">-->
    <!--        <div class="crm-cloud-table-user">-->
    <!--          <div class="crm-cloud-table-user__count">неограниченно</div>-->
    <!--          <div class="crm-cloud-table-user__description">пользователей</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__price">-->
    <!--        <div class="crm-cloud-table-price">-->
    <!--          <div class="crm-cloud-table-price__value">Бесплатно</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__buy">-->
    <!--        <div class="crm-cloud-table-buy">-->
    <!--          <a href="https://help3.admin24.ru/3b11f61c-f821-41c2-be19-ca27c389ac9c"><button class="crm-cloud-table-buy__button">Заказать</button></a>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__storage">-->
    <!--        <div class="crm-cloud-table-storage">-->
    <!--          <div class="crm-cloud-table-storage__value">5 Гб</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__list">-->
    <!--        <ul class="crm-cloud-table-list">-->
    <!--          <li class="crm-cloud-table-list__item">Совместная работа-->
    <!--            <ul class="crm-cloud-table-list-item">-->
    <!--              <li class="crm-cloud-table-list-item__content">Чат</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Видеозвонки HD</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Календарь</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Соцсеть компании</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Новости</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">База знаний</li>-->
    <!--            </ul>-->
    <!--          </li>-->
    <!--          <li class="crm-cloud-table-list__item">Задачи и проекты</li>-->
    <!--          <li class="crm-cloud-table-list__item">CRM</li>-->
    <!--          <li class="crm-cloud-table-list__item">Диск</li>-->
    <!--          <li class="crm-cloud-table-list__item">Контакт-центр</li>-->
    <!--          <li class="crm-cloud-table-list__item">Сайты</li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--        </ul>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="crm-cloud-table__column crm-cloud-table__column-second">-->
    <!--      <div class="crm-cloud-table__header">-->
    <!--        <div class="crm-cloud-table-header">-->
    <!--          <div class="crm-cloud-table-header__title">Базовый</div>-->
    <!--          <div class="crm-cloud-table-header__description">Для эффективной работы небольших компаний и отделов продаж</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__user">-->
    <!--        <div class="crm-cloud-table-user">-->
    <!--          <div class="crm-cloud-table-user__count">5</div>-->
    <!--          <div class="crm-cloud-table-user__description">пользователей</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__price">-->
    <!--        <div class="crm-cloud-table-price">-->
    <!--          <div class="crm-cloud-table-price__value">2 490 руб/мес.</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__buy">-->
    <!--        <div class="crm-cloud-table-buy">-->
    <!--          <a href="https://help3.admin24.ru/3b11f61c-f821-41c2-be19-ca27c389ac9c"><button class="crm-cloud-table-buy__button">Заказать</button></a>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__storage">-->
    <!--        <div class="crm-cloud-table-storage">-->
    <!--          <div class="crm-cloud-table-storage__value">24 Гб</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__list">-->
    <!--        <ul class="crm-cloud-table-list">-->
    <!--          <li class="crm-cloud-table-list__item">Совместная работа-->
    <!--            <ul class="crm-cloud-table-list-item">-->
    <!--              <li class="crm-cloud-table-list-item__content">Чат</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Видеозвонки HD</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Календарь</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Соцсеть компании</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Новости</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">База знаний</li>-->
    <!--            </ul>-->
    <!--          </li>-->
    <!--          <li class="crm-cloud-table-list__item">Задачи и проекты</li>-->
    <!--          <li class="crm-cloud-table-list__item">CRM</li>-->
    <!--          <li class="crm-cloud-table-list__item">Диск</li>-->
    <!--          <li class="crm-cloud-table-list__item">Контакт-центр</li>-->
    <!--          <li class="crm-cloud-table-list__item">Сайты</li>-->
    <!--          <li class="crm-cloud-table-list__item">Интернет-магазин</li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--        </ul>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__list">-->
    <!--        <ul class="crm-cloud-table-list">-->
    <!--          <li class="crm-cloud-table-list__item">Поддержка</li>-->
    <!--        </ul>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="crm-cloud-table__column crm-cloud-table__column-third">-->
    <!--      <div class="crm-cloud-table__header">-->
    <!--        <div class="crm-cloud-table-header">-->
    <!--          <div class="crm-cloud-table-header__title">Стандартный</div>-->
    <!--          <div class="crm-cloud-table-header__description">Для совместной работы всей компании или рабочих групп</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__user">-->
    <!--        <div class="crm-cloud-table-user">-->
    <!--          <div class="crm-cloud-table-user__count">50</div>-->
    <!--          <div class="crm-cloud-table-user__description">пользователей</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__price">-->
    <!--        <div class="crm-cloud-table-price">-->
    <!--          <div class="crm-cloud-table-price__value">5 990 руб/мес.</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__buy">-->
    <!--        <div class="crm-cloud-table-buy">-->
    <!--          <a href="https://help3.admin24.ru/3b11f61c-f821-41c2-be19-ca27c389ac9c"><button class="crm-cloud-table-buy__button">Заказать</button></a>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__storage">-->
    <!--        <div class="crm-cloud-table-storage">-->
    <!--          <div class="crm-cloud-table-storage__value">100 Гб</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__list">-->
    <!--        <ul class="crm-cloud-table-list">-->
    <!--          <li class="crm-cloud-table-list__item">Совместная работа-->
    <!--            <ul class="crm-cloud-table-list-item">-->
    <!--              <li class="crm-cloud-table-list-item__content">Чат</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Видеозвонки HD</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Календарь</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Соцсеть компании</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Новости</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">База знаний</li>-->
    <!--            </ul>-->
    <!--          </li>-->
    <!--          <li class="crm-cloud-table-list__item">Задачи и проекты</li>-->
    <!--          <li class="crm-cloud-table-list__item">CRM</li>-->
    <!--          <li class="crm-cloud-table-list__item">Диск</li>-->
    <!--          <li class="crm-cloud-table-list__item">Контакт-центр</li>-->
    <!--          <li class="crm-cloud-table-list__item">Сайты</li>-->
    <!--          <li class="crm-cloud-table-list__item">Интернет-магазин</li>-->
    <!--          <li class="crm-cloud-table-list__item">Маркетинг</li>-->
    <!--          <li class="crm-cloud-table-list__item">Документы онлайн</li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--          <li class="crm-cloud-table-list__item crm-cloud-table-list__item--empty"></li>-->
    <!--        </ul>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__list">-->
    <!--        <ul class="crm-cloud-table-list">-->
    <!--          <li class="crm-cloud-table-list__item">Поддержка</li>-->
    <!--          <li class="crm-cloud-table-list__item">Администрирование</li>-->
    <!--        </ul>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="crm-cloud-table__column crm-cloud-table__column-fourth">-->
    <!--      <div class="crm-cloud-table__header">-->
    <!--        <div class="crm-cloud-table-header">-->
    <!--          <div class="crm-cloud-table-header__title">Профессиональный</div>-->
    <!--          <div class="crm-cloud-table-header__description">Для максимальной автоматизации всех процессов в компании</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__user">-->
    <!--        <div class="crm-cloud-table-user">-->
    <!--          <div class="crm-cloud-table-user__count">неограниченно</div>-->
    <!--          <div class="crm-cloud-table-user__description">пользователей</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__price">-->
    <!--        <div class="crm-cloud-table-price">-->
    <!--          <div class="crm-cloud-table-price__value">11 990 руб/мес.</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__buy">-->
    <!--        <div class="crm-cloud-table-buy">-->
    <!--          <a href="https://help3.admin24.ru/3b11f61c-f821-41c2-be19-ca27c389ac9c"><button class="crm-cloud-table-buy__button">Заказать</button></a>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__storage">-->
    <!--        <div class="crm-cloud-table-storage">-->
    <!--          <div class="crm-cloud-table-storage__value">1024 Гб</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__list">-->
    <!--        <ul class="crm-cloud-table-list">-->
    <!--          <li class="crm-cloud-table-list__item">Совместная работа-->
    <!--            <ul class="crm-cloud-table-list-item">-->
    <!--              <li class="crm-cloud-table-list-item__content">Чат</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Видеозвонки HD</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Календарь</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Соцсеть компании</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">Новости</li>-->
    <!--              <li class="crm-cloud-table-list-item__content">База знаний</li>-->
    <!--            </ul>-->
    <!--          </li>-->
    <!--          <li class="crm-cloud-table-list__item">Задачи и проекты</li>-->
    <!--          <li class="crm-cloud-table-list__item">CRM</li>-->
    <!--          <li class="crm-cloud-table-list__item">Диск</li>-->
    <!--          <li class="crm-cloud-table-list__item">Контакт-центр</li>-->
    <!--          <li class="crm-cloud-table-list__item">Сайты</li>-->
    <!--          <li class="crm-cloud-table-list__item">Интернет-магазин</li>-->
    <!--          <li class="crm-cloud-table-list__item">Маркетинг</li>-->
    <!--          <li class="crm-cloud-table-list__item">Документы онлайн</li>-->
    <!--          <li class="crm-cloud-table-list__item">Сквозная аналитика</li>-->
    <!--          <li class="crm-cloud-table-list__item">Автоматизация бизнеса</li>-->
    <!--          <li class="crm-cloud-table-list__item">HR</li>-->
    <!--        </ul>-->
    <!--      </div>-->
    <!--      <div class="crm-cloud-table__list">-->
    <!--        <ul class="crm-cloud-table-list">-->
    <!--          <li class="crm-cloud-table-list__item">Поддержка</li>-->
    <!--          <li class="crm-cloud-table-list__item">Администрирование</li>-->
    <!--        </ul>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->

    <!--<div class="tarif_crm"> Тариф на коробочный битрикс</div>-->
    <!--<div class="crm-box-table">-->
    <!--  <div class="crm-box-table__content">-->
    <!--    <div class="crm-box-table__column crm-box-table__column-first">-->
    <!--      <div class="crm-box-table__header">-->
    <!--        <div class="crm-box-table-header">-->
    <!--          <div class="crm-box-table-header__title">Интернет-магазин + CRM</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__user">-->
    <!--        <div class="crm-box-table-user">-->
    <!--          <div class="crm-box-table-user__count">12</div>-->
    <!--          <div class="crm-box-table-user__description">пользователей</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__price">-->
    <!--        <div class="crm-box-table-price">-->
    <!--          <div class="crm-box-table-price__value">99 000 руб</div>-->
    <!--          <div class="crm-box-table-price__description">лицензия на 12 мес.</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__list">-->
    <!--        <ul class="crm-box-table-list">-->
    <!--          <li class="crm-box-table-list__item crm-box-table-list__item--checked">Экстранет</li>-->
    <!--          <li class="crm-box-table-list__item crm-box-table-list__item--checked">eCommerce-платформа</li>-->
    <!--          <li class="crm-box-table-list__item">Многодепартаментность</li>-->
    <!--          <li class="crm-box-table-list__item">Веб-кластер</li>-->
    <!--          <li class="crm-box-table-list__item">VIP-поддержка 24/7</li>-->
    <!--        </ul>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__buy">-->
    <!--        <div class="crm-box-table-buy">-->
    <!--          <a href="https://help3.admin24.ru/3b11f61c-f821-41c2-be19-ca27c389ac9c"><button class="crm-box-table-buy__button">Заказать</button></a>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="crm-box-table__column crm-box-table__column-second">-->
    <!--      <div class="crm-box-table__header">-->
    <!--        <div class="crm-box-table-header">-->
    <!--          <div class="crm-box-table-header__title">Корпоративный портал</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__user">-->
    <!--        <div class="crm-box-table-user">-->
    <!--          <div class="crm-box-table-user__count">50/100/250/500</div>-->
    <!--          <div class="crm-box-table-user__description">пользователей</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__price">-->
    <!--        <div class="crm-box-table-price">-->
    <!--          <div class="crm-box-table-price__value">139 000/199 000<br>299 000/500 000 руб</div>-->
    <!--          <div class="crm-box-table-price__description">лицензия на 12 мес.</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__list">-->
    <!--        <ul class="crm-box-table-list">-->
    <!--          <li class="crm-box-table-list__item crm-box-table-list__item--checked">Экстранет</li>-->
    <!--          <li class="crm-box-table-list__item crm-box-table-list__item--checked">eCommerce-платформа</li>-->
    <!--          <li class="crm-box-table-list__item">Многодепартаментность</li>-->
    <!--          <li class="crm-box-table-list__item">Веб-кластер</li>-->
    <!--          <li class="crm-box-table-list__item">VIP-поддержка 24/7</li>-->
    <!--        </ul>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__buy">-->
    <!--        <div class="crm-box-table-buy">-->
    <!--          <a href="https://help3.admin24.ru/3b11f61c-f821-41c2-be19-ca27c389ac9c"><button class="crm-box-table-buy__button">Заказать</button></a>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--    <div class="crm-box-table__column crm-box-table__column-third">-->
    <!--      <div class="crm-box-table__header">-->
    <!--        <div class="crm-box-table-header">-->
    <!--          <div class="crm-box-table-header__title">Энтерпрайз</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__user">-->
    <!--        <div class="crm-box-table-user">-->
    <!--          <div class="crm-box-table-user__count">1000+</div>-->
    <!--          <div class="crm-box-table-user__description">пользователей</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__price">-->
    <!--        <div class="crm-box-table-price">-->
    <!--          <div class="crm-box-table-price__value">990 000+ руб</div>-->
    <!--          <div class="crm-box-table-price__description">лицензия на 12 мес.</div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__list">-->
    <!--        <ul class="crm-box-table-list">-->
    <!--          <li class="crm-box-table-list__item crm-box-table-list__item--checked">Экстранет</li>-->
    <!--          <li class="crm-box-table-list__item crm-box-table-list__item--checked">eCommerce-платформа</li>-->
    <!--          <li class="crm-box-table-list__item crm-box-table-list__item--checked">Многодепартаментность</li>-->
    <!--          <li class="crm-box-table-list__item crm-box-table-list__item--checked">Веб-кластер</li>-->
    <!--          <li class="crm-box-table-list__item crm-box-table-list__item--checked">VIP-поддержка 24/7</li>-->
    <!--        </ul>-->
    <!--      </div>-->
    <!--      <div class="crm-box-table__buy">-->
    <!--        <div class="crm-box-table-buy">-->
    <!--          <a href="https://help3.admin24.ru/3b11f61c-f821-41c2-be19-ca27c389ac9c"><button class="crm-box-table-buy__button">Заказать</button></a>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->
  </section>

</body>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>