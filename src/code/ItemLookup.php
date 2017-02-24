<?php namespace NicolasMugnier\AdvertisingApi;

/**
 * Class ItemLookup
 *
 * @package   NicolasMugnier\AdvertisingApi
 * @author    Nicolas Mugnier <mugnier.nicolas@gmail.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ItemLookup extends Client {

    const kTypeSKU = 'SKU';
    const kTypeASIN = 'ASIN';
    const kTypeUPC = 'UPC';
    const kTypeEAN = 'EAN';

    /**
     * @return array
     */
    public function getTypes() {
        return array(
            self::kTypeSKU,
            self::kTypeASIN,
            self::kTypeUPC,
            self::kTypeEAN
        );
    }

    /**
     * @param string $condition
     * @return $this
     * @todo: check if condition is valid
     */
    public function setCondition($condition){
        $this->params['Condition'] = $condition;
        return $this;
    }

    /**
     * @return string
     */
    public function getCondition(){
        return (isset($this->params['Condition'])) ? $this->params['Condition'] : 'All';
    }

    /**
     * @param string $merchantId
     * @return $this
     */
    public function setMerchantId($merchantId){
        $this->params['MerchantId'] = $merchantId;
        return $this;
    }

    /**
     * @return string
     */
    public function getMerchantId(){
        return (isset($this->params['MerchantId'])) ? $this->params['MerchantId'] : 'All';
    }

    /**
     * @param string $searchIndex
     * @return $this
     */
    public function setSearchIndex($searchIndex){
        $this->params['SearchIndex'] = $searchIndex;
        return $this;
    }

    /**
     * @return string
     */
    public function getSearchIndex(){
        return isset($this->params['SearchIndex']) ? $this->params['SearchIndex'] : 'All';
    }

    /**
     * @param string $itemId
     * @return $this
     */
    public function setItemId($itemId){
        $this->params['ItemId'] = $itemId;
        return $this;
    }

    /**
     * @param string $idType
     * @return $this
     */
    public function setIdType($idType){
        $this->params['IdType'] = $idType;
        return $this;
    }

    /**
     * @return array
     */
    public function search(){
        $this->setOperation('ItemLookup');
        return $this->query();
    }

}