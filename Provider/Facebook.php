<?php
    namespace Gloo\FacebookSSO\Provider;

    use League\OAuth2\Client\Entity;
    use League\OAuth2\Client\Provider\AbstractProvider;
    use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
    use League\OAuth2\Client\Token\AccessToken;
    use Psr\Http\Message\ResponseInterface;


    class Facebook extends AbstractProvider {

        const BASE_FACEBOOK_URL = 'https://www.facebook.com/';

        const BASE_GRAPH_URL = 'https://graph.facebook.com/';

        protected $ApiVersion = "v2.10";

        public function checkResponse(ResponseInterface $response, $data){
            if(!empty($data['error'])){
                $message = $data['error']['type']. ":".$data['error']['message'];
                throw new IdentityProviderException($message, $data['error']['code'], $data);
            }
        }


        protected function getAuthorizationParameters(array $options)
        {
            $params = parent::getAuthorizationParameters($options);
            $params["client_id"] = $options["client_id"];
            $params["redirect_uri"] = $options["redirect_uri"];
            $params["scope"] = $options["scope"];

            return $params;
        }

        public function getDefaultScopes(){
            return ['public_profile', 'email'];
        }

        public function getBaseAuthorizationUrl(){
            return $this->getBaseFacebookUrl().$this->ApiVersion."/dialog/oauth";
        }

        public function getBaseAccessTokenUrl(array $params){
            return $this->getBaseGraphUrl().$this->ApiVersion.'/oauth/access_token';
        }

        protected function getAccessTokenMethod()
        {
            return self::METHOD_GET; //Facebook uses a GET to request an ACCESS_TOKEN
        }


        protected function getContentType(ResponseInterface $response)
        {
            $type = parent::getContentType($response);
            if (strpos($type, 'javascript') !== false) {
                return 'application/json';
            }
            if (strpos($type, 'plain') !== false) {
                return 'application/x-www-form-urlencoded';
            }
            return $type;
        }


        public function getBaseFacebookUrl(){
            return static::BASE_FACEBOOK_URL;
        }

        public function getBaseGraphUrl(){
            return self::BASE_GRAPH_URL;
        }

        protected function createResourceOwner(array $response, AccessToken $token)
        {
            return new FacebookOwner($response);
        }

        public function getResourceOwnerDetailsUrl(AccessToken $token){}

        public function getAccessToken($grant = 'authorization_code', array $params = [])
        {
            if (isset($params['refresh_token'])) {
                throw new FacebookProviderException('Facebook does not support token refreshing.');
            }
            return parent::getAccessToken($grant, $params);
        }

    }