
<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Bitrix\Sale\Order;
use Bitrix\Sale;
use	\Bitrix\Main\Type\DateTime;


Loc::loadMessages(__FILE__);

class OrdersList extends \CBitrixComponent

{
    
    public function executeComponent()
    {
      if(!Loader::includeModule('sale')){
        return;
      }

      $this->arResult['ORDERS'] = $this->getOrders();
      
      
      $this->includeComponentTemplate();
      
    }

    public function getOrders():array
    {
      $dateStart = new DateTime();
      $dateStart->add('-3 days');
      $dateStart->setTime(23,59,59);
      $dateEnd = new DateTime();
      $dateEnd->add('-7 days');
      $dateEnd->setTime(0,0,0);
      
      $parameters = [
          'select' => ['ID','PAYED','DATE_INSERT','PRICE','CANCELED'],
          'filter' => [
                "<=DATE_INSERT" => $dateStart,
                ">=DATE_INSERT" => $dateEnd,
                "=CANCELED" => 'N',
          ],
          'order' => ["DATE_INSERT" => "ASC"]
      ];
      
      $dbRes = Order::getList($parameters);

      $result = [];

      while ($order = $dbRes->Fetch())
      {
        $order['DATE_INSERT'] = $order['DATE_INSERT']->format("d-m-Y");
        $paymentDeliveryInfo = $this->getOrderInfo($order['ID']);
        $result[] = array_merge($order,$paymentDeliveryInfo);
      }

      return $result;
    }

    public function getOrderInfo(int $orderId)
    {
      //получаем заказ
      $order = Order::load($orderId);

      if(empty($order)){
        return false;
      }

      // получение списка товаров из корзины
      $basket = $order->getBasket();

      if(empty($basket)){
        return false;
      }

      $basketItems = $basket->getListOfFormatText();

      $payments = [];
      $deliveries = [];

      foreach ($order->getPaymentCollection() as $payment) {
        $payments[] = $payment->getPaymentSystemName(); // название платежной системы
      }

      foreach($order->getShipmentCollection() as $shipment) { // перебираем отгрузки
        if(!$shipment->isSystem()){
          $deliveries[] = $shipment->getDelivery()->getName(); // получаем способ доставки
        }
      }

      $result = [
        'PAYMENTS'=>$payments,
        'DELIVERIES'=>$deliveries,
        'ITEMS'=>$basketItems,
      ];

      return $result;
    } 

}


