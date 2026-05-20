</main>
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<footer>
    <div class="bx-footer-section">
        <? $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "logika1c",
            array(
                "ROOT_MENU_TYPE" => "bottom",
                "MAX_LEVEL" => "1",
                "MENU_CACHE_TYPE" => "N",
                "CACHE_SELECTED_ITEMS" => "N",
                "MENU_CACHE_TIME" => "36000000",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => array(),
                "COMPONENT_TEMPLATE" => "logika1c",
                "CHILD_MENU_TYPE" => "left",
                "USE_EXT" => "N",
                "DELAY" => "N",
                "ALLOW_MULTI_SELECT" => "N",
                "MENU_THEME" => "site",
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO"
            ),
            false,
            array(
                "ACTIVE_COMPONENT" => "Y"
            )
        ); ?>

    </div>
    </div>
</footer>
<script>
    BX.ready(function() {
        var upButton = document.querySelector('[data-role="eshopUpButton"]');
        BX.bind(upButton, "click", function() {
            var windowScroll = BX.GetWindowScrollPos();
            (new BX.easing({
                duration: 500,
                start: {
                    scroll: windowScroll.scrollTop
                },
                finish: {
                    scroll: 0
                },
                transition: BX.easing.makeEaseOut(BX.easing.transitions.quart),
                step: function(state) {
                    window.scrollTo(0, state.scroll);
                },
                complete: function() {}
            })).animate();
        })
    });



    ;
    (function($) {
        // Функция, которая ищет формы и вставляет чекбокс
        function initPdConsent() {
            const linkConsent = '/pers_info/';
            const linkPolicy = '/policy/';
            const targetForms = '#ticketForm, form[name="form_auth"], form[name="bform"]';

            $(targetForms).each(function() {
                const $form = $(this);

                // ЗАЩИТА: Если чекбокс уже есть в этой форме, пропускаем её
                if ($form.find('.pd-consent-block').length > 0) {
                    return;
                }

                // Генерируем случайный ID, чтобы при динамическом обновлении ID всегда были уникальными
                const uniqueId = 'pd_consent_checkbox_' + Math.random().toString(36).substr(2, 9);

                const checkboxHtml = `
                <div class="form-group form-check pd-consent-block" style="text-align: left; margin: 20px 0;">
                    <input type="checkbox" class="form-check-input pd-consent-checkbox" id="${uniqueId}" name="pd_consent" value="Y" required>
                    <label class="form-check-label" for="${uniqueId}" style="font-size: 14px; line-height: 1.4; cursor: pointer; font-weight: normal;">
                        Я даю <a href="${linkConsent}" target="_blank" style="text-decoration: underline !important;">согласие на обработку персональных данных</a> 
                        на условиях <a href="${linkPolicy}" target="_blank" style="text-decoration: underline !important;">Политики обработки персональных данных</a>.
                    </label>
                    <div class="invalid-feedback pd-consent-error" style="display: none; color: #dc3545; font-size: 80%; margin-top: 5px;">
                        Для отправки необходимо ваше согласие.
                    </div>
                </div>
            `;

                // Умная вставка
                let $insertTarget;
                if ($form.attr('id') === 'ticketForm') {
                    $insertTarget = $form.find('#error');
                    if ($insertTarget.length) $insertTarget.before(checkboxHtml);
                } else {
                    $insertTarget = $form.find('input[type="submit"], button[type="submit"]').closest('div');
                    if ($insertTarget.length) $insertTarget.before(checkboxHtml);
                }

                const $checkbox = $form.find('.pd-consent-checkbox');
                const $submitBtn = $form.find('button[type="submit"], input[type="submit"]');
                const $errorMsg = $form.find('.pd-consent-error');

                if (!$checkbox.length || !$submitBtn.length) return;

                // Блокируем кнопку
                $submitBtn.prop('disabled', true).css({
                    'opacity': '0.5',
                    'cursor': 'not-allowed'
                });

                // Разблокируем при клике
                $checkbox.on('change', function() {
                    if ($(this).is(':checked')) {
                        $submitBtn.prop('disabled', false).css({
                            'opacity': '1',
                            'cursor': 'pointer'
                        });
                        $checkbox.removeClass('is-invalid');
                        $errorMsg.hide();
                    } else {
                        $submitBtn.prop('disabled', true).css({
                            'opacity': '0.5',
                            'cursor': 'not-allowed'
                        });
                    }
                });

                // Абсолютная защита (Capturing phase)
                // Используем атрибут data-pd-listener, чтобы не повесить событие дважды при обновлениях
                if (!$form[0].hasAttribute('data-pd-listener')) {
                    $form[0].addEventListener('submit', function(e) {
                        const cb = document.getElementById(uniqueId);
                        if (cb && !cb.checked) {
                            e.preventDefault();
                            e.stopPropagation();
                            e.stopImmediatePropagation();

                            $checkbox.addClass('is-invalid');
                            $errorMsg.show();
                        }
                    }, true);

                    $form[0].setAttribute('data-pd-listener', 'true');
                }
            });
        }

        $(document).ready(function() {
            // 1. Запускаем первый раз при загрузке страницы
            initPdConsent();

            // 2. Создаем "Наблюдателя" (MutationObserver) за изменениями в DOM
            const observer = new MutationObserver(function(mutations) {
                let shouldReInit = false;
                for (let mutation of mutations) {
                    // Если на страницу были добавлены новые элементы (например, обновилась форма через AJAX)
                    if (mutation.addedNodes.length > 0) {
                        shouldReInit = true;
                        break;
                    }
                }

                if (shouldReInit) {
                    // Пытаемся заново инициализировать чекбоксы (защита от дублей уже встроена внутри функции)
                    initPdConsent();
                }
            });

            // Начинаем следить за всем телом документа
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });

    })(jQuery);
