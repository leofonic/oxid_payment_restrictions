<?php  

class payment_restrictions_payment extends payment_restrictions_payment_parent 
{
    protected $_aTemplateDisallowPayment = array(
        'mobile'=> array(
            //example: no payment by invoice for mobile customers
            'oxidinvoice',
        )
    );
    protected $_aCategoryDisallowPayment = array(
        'nopaypal'=> array(
            //example: no payment by paypal for articles in hidden category "nopaypal"
            'oxidpaypal',
        )
    );

    public function getPaymentList(){
        if(is_null($this->_oPaymentList)){
            $aDisalllowedPayments = array();
            
            //disallowed by theme
            $oTheme = oxNew('oxTheme');
            $sThemeId = $oTheme->getActiveThemeId();
            if (is_array($aDisallowedByTheme = $this->_aTemplateDisallowPayment[$sThemeId])){
                $aDisalllowedPayments = array_merge($aDisalllowedPayments, $aDisallowedByTheme);
            }
            
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
