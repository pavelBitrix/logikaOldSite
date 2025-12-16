<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "Разработка сайтов, веб");
$APPLICATION->SetTitle("Заявка на разработку сайта");
?>
<section class="container quiz_area">
    
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <h2 class="quiz_title">Выберите тип сайта:</h2>                      
                <div class="row quiz_area">
                    <div class="col-sm quiz_area"> 
                        <button class="btn btn-outline-danger" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Лендинг/Корпоративный сайт</button>
                    </div>   
  <!--
                              <div class="col-sm quiz_area"> 
                         <button class="btn btn-outline-danger" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Корпоративный сайт</button>
               
               </div>  -->
               
                    <div class="col-sm quiz_area"> 
                        <button class="btn btn-outline-danger" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="true">Интернет-магазин</button>            
                    </div>   
                </div>
        </div>
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <section class="quiz_area">
                    <form class="three_form" action="contact-form.php" method="post">
                        <div class="row">
                            <div class="col-6 quiz_content">
                                <div id="one" class="content">
                                    <h2>Представьтесь, укажите номер телефона и получите информацию о стоимости:	</h2>
                                    <p>
                                        <input class="form-control form-control-lg" type="text"  name="name" placeholder="Введите ваше имя" required />
                                    </p>
                                    <p>
                                        <input class="form-control form-control-lg" type="tel" name="tel" placeholder="Введите номер телефона, правильный формат: 89142221133" required />
                                    </p>
                                    <p>
                                        <input class="form-control form-control-lg " type="email" name="email" placeholder="Введите эл.почту, правильный формат: name@mail.ru" required />
                                    </p>
                                    <li><a id="link-five" href="#five" type="button" class="btn btn-outline-danger">Начать</a></li>
                                </div>
                            </div>
                            <div class="col-6 quiz_content" style="position:relative">
                                <div id="five" class="panel">
                                    <div class="content">
                                        <h2>Тематика <br> Вашего бизнеса:</h2> 
                                        <p>
                                            <input class="form-control form-control-lg" name="five" placeholder="Например, цветочный магазин" required >
                                        </p>
                                        <input class="form-control form-control-lg" name="bezspama" type="text" style="display:none" value="" />
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <li><a id="link-six" href="#six" type="button" class="btn btn-outline-danger dalee">Далее</a></li>
                                </div>

                                <div id="six" class="panel">
                                    <div class="content">
                                        <h2>Когда планируете <br> запустить сайт?</h2>
                                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg пример" name="six">
                                            <option selected>Откройте это меню выбора</option>
                                            <option value="2 – 3 недели">2 – 3 недели</option>
                                            <option value="1 месяц">1 месяц</option>
                                            <option value="2-3 месяца">2-3 месяца</option>
                                            <option value="другое">другое</option>
                                        </select>
                                        <li><a id="link-two" href="#two" type="button" class="btn btn-outline-danger dalee">Далее</a></li>   
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                
                                <div id="two" class="panel">
                                    <div class="content">
                                        <h2>Впишите пример сайта конкурента, <br> который схож с вашей задумкой (если есть):</h2>
                                        <p>
                                            <label for="website">Сайт:</label>
                                            <input class="form-control form-control-lg" type="text" name="website" placeholder="Например, http://logika1c.ru"/>
                                        </p>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 60%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <li><a id="link-three" href="#three" type="button" class="btn btn-outline-danger dalee">Далее</a></li>
                                </div>
                
                                <div id="three" class="panel">
                                    <div class="content">
                                        <h2>Для наполнения сайта <br> есть:</h2>
                                    </div>
                                    <p>
                                        <input class="form-control form-control-lg"  name="three" placeholder="Например, тексты, картинки, видео и так далее" />
                                    </p>
                                    <li><a id="link-four" href="#four" type="button" class="btn btn-outline-danger dalee">Далее</a></li>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                
                                <div id="four" class="panel">
                                    <div class="content">
                                        <h2>Размещение информации <br> на сайте:</h2>
                                        <p>
                                            <select class="form-select form-select-lg mb-3" name="four" aria-label=".form-select-lg пример">
                                                <option selected>Откройте это меню выбора</option>
                                                <option value="1">Компания Логика</option>
                                                <option value="2">Самостоятельно</option>
                                            </select>
                                        </p>
                                        <input class="form-control form-control-lg" name="bezspama" type="text" style="display:none" value="" />
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p>
                                            <button  class="btn btn-outline-danger" type="submit">Отправить сообщение</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                <section class="quiz_area_3">
                    <form class="three_form" action="contact-form3.php" method="post">
                        <div class="row">
                            <div class="col-6 quiz_content">
                                <div id="one" class="content">
                                    <h2>Представьтесь, укажите номер телефона и получите информацию о стоимости:	</h2>
                                    <p>
                                        <input class="form-control form-control-lg" type="text"  name="name" placeholder="Введите ваше имя" required />
                                    </p>
                                    <p>
                                        <input class="form-control form-control-lg" type="tel" name="tel" placeholder="Введите номер телефона, правильный формат: 89142221133" required />
                                    </p>
                                    <p>
                                        <input class="form-control form-control-lg " type="email" name="email" placeholder="Введите эл.почту, правильный формат: name@mail.ru" required />
                                    </p>
                                    <li><a id="link-one3" href="#two_3" type="button" class="btn btn-outline-danger">Начать</a></li>
                                </div>
                            </div>
                            <div class="col-6 quiz_content" style="position:relative">
                                <div id="two_3" class="panel_3">
                                    <div class="content">
                                        <h2>Тематика <br> Вашего бизнеса:</h2>
                                        <p>
                                            <input class="form-control form-control-lg" name="two_3" placeholder="Например, цветочный магазин" required >
                                        </p>
                                        <input class="form-control form-control-lg" name="bezspama" type="text" style="display:none" value="" />
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <li><a id="link-two3" href="#three_3" type="button" class="btn btn-outline-danger dalee">Далее</a></li>
                                </div>
                    
                                <div id="three_3" class="panel_3">
                                    <div class="content">
                                        <h2>Что Вы <br> продаете:</h2>                            
                                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg пример" name="three_3">
                                            <option selected>Откройте это меню выбора</option>
                                            <option value="Автотовары">Автотовары</option>
                                            <option value="Детские товары">Детские товары</option>
                                            <option value="Мебель">Мебель</option>
                                            <option value="Продукты питания">Продукты питания</option>
                                            <option value="другое">другое</option>
                                        </select>
                                         
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <li><a id="link-three3" href="#four_3" type="button" class="btn btn-outline-danger dalee">Далее</a></li>  
                                </div>
                    
                                <div id="four_3" class="panel_3">
                                    <div class="content">
                                        <h2>Когда планируете <br> запустить сайт?</h2>
                                                    
                                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg пример" name="four_4">
                                            <option selected>Откройте это меню выбора</option>
                                            <option value="2 – 3 недели">2 – 3 недели</option>
                                            <option value="1 месяц">1 месяц</option>
                                            <option value="2-3 месяца">2-3 месяца</option>
                                            <option value="другое"> другое
                                            </option>
                                        </select>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <li><a id="link-four4" href="#five_3" type="button" class="btn btn-outline-danger dalee">Далее</a></li>
                                </div>
                    
                                <div id="five_3" class="panel_3">
                                    <div class="content">
                                        <h2>Предполагаемое количество <br> товаров в вашем магазине (артикулов):</h2>
                                    </div>
                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg пример" name="five_3">
                                        <option selected>Откройте это меню выбора</option>
                                        <option value="Менее 100">Менее 100</option>
                                        <option value="До 5000">До 5000</option>
                                        <option value="До 45000">До 45000</option>
                                        </option>
                                    </select>
                                    <li><a id="link-five5" href="#six_3" type="button" class="btn btn-outline-danger dalee">Далее</a></li>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                    
                                <div id="six_3" class="panel_3">
                                    <div class="content">
                                        <h2>Вы продаете <br> товары:</h2>
                                            
                                        <p>
                                            <select class="form-select form-select-lg mb-3" name="six_3" aria-label=".form-select-lg пример">
                                                <option selected>Откройте это меню выбора</option>
                                                <option value="В розницу">В розницу</option>
                                                <option value="Оптом">Оптом</option>
                                                <option value="Розница = опт">Розница = опт</option>
                                            </select>
                                        </p>
                                        <input class="form-control form-control-lg" name="bezspama" type="text" style="display:none" value="" />
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 60%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <li><a id="link-five5" href="#seven_3" type="button" class="btn btn-outline-danger dalee">Далее</a></li>
                                
                                    </div>
                                </div>

                                <div id="seven_3" class="panel_3">
                                    <div class="content">
                                        <h2>Подключить <br> интеграцию с 1С?</h2>
                                            
                                        <p>
                                            <select class="form-select form-select-lg mb-3" name="seven_3" aria-label=".form-select-lg пример">
                                                <option selected>Откройте это меню выбора</option>
                                                <option value="Да">Да</option>
                                                <option value="Нет">Нет</option>
                                            </select>
                                        </p>
                                        <input class="form-control form-control-lg" name="bezspama" type="text" style="display:none" value="" />
                                        <li><a id="link-five5" href="#eight_3" type="button" class="btn btn-outline-danger dalee">Далее</a></li>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 70%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <div id="eight_3" class="panel_3">
                                    <div class="content">
                                        <h2>Необходимо ли <br> подключить интернет-эквайринг?</h2>
                                            
                                        <p>
                                            <select class="form-select form-select-lg mb-3" name="eight_3" aria-label=".form-select-lg пример">
                                                <option selected>Откройте это меню выбора</option>
                                                <option value="Да">Да</option>
                                                <option value="Нет">Нет</option>
                                            </select>
                                        </p>
                                        <input class="form-control form-control-lg" name="bezspama" type="text" style="display:none" value="" />
                                        <li><a id="link-five5" href="#eleven_3" type="button" class="btn btn-outline-danger dalee">Далее</a></li>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <div id="eleven_3" class="panel_3">
                                    <div class="content">
                                        <h2>Подключить систему <br> управления заказами в CRM?</h2>
                                            
                                        <p>
                                            <select class="form-select form-select-lg mb-3" name="eleven_3" aria-label=".form-select-lg пример">
                                                <option selected>Откройте это меню выбора</option>
                                                <option value="Да">Да</option>
                                                <option value="Нет">Нет</option>
                                            </select>
                                        </p>
                                        <input class="form-control form-control-lg" name="bezspama" type="text" style="display:none" value="" />
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p>
                                            <button  class="btn btn-outline-danger" type="submit">Оставить заявку</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>    
            </div>
        </div>
        <p class="site_text">
            <br>
            По всем интересующим Вас вопросам, мы готовы проконсультировать по телефонам:
            <br>
            <a class="links" href="tel:+7(4112)722511"> +7(4112)722511 </a> 
            <br>
            <a class="links" href="tel:+79142722511">  +79142722511 </a> 
            <br>
            а также ответить на все ваши письма по  электронной почте: <a class="links" href="mailto:logika1c@mail.ru">logika1c@mail.ru</a>.
        </p>
</section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>