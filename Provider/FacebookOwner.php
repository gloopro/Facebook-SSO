<?php
    namespace Gloo\FacebookSSO\Provider;

    use League\OAuth2\Client\Provider\ResourceOwnerInterface;

    class FacebookOwner implements ResourceOwnerInterface  {

        protected $response;

        public function __construct(array $response)
        {
            $this->response = $response;
        }

        /**
         * Returns the user ID as a string if present
         * @return string|null
         */
        public function getId()
        {
            return $this->getField("id");
        }

        /**
         *  Returns the name of the user if present as a string
         * @return string|null
         */
        public function getName(){
            $this->getField("name");
        }


        /**
         * Returns the first name for the user as a string if present.
         *
         * @return string|null
         */
        public function getFirstName()
        {
            return $this->getField('first_name');
        }
        /**
         * Returns the last name for the user as a string if present.
         *
         * @return string|null
         */
        public function getLastName()
        {
            return $this->getField('last_name');
        }

        /**
         * Returns the email for the user as a string if present.
         *
         * @return string|null
         */
        public function getEmail()
        {
            return $this->getField('email');
        }

        public function isDefaultPicture()
        {
            return $this->getField('is_silhouette');
        }
        /**
         * Returns the profile picture of the user as a string if present.
         *
         * @return string|null
         */
        public function getPictureUrl()
        {
            return $this->getField('picture_url');
        }



        /**
         *  Get user data as an array
         * @return array
         */
        public function toArray()
        {
            return $this->response;
        }


        /**
         * Returns a field from the Graph node data.
         *
         * @param string $key
         *
         * @return mixed|null
         */
        private function getField($key)
        {
            return isset($this->response[$key]) ? $this->response[$key] : null;
        }
    }