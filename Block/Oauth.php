<?php

namespace Gloo\FacebookSSO\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;

class Oauth extends Template
{
    protected $scopeConfig;
    public function __construct(
        Context $context
    )
    {
        $this->scopeConfig = $this->_scopeConfig;
        parent::__construct($context);
    }

}