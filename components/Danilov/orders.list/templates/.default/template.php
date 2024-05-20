<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>

<div class="container">
    <h1 class="text-center my-4"><?$APPLICATION->ShowTitle()?></h1>
    
    <div class="row mb-4">
        <div class="col text-left">
            <label for="status"><?=GetMessage("FILTER")?></label>
            <select id="status" class="form-control d-inline-block w-auto ml-2">
                <option value="all"><?=GetMessage("ALL")?></option>
                <option value="paid"><?=GetMessage("PAYED")?></option>
                <option value="unpaid"><?=GetMessage("UNPAYED")?></option>
            </select>
        </div>
    </div>
    
    <div class="order-list">
        <?foreach($arResult['ORDERS'] as $key => $order){?>
            <div class="order" data-paid="<?=$order['PAYED']?>">
                <h2><?=GetMessage("ORDER")?> #<?=$key+1?></h2>
                <div class="date"><?=GetMessage("DATE_CREATE")?>: <?=$order['DATE_INSERT']?></div>
                <div class="total"><?=GetMessage("PRICE")?>: <?=(int)$order['PRICE']?> <?=GetMessage("RUB")?></div>
                <div><?=GetMessage("DELIVERY")?>:</div>
                <ul class="delivery-methods">
                    <?foreach($order['DELIVERIES'] as $delivery){?>
                        <li><?=$delivery?></li>
                    <?}?>
                </ul>
                <div><?=GetMessage("PAY_SYS")?>:</div>
                <ul class="payment-systems">
                    <?foreach($order['PAYMENTS'] as $paySys){?>
                        <li><?=$paySys?></li>
                    <?}?>
                </ul>
                <div><?=GetMessage("ITEMS")?>:</div>
                <ul class="items">
                    <?foreach($order['ITEMS'] as $item){?>
                        <li><?=$item?></li>
                    <?}?>
                </ul>

            </div>
        <?}?>
    </div>
</div>



