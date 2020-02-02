<?php
namespace MRYM\SalesManager\Controller\Message;

use Magento\Backend\App\Area\FrontNameResolver;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\UrlFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class CreatePost extends Action implements CsrfAwareActionInterface, HttpPostActionInterface
{
    protected $urlModel;

    private $formKeyValidator;

    private $session;

    private $col;

    private $transportBuilder;

    private $store;

    private $scopeConfig;

    private $managerItem;

    private $senderResolver;

    public function __construct(
        Context $context,
        StoreManagerInterface $store,
        TransportBuilder $transportBuilder,
        \MRYM\SalesManager\Model\ResourceModel\Manager\Collection $col,
        \MRYM\SalesManager\Model\ItemFactory $item,
        Session $customerSession,
        UrlFactory $urlFactory,
        ScopeConfigInterface $scopeConfig,
        SenderResolverInterface $senderResolver = null,
        Validator $formKeyValidator = null
    ) {
        $this->urlModel = $urlFactory->create();
        $this->session = $customerSession;
        $this->col = $col;
        $this->store = $store;
        $this->managerItem = $item;
        $this->scopeConfig = $scopeConfig;
        $this->transportBuilder = $transportBuilder;
        $this->senderResolver = $senderResolver ?: ObjectManager::getInstance()->get(SenderResolverInterface::class);
        $this->formKeyValidator = $formKeyValidator ?: ObjectManager::getInstance()->get(Validator::class);

        parent::__construct($context);
    }

    public function execute()
    {
        $redirect = $this->getRequest()->getParam('redirect_url');

        if (!$this->getRequest()->isPost() || !$this->formKeyValidator->validate($this->getRequest())) {
            return $this->resultRedirectFactory->create()->setUrl($redirect);
        }

        $country = $this->getRequest()->getParam('country_id');
        $region = $this->getRequest()->getParam('region_id');
        $position = '';
        if (!empty($country)) {
            $position = $country;
        }
        if (!empty($region)) {
            $position .= ':' . $region;
        }

        try {
            $collection = $this->col->addPositionFilter($position);
            $message = $this->getRequest()->getParam('message');
            $storeId = $this->store->getStore()->getId();
            /** @var Conversion $conversion */
            $managerItem = $this->managerItem->create();
            $managerItem->addData([
                'position' => $position,
                'message' => $message
            ]);
            $managerItem->save();

            foreach ($collection as $manager) {
                $this->sendEmailTemplate('Sales Team', $message, $manager->getData('email'),$storeId);
            }

            $this->messageManager->addSuccessMessage(__('Your letter has been sent'));
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('We can\'t send letter.'));
        }

        $this->session->setCustomerFormData($this->getRequest()->getPostValue());
        return $this->resultRedirectFactory->create()->setUrl($redirect);
    }

    private function sendEmailTemplate($name, $message, $email = null, $storeId = null)
    {
        $transport = $this->transportBuilder->setTemplateIdentifier('sales_manager_email_template')
            ->setTemplateOptions(['area' => 'frontend', 'store' => $storeId])
            ->setTemplateVars(['message' => $message])
            ->setFromByScope('general')
            ->addTo($email, $name)
            ->getTransport();

        $transport->sendMessage();
    }

    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}