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
		"MENU_CACHE_GET_VARS" => array(
		),
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
</script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/swiper/swiper.js?12"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/swiper/main_slider.js?1"></script>
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

</body>

</html>