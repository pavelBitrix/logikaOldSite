<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "Разработка сайтов, веб");
$APPLICATION->SetTitle("Предприятие 1С");
?>
<section class="main_about d-none d-md-block" name="top">
	<canvas id="animated_banner" style="margin: 0 auto; 
background: linear-gradient(247.12deg, #5D2B65 -48.9%, #FF4751 130.81%);"></canvas>
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
	<div style="font-size: 1.9rem;">
Компания “Логика” - лидер по поставкам программных продуктов “1С”. За 10 лет нами накоплен большой опыт внедрения различных решений в сфере комплексной автоматизации управления и учета на базе продуктов компании “1С”
	</div>
	<a href="https://logika1c.ru/zayavka/">
		Оставить заявку
	</a>
</section>
<section style="margin-bottom: 10%;">
<!--<div class="row pred_main">-->
<!--    <div class="col-sm-auto">-->
<!--      <img class="pred_main_img" src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/12.png">-->
<!--    </div>-->
<!--    <div class="col">-->
<!--      <p class="pred_main_text">1С: Предприятие — эффективное управление, учет и документооборот более чем в 1 500 000 организаций </p>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="container predaboutmain">-->
<!--  <div class="row">-->
<!--    <div class="col-sm predabout">-->
<!--      <img class="pred_img" src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/11.png"> <br>1С в облаке - управляйте своим бизнесом и ведите учет через Интернет.-->
<!--    </div>-->
<!--    <div class="col-sm predabout">-->
<!--      <img class="pred_img" src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/10.png"> <br>Мобильное 1С:Предприятие на вашем смартфоне и планшете.-->
<!--    </div>-->
<!--    <div class="col-sm predabout">-->
<!--      <img class="pred_img" src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/6.png"> <br>Масштабные системы для крупнейших корпораций, холдингов и госструктур.-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<!--<div class="container predaboutmain">-->
<!--  <div class="row">-->
<!--    <div class="col-sm predabout">-->
<!--      <img class="pred_img" src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/7.png"> -->
<!--      <br>Сотни готовых решений для ваших отраслей и задач. <br>Быстро внедряются, легко настраиваются.-->
<!--    </div>-->
<!--    <div class="col-sm predabout">-->
<!--      <img class="pred_img" src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/9.png"> -->
<!--      <br>Индустриальное качество внедрения и сопровождения.-->
<!--    </div>-->
<!--    <div class="col-sm predabout">-->
<!--     <img class="pred_img" src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/8.png"> <br>Технологии мирового уровня. <br>Многоплатформенность, поддержка открытого ПО. <br>Масштабируемость и производительность.-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->

<section class="pred_info">
<h2>Услуги</h2>
  <div class="pred_title_text"> 
Мы оказываем полный спектр услуг в данной сфере: от масштабных проектов с сотнями автоматизированных мест до абонентского сопровождения отдельных решений
  </div>
  
  <div class="area predpriyatie"><div class="row">
      <div class="row col-lg-4 predpriyatie">
          <div class="col-3">     
              <div class="circleRed"></div>
              <div class="circleBack">1</div></div>
          <div class="col-9">Установка “1С” и настройка сервисов </div>
      </div>
     <div class="row col-lg-4 predpriyatie">
         <div class="col-3">    
              <div class="circleRed"></div>
              <div class="circleBack">4</div></div>
       <div class="col-9">Перенос данных</div>
      </div>
     <div class="row col-lg-4 predpriyatie">
         <div class="col-3">    
            <div class="circleRed"></div>
            <div class="circleBack">7</div></div>
        <div class="col-9">Индивидуальные доработки</div>
      </div>
        <div class="row col-lg-4 predpriyatie">
        <div class="col-3">    
            <div class="circleRed"></div>
            <div class="circleBack">2</div></div>
          <div class="col-9">Обновление программ и баз данных</div>
      </div>
        <div class="row col-lg-4 predpriyatie">
        <div class="col-3">    
            <div class="circleRed"></div>
            <div class="circleBack">5</div></div>
         <div class="col-9">Абонентское обслуживание</div>
      </div>
        <div class="row col-lg-4 predpriyatie">
        <div class="col-3">    
            <div class="circleRed"></div>
            <div class="circleBack">8</div></div>
        <div class="col-9">Интеграция с “1С”</div>
      </div>
        <div class="row col-lg-4 predpriyatie">
        <div class="col-3">    
            <div class="circleRed"></div>
             <div class="circleBack">3</div></div>
        <div class="col-9">Маркировка “1С”</div>
      </div>
    <div class="row col-lg-4 predpriyatie">
        <div class="col-3">    
            <div class="circleRed"></div>
            <div class="circleBack">6</div></div>
          <div class="col-9">Сопровождение “1С”</div>
      </div>
        <div class="row col-lg-4 predpriyatie">
        <div class="col-3">    
            <div class="circleRed"></div>
            <div class="circleBack">9</div></div>
         <div class="col-9">Подключение торгового оборудования</div>
      </div>
  </div></div>
<h2>Продукты</h2>
  <div class="pred_title">1С:Розница 8</div>
  <div class="pred_title_text"> 
    Универсальное решение для управления розничной торговлей. Полностью автоматизирует все основные бизнес-процессы как отдельного магазина, так и крупной розничной сети. Позволяет организовать эффективное управление продажами и закупками, запасами и складом, персоналом магазина, ассортиментом и ценообразованием, маркетинговыми акциями и системами лояльности. Автоматизирует рабочее место кассира. Обеспечивает оперативное формирование отчетов для мониторинга и анализа показателей работы торговых точек. Настраивается индивидуально под задачи любой сферы розничной торговли.
  </div>
  <a class="pred_btn" href="/podrazdely-predpriyatiya/index-pred1.php">Подробнее</a>
  <div class="content hidden">
    <section class="hidden_area"> 
      <div class="container">
        <div class="cont_title">Преимущества:</div>
        <div class="row">
          <div class="col-sm">
            <div class="prem_title">Универсальность</div>
            <div class="prem_text">
              - Подходит для компаний любого масштаба и любой сферы торговли<br>
              - Позволяет регистрировать практически все операции с товаром<br>
              - Поддерживает работу практически со всеми видами подключаемого торгового оборудования<br>
            </div>
          </div>
          <div class="col-sm">
            <div class="prem_title">Простая и удобная работа</div>
            <div class="prem_text">
              Легко настраивается в соответствии с принятой в конкретной компании методикой управления работы магазина
            </div>
          </div>
          <div class="col-sm">
            <div class="prem_title" style="text-align: right;">Интеграция без границ</div>
            <div class="prem_text" style="text-align: right;"> 
              - Системы маркировки и другие государственные информационные системы<br>
              - Может управляться с «1С:Управление торговлей» или «1С:Управление нашей фирмой», легко интегрируется с «1С:Бухгалтерия» и «1С:Мобильная касса»<br>
              - Система быстрых платежей<br>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="prem_title"> Поддержка и сопровождение</div>
            <div class="prem_text"> 
              - Открытость системы и легкость ее адаптации, широкие возможности масштабирования и интеграции, простота и удобство администрирования и поддержки.<br>
              - Консультации и сопровождение — по первому требованию, учебные материалы, презентации и видеоролики с подробным разбором функций — в любой момент.<br>
            </div>
          </div>
          <div class="col">
            <div class="prem_title" style="text-align: right;">Допвозможности и подключаемые сервисы</div>
            <div class="prem_text" style="text-align: right;"> 
              1С-ОФД     <br> 
              1С-Товары   <br> 
              1С:Номенклатура   <br> 
              1СПАРК Риски   <br> 
              1С-ЭДО   <br> 
              1С:Подпись   <br> 
            </div>
          </div>
        </div>
        <div class="cont_title">Возможности:</div> 
        <div class="row">
          <div class="col-sm">
            <div class="prem_title">Гибкая настройка</div>
            <div class="prem_text"> 
              Интерфейс программы можно настраивать в соответствии с применяемыми системами налогообложения и потребностями пользователей.
            </div>
          </div>
          <div class="col-sm">
            <div class="prem_title">Выбор варианта работы</div>
            <div class="prem_text">
              Поддержка различных вариантов работы пользователей: в режиме тонкого клиента или веб-клиента, через Интернет, в файловом режиме, в том числе с различными СУБД.
            </div>
          </div>
          <div class="col-sm">
            <div class="prem_title" style="text-align: right;"> Автоматизация ключевых задач управления розницей</div>
            <div class="prem_text" style="text-align: right;"> 
              Склад, запасы и закупки, ассортимент и ценообразование, продажи и маркетинг, учет платежных средств, персонал, НСИ, аналитика, автоматизированное рабочее место кассира.
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <div class="prem_title"> Интеграция с системами маркировки</div>
            <div class="prem_text">
              Соответствие требованиям 54-ФЗ, интеграция с ЕГАИС 3.0, ФГИС «Меркурий», ФГИС МДЛП, НСЦМ «Честный знак» и другими государственными информационными системами.
            </div>
          </div>
          <div class="col-sm">
            <div class="prem_title">Поддержка торгового оборудования </div>
            <div class="prem_text">
              Поддержка практически любого торгового оборудования: сканеры штрихкодов, ТСД, эквайринговые терминалы, дисплеи покупателей, считыватели магнитных карт, принтеры чеков и этикеток, и т. д.
            </div>
          </div>
          <div class="col-sm">
            <div class="prem_title" style="text-align: right;">Интеграция с программами и сервисами 1С</div>
            <div class="prem_text" style="text-align: right;"> 
              Обмен данными с «1С:Управление торговлей», «1С:Управление нашей фирмой», «1С:Бухгалтерия», мобильными приложениями: «1С:Мобильная касса», «1С:Кладовщик».<br>
              Поддержка работы с различными сервисами 1С для повышения эффективности торговли.
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="for_area">
      <div class="for_title">Для кого?</div>
      <div class="container pred_for_cont">
        <div class="row">
          <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/5.png">
            <br>отдельный магазин
          </div>
          <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/4.png">
            <br>розничная сеть
          </div>
          <div class="w-100"></div>
          <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/3.png">
            <br>небольшая торговая точка
          </div>
          <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/2.png">
            <br>магазины с большим количеством рабочих мест
          </div>
        </div>
      </div>
    </div>
    <div class="func_area"> 
      <div class="func_title">Функциональность</div>
      <div class="container">
        <div class="row">
          <div class="col func_text">
            ✔ Поддержка онлайн-ККТ <br>
            ✔ Интеграция с системами маркировки    <br>
            ✔ Базовая версия   <br>
            ✔ Нормативно-справочная информация   <br>
            ✔ Маркетинг   <br>
            ✔ Управление запасами и закупками   <br>
            ✔ Управление складом   <br>
            ✔ Управление продажами   <br>
          </div>
          <div class="col func_text">
            ✔ Учет платежных средств   <br>
            ✔ Управление персоналом магазина   <br>
            ✔ Система отчетности   <br>
            ✔ Подключаемое оборудование   <br>
            ✔ Обмен данными   <br>
            ✔ Интеграция с ЕГАИС   <br>
            ✔ 1С:Проверка ценников   <br>
            ✔ 1С:Кладовщик   <br>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pred_info">
  <div class="pred_title">1С:Управление торговлей 8</div>
  <div class="pred_title_text"> 
    Cовременный инструмент для повышения эффективности бизнеса торгового предприятия. Программа позволяет в комплексе автоматизировать задачи оперативного и управленческого учета, анализа и планирования торговых операций, обеспечивая тем самым эффективное управление современным торговым предприятием.
  </div>
  <div id="dots"></div>
  <a class="pred_btn" id="btn" onclick="readMore()" href="/podrazdely-predpriyatiya/index-pred2.php"> Подробнее </a>
  <div class="content hidden" id="more">
    <section  class="hidden_area"> 
      <div class="container">
        <div class="cont_title">Преимущества:</div>
        <div class="row">
          <div class="col">
            <div class="prem_text_2"> 
              <li>поддержка всех основных видов торговли (розничной, оптовой, в кредит, по предварительному заказу, комиссионной)</li>
              <li>могут регистрироваться как уже совершенные, так и еще только планируемые хозяйственные операции</li>
              <li>автоматизирует оформление практически всех первичных документов торгового и складского учета, а также документов движения денежных средств</li>
              <li>любые виды торговых операций</li>
              <li>функции учета — от ведения справочников и ввода первичных документов до получения различных аналитических отчетов</li>
              <li>управленческий учет по торговому предприятию в целом</li>
            </div>
          </div>
          <div class="col">
            <div class="prem_text_2">
              <li>документы могут оформляться от имени нескольких организаций, входящих в холдинг</li>
              <li>поддерживаются системы налогообложения: ОСНО (кроме ИП), УСН, ЕНВД</li>
              <li>функционал может быть гибко адаптирован путем включения/отключения различных функциональных опций</li>
              <li>обеспечивает автоматический подбор данных, необходимых для ведения бухгалтерского учета, и передачу этих данных в «1С:Бухгалтерию 8».</li>
              <li>совместно с другими программами позволяет комплексно автоматизировать оптово-розничные предприятия, может использоваться в качестве управляющей системы для решения «1С:Розница 8»</li>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="for_area">
      <div class="for_title">Для кого?</div>
      <div class="container pred_for_cont">
        <div class="row">
          <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/torg_1.png">
            <br>Руководитель торгового предприятия
          </div>
          <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/torg_2.png">
            <br>Руководители и специалисты торговых подразделений
          </div>
          <div class="w-100"></div>
          <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/torg_3.png">
            <br>Работники учетных служб
          </div>
          <div class="col pred_for_img">  <img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/torg_4.png">
            <br>IT-специалисты
          </div>
        </div>
      </div>
    <div class="func_area"> 
      <div class="func_title">Функциональность</div>
      <div class="container">
        <div class="row">
          <div class="col func_text" style="text-align: center">
            <li>Мониторинг и анализ показателей деятельности предприятия</li> 
            <li>Казначейство</li> 
            <li>Управление отношениями с клиентами</li>
            <li>Управление продажами</li>
            <li>Управление складом и запасами</li>
            <li>Управление закупками</li>
            <li>Управление затратами и расчет себестоимости</li>
            <li>Регламентированный учет</li>
            <li>Совместное использование с 1С:Документооборот</li>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pred_info" >
  <div class="pred_title">1С:Бухгалтерия 8</div>
  <div class="pred_title_text"> 
    Профессиональный инструмент бухгалтера, с помощью которого можно вести бухгалтерский и налоговый учет, готовить и сдавать обязательную отчетность. «1С:Бухгалтерия 8» позволяет вести учет в программе предприятиям, осуществляющим любые виды коммерческой деятельности (торговля, производство, оказание услуг) и применяющим любую систему налогообложения (ОСН, УСН, ЕНВД, патентную систему налогообложения).
  </div>
  <div id="dots2"></div>
  <a class="pred_btn" id="btn2" onclick="readMore2()" href="/podrazdely-predpriyatiya/index-pred3.php">Подробнее</a>
  <div class="content hidden" id="more2">
    <section> 
      <div class="container">
        <div class="row">
          <div class="col rose">
            <div class="rose_title" style="text-align: center">Функциональность</div>
            <div class="rose_text">
              <li>Настройка под нужды конкретного пользователя</li>
              <li>Отключение функционала по отдельным участкам учета </li>
              <li>Автоматическое исключение разделов, документов и справочников, связанных с отключенным функционалом</li>
              <li>Автоматизация работы отдела продаж, руководящих сотрудников и других служб</li>
            </div>
          </div>
        <div class="col purple">
            <div class="purp_title"style="text-align: center">Возможности </div>
            <div class="purp_text">
              <li>Автоматизация бухгалтерского и налогового учета в соответствии с действующим законодательством РФ</li>
              <li>Состав счетов, организация аналитического, валютного, количественного учета на счетах соответствуют требованиям законодательства по ведению бухгалтерского учета и отражению данных в отчетности</li>
              <li>Механизм обмена данными с другими продуктами «1С»: «1С:Розница 8», «1С:УНФ», «1С:Зарплата и управление персоналом 8»</li>
              <li>Решение всех задач бухгалтерской службы предприятия, включая выписку первичных документов</li>
              <li>Информационное взаимодействие с ИФНС через спецоператора связи</li>
              <li>Интеграция с действующими государственными информационными системами (ЕГАИС, ГИС «Маркировка», ГИС «Меркурий»)</li>
            </div>
        </div>
      </div>
      <div class="pred_title">Для кого:</div>
      <div class="pred_text" style="padding-top:15px"> 
        Для бизнесов разных масштабов — от ИП без работников до крупных многопрофильных холдингов
        <ul>
          <li>оптовая торговля </li>
          <li>розничная торговля </li>
          <li>комиссионная торговля </li>
          <li>интернет-торговля </li>
          <li>производство </li>
          <li>выполнение подрядных работ </li>
          <li>оказание профессиональных и бытовых услуг </li>
          <li>строительство </li>
        </ul>
      </div>
      <div class="prem_area">
        <div class="prem_title">Преимущества</div>
        <div class="container pred_for_cont">
          <div class="row">
            <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/buhg_1.png">
              <br><b>Поддерживаются различные системы налогообложения:</b>
              <br>общая, упрощенная, ЕНВД, патентная, налог на профессиональную деятельность
            </div>
            <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/buhg_2.png">
              <br><b>Быстрое освоение, простое использование</b>
            </div>
            <div class="w-100"></div>
            <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/buhg_3.png">
              <br><b>Гибкость и возможность настройки</b>
            </div>
            <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/buhg_4.png">
              <br><b>Отраслевые решения</b>
            </div>
            <div class="col pred_for_img">  <img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/buhg_5.png">
              <br><b>Удобная подготовка и отправка отчетности</b>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</section>

<section class="pred_info" >
  <div class="pred_title"> 1С:Зарплата и управление персоналом 8</div>
  <div class="pred_title_text"> 
    Программа массового назначения, позволяющая в комплексе автоматизировать задачи, связанные с расчетом заработной платы персонала и реализацией кадровой политики, с учетом требований законодательства и реальной практики работы предприятий. Она может успешно применяться в службах управления персоналом и бухгалтериях предприятий, а также в других подразделениях, заинтересованных в эффективной организации работы сотрудников, для управления человеческими ресурсами коммерческих предприятий различного масштаба.
  </div>
  <div id="dots3"></div>
  <a class="pred_btn" id="btn3" onclick="readMore3()" href="/podrazdely-predpriyatiya/index-pred4.php">Подробнее</a>
  <div class="content hidden" id="more3">
    <section  class="hidden_area"> 
      <div class="container">
        <div class="cont_title" style="text-align: center">Преимущества:</div>
        <div class="row"style="text-align: center">
          <div class="prem_text_2" style="padding: 1%"> 
          	<li>Все основные процессы управления персоналом, а также процессы кадрового учета, расчета зарплаты, планирования расходов на оплату труда, исчисления НДФЛ и страховых взносов.</li>
            <li>В программе поддерживаются электронные трудовые книжки, отчеты и справки в государственные органы и социальные фонды.</li>
            <li>Учтены требования законодательства, реальная практика работы предприятий и перспективные мировые тенденции развития подходов к управлению персоналом.</li>
            <li>Решения «1С:Зарплаты и управления персоналом 8» соответствуют требованиям Федерального закона от 27.07.2006 № 152-ФЗ «О защите персональных данных».</li>
            <li>Удобные и гибкие механизмы настройки отчетов позволяют получать полную и достоверную информацию в самых разных аналитических разрезах, для различных категорий пользователей: руководства, бухгалтерии, службы управления персоналом, кадровой службы и других.</li>
	    </div>
    </section>
    <div class="func_area" style="margin-left: 30%; margin-right: 30%; margin-top: 5%"> 
      <div class="func_title" style="color: #FF8080">Можно подключить</div>
      <div class="container">
        <div class="row">
          <div class="col func_text" style="text-align: center; color: #FFFFFF">
            1С-Отчетность<br>
            Информационная система 1С:ИТС<br>
            1С:ДиректБанк<br>
            1С:Кабинет сотрудника<br>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pred_info" >
  <div class="pred_title">1С:Управление нашей фирмой</div>
  <div class="pred_title_text">
    Готовое комплексное решение для управления и учета в малом бизнесе. Все что нужно, в одной программе: продажи, закупки, склад, производство, финансы, зарплата, анализ состояния компании, отчетность и CRM. Программа для бизнеса, который занимается оптовой, розничной и интернет-торговлей, услугами, сервисами, подрядами, мелкосерийным и позаказным производством. Решение не перегружено излишней функциональностью, его можно легко настроить под особенности организации управления и учета вашего бизнеса.
  </div>
  <div id="dots4"></div>
  <a class="pred_btn" id="btn4" onclick="readMore4()" href="/podrazdely-predpriyatiya/index-pred5.php">Подробнее</a> 
  <div class="content hidden" id="more4">
    <section> 
      <div class="func_title" style="color: #000000; margin-top: 3%; margin-bottom: 3%">Возможности</div>
      <div class="row">
        <div class="col">
          <div class="prem_text_2" style="color: #000000;font-size: 18px;"> 
            <li>ведение базы клиентов, банковских и кассовых операций</li>
            <li>расчеты с контрагентами, персоналом, бюджетом</li>
            <li>учет заказов, материалов, товаров, продукции и затрат, торговых операций, включая розничные продажи и подключение торгового оборудования</li>
            <li>учет заказов-нарядов, выполненных работ и оказанных услуг</li>
            <li>учет имущества, учет доходов, расходов, прибыли и убытков, капитала</li>
          </div>
        </div>
        <div class="col">
          <div class="prem_text_2" style="color: #000000; font-size: 18px;">
            <li>подготовка и сдача отчетности в контролирующие органы для ИП на УСН и ЕНВД</li>
            <li>планирование продаж, загрузки персонала и ключевых ресурсов</li>
            <li>ведение календарных графиков выполнения работ, отгрузки и поставок товаров и материалов</li>
            <li>контроль исполнения графиков и планов</li>
            <li>можно использовать для нескольких компаний и частных предпринимателей – независимых или работающих в рамках одного бизнеса</li>
          </div>
        </div>
      </div>
      <div class="for_area">
        <div class="for_title">Для кого:</div>
        <div class="container pred_for_cont">
          <div class="row">
            <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/5.png">
              <br>Розничные магазины
            </div>
            <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/torg_4.png">
              <br>Интернет-магазины
            </div>
            <div class="w-100"></div>
            <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/firm_3.png">
              <br>Оптовые компании
            </div>
            <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/firm_4.png">
              <br>Компании сферы услуг и работ
            </div>
            <div class="col pred_for_img"><img src="<?=SITE_TEMPLATE_PATH?>/predpriyatie/firm_5.png">
              <br>Производственные компании
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</section>

<section class="pred_info">
  <div class="pred_title">1С:Комплексная автоматизация</div>
  <div class="pred_title_text"> 
    Программа для построения на предприятии единой информационной системы, охватывающей основные задачи управления и учета. Данное решение позволяет автоматизировать важнейшие области бизнеса: бухгалтерию, торговлю, склад, расчет зарплаты, кадровый учет. Использование инструментов прикладного решения позволяет обеспечить слаженную работу как подразделений внутри организации, так и с внешним окружением (клиенты, поставщики, конкуренты).
  </div>
  <div id="dots5"></div>
  <a class="pred_btn" id="btn5" onclick="readMore5()" href="/podrazdely-predpriyatiya/index-pred6.php">Подробнее</a>   
  <div class="content hidden" id="more5">
    <section> 
      <div class="container">
        <div class="func_title" style="color: #FF8080; margin-top: 3%; margin-bottom: 3%"> <b>Для кого:</b></div>
        <div class="row"style="text-align: center">
          <div class="prem_text_2"> 
            <div style="color: #FF8080">Малый и средний бизнес —<br><br></div>
            ✔ торговые предприятия<br><br>
            ✔ небольшие производства<br><br>
            ✔ компании, оказывающие услуг<br><br>
          </div>
        </div>
      </div>
      <div class="container" style="margin-top:5% ">
        <div class="row">
          <div class="col rose">
            <div class="rose_title"style="text-align: center">Функциональность</div>
            <div class="rose_text">
              <li>Мониторинг и анализ целевых показателей</li>
              <li>Бюджетирование</li>
              <li>Казначейство</li>
              <li>Управление отношениями с клиентами (CRM)</li>
              <li>Управление продажами</li>
              <li>Учет в производстве</li>
              <li>Управление складом и запасами</li>
              <li>Управление закупками</li>
              <li>Управление затратами и расчет себестоимости</li>
              <li>Управление персоналом и расчет заработной платой</li>
              <li>Бухгалтерский и налоговый учет</li>
              <li>Совместное использование с 1С:Документооборот</li>
            </div>
          </div>
          <div class="col purple">
            <div class="purp_title"style="text-align: center">Преимущества</div>
            <div class="purp_text">
              <li>основные бизнес-процессы предприятия, «бесшовная» автоматизация и создание единого информационного пространства на технологической платформе «1С:Предприятие 8»</li>
              <li>четкое разграничение прав доступа к информации и выполнению действий — в зависимости от статуса сотрудника</li>
              <li>ведение управленческого и регламентированного (бухгалтерского, налогового) учета нескольких организаций, входящих в холдинг</li>
              <li>однократная регистрация хозяйственных операций и отражение в управленческом и регламентированном учете</li>
              <li>управленческий учет в любой выбранной валюте, бухгалтерский и налоговый учет в национальной валюте</li>
              <li>регламентированная отчетность для каждой организации формируется раздельно поддержка сервисов «1С-ЭДО», «1С-Такском», «1С-Отчетность»</li>
              <li>при необходимости дальнейшего наращивания функционала информационной системы возможен переход на «1С:ERP Управление предприятием»</li>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</section>

</section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>