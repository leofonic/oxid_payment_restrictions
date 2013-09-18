<?php  

class payment_restrictions_payment extends payment_restrictions_payment_parent 
{
    protected $_aTemplateDisallowPayment = array(
        'mf_mobile'=> array(
            'oxidinvoice',
            'oxiddebitnote',
            'oxidcreditcard',
        )
    );
    protected $_aCategoryDisallowPayment = array(
        'noinvoice'=> array(
            'oxidinvoice',
            'oxiddebitnote',
            'oxidcashondel',
        )
    );

    public function getPaymentList(){
        if(is_null($this->_oPaymentList)){
            $aDisalllowedPayments = array();
            
            //disallowed by theme
            $oTheme = oxNew('oxTheme');
            $sThemeId = $oTheme->getActiveThemeId();
            $aDisalllowedPayments = $this->_aTemplateDisallowPayment[$sThemeId];
            
            //disallowed by category
            $oBasket = $this->getSession()->getBasket();
            $oCategory = new oxCategory();
            foreach($oBasket->getBasketArticles() as $oArticle){
                $aCatIds = $oArticle->getCategoryIds();
                foreach ($aCatIds as $sId){
                    $oCategory->load($sId);
                    $sCatTitle = $oCategory->getTitle();
                    if (is_array($aDisallowedByCat = $this->_aCategoryDisallowPayment[$sCatTitle])){
                        $aDisalllowedPayments = array_merge($aDisalllowedPayments, $aDisallowedByCat);
                    }
                }
            }
            
            $oPaymentList = parent::getPaymentList();
            if(count($aDisalllowedPayments)){
                foreach ($oPaymentList as $oPayment){
                    $sPaymentId = $oPayment->getId();
                    if (in_array($sPaymentId, $aDisalllowedPayments)) {
                        unset ($this->_oPaymentList[$sPaymentId]);
                    }
                }
            }
        }
        return $this->_oPaymentList;
    }
}