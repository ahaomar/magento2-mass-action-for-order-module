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
namespace Ahaomar\Export\Controller\Adminhtml\Order;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Sales\Api\OrderManagementInterface;

class MassDelete extends \Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction
{

    protected $orderManagement;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        OrderManagementInterface $orderManagement
    ) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
        $this->orderManagement = $orderManagement;
    }

    protected function massAction(AbstractCollection $collection)
    {
        $orderIds = $collection->getAllIds(); // Get the selected orders
        var_dump($orderIds);
        die("ok");
    }
}