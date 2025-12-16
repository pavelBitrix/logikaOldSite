<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1С:Управление нашей фирмой");
?>

<style>
    .row {
        display: flex;
        flex-wrap: wrap;
    }
    .col {
        flex: 1 1 50%;
        box-sizing: border-box;
        padding: 15px;
    }
    .prem_text_2 {
        color: #000000;
        font-size: 18px;
    }
    @media (max-width: 768px) {
        .col {
            flex: 1 1 100%;
        }
        .container.pred_for_cont, .col.pred_for_img {
            margin-left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .pred_title_text {
            padding: 1rem;
        }
    }
</style>


<div class="pred_title">1С:Управление нашей фирмой</div>
<div class="pred_title_text">
    Готовое комплексное решение для управления и учета в малом бизнесе. Все что нужно, в одной программе: продажи, закупки, склад, производство, финансы,
    зарплата, анализ состояния компании, отчетность и CRM. Программа для бизнеса, который занимается оптовой, розничной и интернет-торговлей, услугами,
    сервисами, подрядами, мелкосерийным и позаказным производством. Решение не перегружено излишней функциональностью, его можно легко настроить под особенности
    организации управления и учета вашего бизнеса.
</div>
<section>
    <div class="func_title" style="color: #000000; margin-top: 3%; margin-bottom: 3%">Возможности</div>
    <div class="row">
        <div class="col col-md-6">
            <div class="prem_text_2" style="color: #000000;font-size: 18px;">
                <li>ведение базы клиентов, банковских и кассовых операций</li>
                <li>расчеты с контрагентами, персоналом, бюджетом</li>
                <li>учет заказов, материалов, товаров, продукции и затрат, торговых операций, включая розничные продажи и подключение торгового
                    оборудования</li>
                <li>учет заказов-нарядов, выполненных работ и оказанных услуг</li>
                <li>учет имущества, учет доходов, расходов, прибыли и убытков, капитала</li>
            </div>
        </div>
        <div class="col col-md-6">
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
                <div class="col pred_for_img"><img src="/local/templates/logika1c/predpriyatie/5.png">
                    <br>Розничные магазины
                </div>
                <div class="col pred_for_img"><img src="/local/templates/logika1c/predpriyatie/torg_4.png">
                    <br>Интернет-магазины
                </div>
                <div class="w-100"></div>
                <div class="col pred_for_img"><img src="/local/templates/logika1c/predpriyatie/firm_3.png">
                    <br>Оптовые компании
                </div>
                <div class="col pred_for_img"><img src="/local/templates/logika1c/predpriyatie/firm_4.png">
                    <br>Компании сферы услуг и работ
                </div>
                <div class="col pred_for_img"><img src="/local/templates/logika1c/predpriyatie/firm_5.png">
                    <br>Производственные компании
                </div>
            </div>
        </div>
    </div>
</section>






<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>