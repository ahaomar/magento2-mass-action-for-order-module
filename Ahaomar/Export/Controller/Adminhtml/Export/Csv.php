<?php
/**
 * AHAOMAR - Subh-e-Noor Store
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the https://www.subhenoorstore.com/webcv at ahaomar@yahoo.com license that is
 * available through the world-wide-web at this URL:
 * https://www.subhenoorstore.com/
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    AHAOMAR
 * @package     Ahaomar_Core
 * @copyright   Copyright (c) Ahaomar (ahaomar@yahoo.com)
 * @license     As per Client
 */
  
namespace Ahaomar\Export\Controller\Adminhtml\Export;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
 
class Csv extends \Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction
{
    
    
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
    }
    
    protected function massAction(AbstractCollection $collection)
    {
      $orderIds = $collection->getAllIds(); // Get the selected orders
      
      foreach($orderIds as $orderId){
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderId);

        //Creating First Row you can change your colums as per your requirments
        $data[0] = array(
          'Reference2',
          'Fly K Discount 2',
          'Company',
          'Address 1',
          'Address 2',
          'Address 3',
          'City',
          'County',
          'Post Code',
          'E-mail',
          'Phone',
          'Mobile Phone',
          'Details1',
          'Details2',
          'Details7',
          'Details8',
          'Details9',
          'Details10',
          'Price  2',
          'Price  3'
        );
   
        if ($shippingAddress = $order->getShippingAddress()) {
          $shippingStreet = $shippingAddress->getStreet();
        }

        if($order->getCustomerId()){
          // if order is customer order
          $email = $order->getCustomerEmail();
        }else{
          // if order is guest order
          $email = $order->getShippingAddress()->getEmail();
        }

        $produtData = array(); 
        foreach ($order->getAllVisibleItems() as $itemId => $item) {
          $produtData[] = array("name"=> $item->getName(),"qty"=> $item->getQtyOrdered()); 
        }  
      
        $orderData = array(
          $order->getIncrementId(),
          $order->getShippingAddress()->getName(),
          $order->getShippingAddress()->getCompany(),
          $shippingStreet[0],
          $shippingStreet[1],
          $shippingStreet[2],
          $order->getShippingAddress()->getCity(),
          $order->getShippingAddress()->getRegion(),
          $order->getShippingAddress()->getPostcode(),
          $email,
          $order->getShippingAddress()->getTelephone(),
          $order->getShippingAddress()->getFax(),
          $produtData[0]["name"],
          $produtData[0]["qty"],
          $produtData[1]["name"],
          $produtData[1]["qty"],
          $produtData[2]["name"],
          $produtData[2]["qty"],        
          $order->getBaseSubtotal(),
          $order->getGrandTotal()
      );
      $data[]=$orderData; 
            
    }

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="ordersData.csv"');
    $fp = fopen('php://output', 'wb');
    foreach ($data as $line) {
      fputcsv($fp, $line, ',');
    }
      fclose($fp);  
    }  
   
}
 