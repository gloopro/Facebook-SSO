<?php
    namespace Gloo\FacebookSSO\Factory;

    use Magento\Framework\ObjectManagerInterface;

    class FacebookFactory {
        protected $objectManager;
        protected $instanceName;

        public function __construct(ObjectManagerInterface $objectManager, $instanceName="\\League\\OAuth2\\Client\\Provider\\Facebook")
        {
            $this->objectManager = $objectManager;
            $this->instanceName = $instanceName;
        }

        public function create(array $array = array()){
            return $this->objectManager->create($this->instanceName,$array);
        }
    }