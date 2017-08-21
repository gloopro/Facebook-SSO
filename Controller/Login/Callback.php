<?php

namespace Gloo\FacebookSSO\Controller\Login;


use Gloo\FacebookSSO\Helper\Data;
use Gloo\FacebookSSO\Provider\FacebookOwner;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Magento\Framework\App\Action\Action;
use Gloo\FacebookSSO\Provider\Facebook;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Callback extends Action
{
    protected $resultPageFactory;
    protected $dataHelper;
    protected $customerSession;

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
        $provider = new Facebook([
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
            $this->_redirect("/fbsso/oauth/index");
        }/**elseif(empty($this->getRequest()->getParam("state")) || ($this->getRequest()->getParam("state") !== $this->getOauthState())) {
            $this->unsetOauthState();
            echo ("Invalid State");
        }**/

        $token = $provider->getAccessToken('authorization_code', [
            'code' => $this->getRequest()->getParam("code")
        ]);

        echo $this->dataHelper->getConfig(DATA::$SCOPE);

        $facebook_app_secret = $this->dataHelper->getConfig(Data::$APP_SECRET);
        $baseUrl = 'https://graph.facebook.com/v2.10';

        $params = http_build_query([
            'fields' => 'id, name, first_name, middle_name, last_name, email, birthday',
            'limit' => '5',
            'access_token' => $token->getToken(),
            'appsecret_proof' => hash_hmac('sha256', $token->getToken(), $facebook_app_secret)
        ]);

        $response = file_get_contents($baseUrl.'/me?'.$params);

        var_dump($response);
        $data = json_decode($response, true);
        var_dump($data);

        return $this->resultPageFactory->create();
    }
}