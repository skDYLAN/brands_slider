<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>
<div class="c_title">Бренды</div>
<div class="c_brands">
    <div class="owl-carousel owl-brand owl_arrows">
        <?foreach ($arResult as $item):?>
        <div class="item">
            <div class="b_vertical">
                <div class="bv_middle">
                    <a href="<?=$item["LINK"]?>">
                        <img src="<?=$item["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$item["NAME"]?>" />
                    </a>
                </div>
            </div>
        </div>
        <?endforeach;?>
    </div>
</div>
