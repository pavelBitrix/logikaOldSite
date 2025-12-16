<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "CRM Bitrix");

$APPLICATION->SetTitle("1C Предприятие");
?>
<section class="main_about d-none d-md-block" name="top">
	<canvas id="animated_banner" style="margin: 0 auto; 
background: linear-gradient(81.87deg, #ED9E1D -5.31%, #FFD124 67.68%, #EFE535 104.65%);"></canvas>
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
					start: "#B1720B",
					middle: "#BC7500",
					end: "#FDD426"
				},
			},
			{
				x: canvas.width - 150,
				y: 100,
				r: 100,
				xVelocity: -0.1,
				yVelocity: 0.1,
				color: {
					start: "#B1720B",
					middle: "#BC7500",
					end: "#FDD426"
				},
			},
			{
				x: canvas.width - 150,
				y: canvas.height - 150,
				r: 60,
				xVelocity: 0.07,
				yVelocity: 0.1,
				color: {
					start: "#B1720B",
					middle: "#BC7500",
					end: "#FDD426"
				},
			},
			{
				x: 50,
				y: 50,
				r: 50,
				xVelocity: -0.1,
				yVelocity: 0.1,
				color: {
					start: "#B1720B",
					middle: "#BC7500",
					end: "#FDD426"
				},
			},
			{
				x: canvas.width - 100,
				y: canvas.height - 250,
				r: 30,
				xVelocity: -0.1,
				yVelocity: 0.1,
				color: {
				    start: "#B1720B",
					middle: "#BC7500",
					end: "#FDD426"
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
	<div>
	ЗАБОТА ОБ 
УЧЕТЕ - В РУКАХ У ПРОФЕССИОНАЛОВ!
	</div>
</section>
<section class="mainarea1c">
<div class="container">
<h2>Услуги</h2>
    <div class="text">
        ООО "Логика" является официальным партнером сети "1С: БухОбслуживание".
        "1C: БухОбслуживание" - это сеть партнеров фирмы "1C", оказывающих услуги по ведению бухгалтерского, налогового, кадрового учета и расчета заработной платы малому бизнесу по единому стандарту, разработанному "1C". </div>
    <div class="text">   
        <strong >Освободите время для развития бизнеса, а профессионалы приведут ваш учет и документы к безупречному состоянию!</strong> </div>
    <div class="row justify-content-evenly">
            <div class="box_site_ box-1 col-3">
              <div class="cover"><img class="uslugi_card" src="<?=SITE_TEMPLATE_PATH?>/1c/2-1.png" alt=""></div>
              <!-- <button><div></div></button> -->
              <p class="card_text"> <strong>Качество обслуживания.</strong> <br> Единые стандарты обслуживания, разработанные 1С.</p>
          </div>
          <div class="box_site_ box-1 col-3">
              <div class="cover"><img class="uslugi_card" src="<?=SITE_TEMPLATE_PATH?>/1c/2-2.png" alt=""></div>
              <!-- <button><div></div></button> -->
              <p class="card_text"> <strong>Финансовые гарантии.</strong> <br> Несем полную ответственность за результат.</p>
          </div>
    </div>
    <div class="row justify-content-evenly">
            <div class="box_site_ box-1 col-3">
              <div class="cover"><img class="uslugi_card" src="<?=SITE_TEMPLATE_PATH?>/1c/2-3.png" alt=""></div>
              <!-- <button><div></div></button> -->
              <p class="card_text"> <strong>Индивидуальный подход.</strong> <br> Подстраиваем под подтребности Вашего бизнеса.</p>
          </div>
          <div class="box_site_ box-1 col-3">
              <div class="cover"><img class="uslugi_card" src="<?=SITE_TEMPLATE_PATH?>/1c/2-4.png" alt=""></div>
              <!-- <button><div></div></button> -->
              <p class="card_text"> <strong>Безопасность и конфиденциальность.</strong> <br> Данные хранятся на защищенных серверах.</p>
          </div>
    </div>
<div class="container mb5">
  <div class="row g-2">
    <div class="col-lg-3">
      <div class="p-3 box1c"><div class="textBox1c">Чат консультации по бухгалтерскому учету</div></div>
    </div>
    <div class="col-lg-3">
      <div class="p-3 box1c"><div class="textBox1c">Восстановление бухгалтерского учета</div></div>
    </div>
    <div class="col-lg-3">
      <div class="p-3 box1c"><div class="textBox1c">Формирование и отправка нулевой и готовой отчетности</div></div>
    </div>
    <div class="col-lg-3 box1c">
      <div class="p-3"><div class="textBox1c">Абонентское обслуживание</div></div>
    </div>
  </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>