<?php namespace NicolasMugnier\AdvertisingApi;

/**
 * Class BrowseNodeLookup
 *
 * @package   NicolasMugnier\AdvertisingApi
 * @author    Nicolas Mugnier <mugnier.nicolas@gmail.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class BrowseNodeLookup extends Client {

    /**
     * @param string $browseNodeId
     * @return $this
     */
    public function setBrowseNodeId($browseNodeId){
        $this->params['BrowseNodeId'] = $browseNodeId;
        return $this;
    }

    /**
     * @return array
     */
    public function search(){
        $this->setOperation('BrowseNodeLookup');
        return $this->query();
    }

}