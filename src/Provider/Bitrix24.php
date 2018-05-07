<?
namespace Povit\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class Bitrix24 extends AbstractProvider {

    protected $baseUrl;
    
    public function __construct($options = array()) {
        parent::__construct($options);
        if(array_key_exists('baseUrl', $options)) {
            $this->baseUrl = $options['baseUrl'];
        }
    }
    
    public function getBaseAuthorizationUrl() {
        return $this->baseUrl.'/oauth/authorize';
    }
    
    public function getBaseAccessTokenUrl(array $params) {
        return 'https://oauth.bitrix.info/oauth/token';
    }
    
    public function getResourceOwnerDetailsUrl(AccessToken $token) {
        return $this->baseUrl.'/rest/user.current?auth='.$token;
    }
    
    protected function getDefaultScopes() {
        return array();
    }
    
    protected function checkResponse(ResponseInterface $response, $data) {
        if(! empty($data['error'])) {
            throw new IdentityProviderException($data['error'], $response->getStatusCode(), $response);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token) {
		return new Bitrix24ResourceOwner($response);
    }

    protected function getAccessTokenMethod() {
        return self::METHOD_GET;
    }
}
