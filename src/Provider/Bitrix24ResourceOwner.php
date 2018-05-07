<?
namespace Povit\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class Bitrix24ResourceOwner implements ResourceOwnerInterface {

	private $response;

    public function __construct(array $response) {
		$this->response = $response['result'];
    }

	public function getId() {
		return $this->response['ID'];
	}

	public function toArray() {
		return $this->response;
	}
}
