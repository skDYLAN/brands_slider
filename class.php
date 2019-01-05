<?php

class CBitrixBrandsSlider extends CBitrixComponent{
    public function handlerArParams(){
        $this->arParams['IBLOCK_COUNT'] = (int)$this->arParams['IBLOCK_COUNT'];
        $this->arParams['ONLY_WITH_DISPLAY_PARAM'] = $this->arParams['ONLY_WITH_DISPLAY_PARAM'] === "Y" ? true : false;
        if(!isset($arParams["CACHE_TIME"]))
            $arParams["CACHE_TIME"] = 36000000;
        print_r($this->arParams['ONLY_WITH_DISPLAY_PARAM']);
    }
    public function setArResult()
    {
        $arFilter = ['ACTIVE' => 'Y', "IBLOCK_TYPE" => $this->arParams['IBLOCK_TYPE']];
        $arSelect = ['ID', 'NAME', "PROPERTY_LINK", "PROPERTY_DISPLAY_ON_MAIN", "PREVIEW_PICTURE"];
        foreach ($this->arParams["IBLOCK_ID"] as $iblockID) {

            if (!intval($iblockID))
                continue;

            $arFilter["IBLOCK_ID"] = $iblockID;
            $r = CIBlockElement::GetList(["name" => "ASC"], $arFilter, false, false, $arSelect);
            while ($res = $r->Fetch()) {

                if(!empty($res['PREVIEW_PICTURE']))
                    $res['PREVIEW_PICTURE'] = CFile::GetFileArray($res['PREVIEW_PICTURE']);

                $res['LINK'] = !empty($res['PROPERTY_LINK_VALUE']) ? $res['PROPERTY_LINK_VALUE'] : "";
                if ($this->arParams['ONLY_WITH_DISPLAY_PARAM']) {
                    if ($res['PROPERTY_DISPLAY_ON_MAIN_VALUE'] === "Да")
                        $this->arResult[] = $res;
                } else
                    $this->arResult[] = $res;
            }
        }
    }

    function executeComponent() {
        try {
            $this->handlerArParams();
            if(!Bitrix\Main\Loader::includeModule('iblock'))
                return;
            if($this->StartResultCache()) {
                $this->setArResult();
                $this->includeComponentTemplate();
            }
        } catch (Exception $exc) {
            if ($this->set404){
                @define("ERROR_404","Y");
            } elseif($this->showError) {
                $this->__showError($exc->getMessage());
            }
            $this->AbortResultCache();
        }
    }
}

?>