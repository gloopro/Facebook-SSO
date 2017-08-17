<?php
    namespace Gloo\FacebookSSO\Provider;

    use League\OAuth2\Client\Entity;
    use League\OAuth2\Client\Provider\AbstractProvider;
    use League\OAuth2\Client\Token\AccessToken;
    use Psr\Http\Message\ResponseInterface;


    class Facebook extends AbstractProvider {

        public function checkResponse(ResponseInterface $response, $data){

        }
        public function createResourceOwner(array $response, AccessToken $token) {

        }
        public function getResourceOwnerDetailsUrl(AccessToken $token){}


        public function getAuthorizationUrl(array $options = []){
            return "https://www.facebook.com/v2.10/dialog/oauth";

        }

        protected function getAuthorizationParameters(array $options)
        {
            $params = parent::getAuthorizationParameters($options);
            $params["client_id"] = $options["client_id"];
            $params["redirect_uri"] = $options["redirect_uri"];

            return $params;
        }

        public function getDefaultScopes(){
            return [];
        }

        public function getBaseAuthorizationUrl(){
            return "https://www.facebook.com/v2.10/dialog/oauth";
        }

        public function getBaseAccessTokenUrl(array $params){
            $url = "https://graph.facebook.com/v2.10/oauth/access_token";
            return $url;
        }

        protected function getAccessTokenMethod()
        {
            return self::METHOD_GET; //Facebook uses a GET to request an ACCESS_TOKEN
        }


    }