</script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> -->
<script src="<?= SITE_TEMPLATE_PATH ?>/swiper/swiper.js?12"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/swiper/main_slider.js?1"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/swiper/jquery.min.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/about/about.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/modal.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/predpriyatie/predpriyatie.js"></script>
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>
<script>
    $("#soa-property-98").suggestions({
        token: "7c8a66eda266bd8e69c822c69fcf0363cbc872a8",
        type: "ADDRESS",
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
            console.log(suggestion);
        }
    });

    // document.addEventListener("DOMContentLoaded", function () {
    //   var header = document.querySelector('.bx-header');

    //   window.addEventListener('scroll', function () {
    //     if (window.scrollY > 0) {
    //       header.classList.add('scrolled');
    //     } else {
    //       header.classList.remove('scrolled');
    //     }
    //   });
    // });
</script>


<div id="cookieConsentBanner" class="fixed-bottom bg-dark text-white p-3 shadow-lg" style="display: none; z-index: 9999;">
    <div class="container">
        <div class="row align-items-center">
            <!-- <div class="col-md-8 col-sm-12 mb-2 mb-md-0 text-md-left text-center" style="font-size: 14px;">
                Мы используем файлы cookie и сервис аналитики Яндекс.Метрика для улучшения работы сайта и сбора статистики.
                Вы можете согласиться на сбор данных или отказаться от него.
                Подробнее в <a href="/yandex-policy/" target="_blank" class="text-info">Политике обработки данных</a>.
            </div> -->
            <div class="col-md-8 col-sm-12 mb-2 mb-md-0 text-md-left text-center" style="font-size: 14px;">
                Мы используем cookie-файлы и сервис аналитики Яндекс.Метрика для улучшения работы сайта и сбора статистики. 
                Вы можете согласиться на сбор данных или отказаться от него. 
                <a href="/yandex-policy/" target="_blank" class="text-info">Подробнее об условиях использования сервиса читайте в Согласии на обработку персональных данных посредством сервиса «Яндекс.Метрика»</a>
                и <a href="/policy/" target="_blank" class="text-info">Политике обработки данных.</a>
               
            </div>
            <div class="col-md-4 col-sm-12 d-flex align-items-center justify-content-center justify-content-md-end mt-3 mt-md-0">
                <button id="btnAcceptCookies" class="btn btn-success btn-sm mr-2 px-3">Согласиться</button>
                <button id="btnDeclineCookies" style="margin-left:1rem !important;" class="btn btn-outline-light btn-sm px-3">Отказаться</button>
            </div>
        </div>
    </div>
</div>

<script>
    ;
    (function($) {
        $(document).ready(function() {
            const banner = $('#cookieConsentBanner');
            const consentKey = 'yandex_metrica_consent';

            // Функция инициализации реальной Метрики (пока пустая)
            function loadYandexMetrica() {
                console.log('✅ Пользователь согласился. Здесь должен запускаться код Яндекс.Метрики.');

            }

            // 1. Проверяем, делал ли пользователь выбор ранее
            const userChoice = localStorage.getItem(consentKey);

            if (userChoice === 'accepted') {
                // Если уже соглашался ранее — просто тихо грузим метрику, баннер не показываем
                loadYandexMetrica();
            } else if (userChoice === 'declined') {
                // Если отказался — ничего не делаем, метрику не грузим
                console.log('❌ Пользователь отказался от cookies. Метрика отключена.');
            } else {
                // Если выбора нет — показываем баннер с легкой анимацией
                banner.slideDown(300);
            }

            // 2. Обработка клика "Согласиться"
            $('#btnAcceptCookies').on('click', function() {
                localStorage.setItem(consentKey, 'accepted'); // Запоминаем выбор
                banner.slideUp(300); // Скрываем баннер
                loadYandexMetrica(); // Запускаем счетчик прямо сейчас
            });

            // 3. Обработка клика "Отказаться"
            $('#btnDeclineCookies').on('click', function() {
                localStorage.setItem(consentKey, 'declined'); // Запоминаем отказ
                banner.slideUp(300); // Скрываем баннер
                console.log('❌ Выбор сохранен: отказ от cookies.');
                // Метрику не загружаем
            });
        });
    })(jQuery);
</script>

</body>

</html>