<?php namespace NicolasMugnier\AdvertisingApi;

/**
 * Class Client
 *
 * @package   NicolasMugnier\AdvertisingApi
 * @author    Nicolas Mugnier <mugnier.nicolas@gmail.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class Client {

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var string
     */
    protected $secretAccessKey;

    /**
     * Client constructor.
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(
        \GuzzleHttp\Client $client
    )
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    abstract function search();

    /**
     * @param $responseGroup
     * @return $this
     */
    public function setResponseGroup($responseGroup){
        $this->params['ResponseGroup'] = $responseGroup;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getResponseGroup(){
        return isset($this->params['ResponseGroup']) ? $this->params['ResponseGroup'] : null;
    }

    /**
     * @param $awsAccessKey
     * @return \NicolasMugnier\AdvertisingApi\Client
     */
    public function setAwsAccessKey($awsAccessKey){
        $this->params['AWSAccessKeyId'] = $awsAccessKey;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAwsAccessKey(){
        return isset($this->params['AWSAccessKeyId']) ? $this->params['AWSAccessKeyId'] : null;
    }

    /**
     * @param $associateTag
     * @return \NicolasMugnier\AdvertisingApi\Client
     */
    public function setAssociateTag($associateTag){
        $this->params['AssociateTag'] = $associateTag;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAssociateTag(){
        return isset($this->params['AssociateTag']) ? $this->params['AssociateTag'] : null;
    }

    /**
     * @param $secretAccessKey
     * @return \NicolasMugnier\AdvertisingApi\Client
     */
    public function setSecretAccessKey($secretAccessKey){
        $this->secretAccessKey = $secretAccessKey;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSecretAccessKey(){
        return $this->secretAccessKey;
    }

    /**
     * @param string $operation
     * @return $this
     */
    public function setOperation($operation){
        $this->params['Operation'] = $operation;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperation(){
        return isset($this->params['Operation']) ? $this->params['Operation'] : null;
    }

    /**
     * @return array
     */
    protected function query() {

        $host = "ecs.amazonaws.fr";
        $path = "/onca/xml";

        $timestamp = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time() + 3600 * 2);

        $params = [
            'Service' => 'AWSECommerceService',
            'Version' => '2011-08-01',
            'Timestamp' => $timestamp,
        ];

        $params = array_merge($params, $this->params);

        uksort($params, 'strcmp');

        foreach ($params as $param => $value) {
            $param = str_replace('%7E', '~', rawurlencode($param));
            if ($param != 'Timestamp')  //do not encode timestamp !!!
                $value = str_replace('%7E', '~', rawurlencode($value));
        }

        $signature = $this->calculSignature($params, $host, $path);

        $params['Signature'] = $signature;
        $url = 'http://'.$host.$path.'?'.http_build_query($params);
        return $this->client->get($url);
    }

    /**
     * @param $params
     * @param $host
     * @param $path
     * @return string
     */
    protected function calculSignature($params, $host, $path) {

        $tmp = array();

        // url encode parameters names and values
        foreach ($params as $param => $value) {
            if ($param == 'Timestamp')  //now, encode timestamp
                $value = str_replace('%7E', '~', rawurlencode($value));
            $tmp[] = $param . "=" . $value;
        }

        // construct query string
        $query = implode('&', $tmp);
        // construct signToString
        $signToString = "GET" . "\n";
        $signToString .= $host . "\n";
        $signToString .= $path . "\n";
        $signToString .= $query;

        $signature = base64_encode(hash_hmac("sha256", $signToString, $this->getSecretAccessKey(), true));
        return $signature;

    }

}