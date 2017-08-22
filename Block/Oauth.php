<?php

namespace Gloo\FacebookSSO\Block;

use Gloo\FacebookSSO\Helper\Data;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;

class Oauth extends Template
{
    protected $dataHelper;

    protected $scopeConfig;
    public function __construct(
        Context $context,
        Data $dataHelper
    )
    {
        $this->scopeConfig = $this->_scopeConfig;
        $this->dataHelper = $dataHelper;
        parent::__construct($context);
    }

    private function getOAuthRedirectUri(){
        return $this->dataHelper->getConfig(Data::$REDIRECT_URI);
    }

    private function getOAuthAppID(){
        return $this->dataHelper->getConfig(Data::$APP_ID);
    }

    public function getAuthenticationURL(){
        $client_id = $this->getOAuthAppID();
        $redirect_uri = $this->getOAuthRedirectUri();
        $url = "https://www.facebook.com/v2.10/dialog/oauth?client_id={$client_id}&redirect_uri={$redirect_uri}";
        return $url;
    }

}