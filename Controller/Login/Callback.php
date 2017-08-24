<?php

namespace Gloo\FacebookSSO\Controller\Login;

use Gloo\FacebookSSO\Helper\Data;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Callback extends Action
{
    protected $resultPageFactory;
    protected $dataHelper;
    protected $customerSession;

    const LIMIT = '5';
    const FIELDS = 'id, name, first_name, middle_name, last_name, email, birthday';


    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Customer\Model\Session $customerSession,
        Data $dataHelper
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->dataHelper = $dataHelper;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function setOauthState($state){
        return $this->customerSession->setOauthState($state);
    }

    public function getOauthState(){
        return $this->customerSession->getOauthState();
    }

    public function unsetOauthState(){
        return $this->customerSession->unsOauthState();
    }

    public function execute()
    {
        $provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId' =>  $this->dataHelper->getConfig(Data::$APP_ID),
            'clientSecret' => $this->dataHelper->getConfig(Data::$APP_SECRET),
            'redirectUri' =>   $this->dataHelper->getConfig(Data::$REDIRECT_URI),
            'graphApiVersion' => 'v2.10',
            'scope' => $this->dataHelper->getConfig(DATA::$SCOPE)
        ]);

        if(!$this->getRequest()->getParam("code")){
            $authUrl = $provider->getAuthorizationUrl([
                'scope' => $this->dataHelper->getConfig("scope"),
            ]);
            $this->setOauthState($provider->getState());
            $this->_redirect($authUrl);
        }
        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $this->getRequest()->getParam("code")
            ]);

            $resourceOwner = $provider->getResourceOwner($token);
            echo json_encode($resourceOwner->toArray());


        }catch(IdentityProviderException $e){
            echo $e->getMessage();
        }

        //return $this->resultPageFactory->create();
    }
}