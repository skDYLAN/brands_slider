<?php

class CBitrixBrandsSlider extends CBitrixComponent{
    public function handlerArParams(){
        $this->arParams['IBLOCK_COUNT'] = (int)$this->arParams['IBLOCK_COUNT'];
        $this->arParams['ONLY_WITH_DISPLAY_PARAM'] = $this->arParams['ONLY_WITH_DISPLAY_PARAM'] === "Y" ? true : false;
        $this->arParams['MAIN_PAGE'] = $this->arParams['MAIN_PAGE'] === "Y" ? true : false;
        $this->arParams['USE_CODE'] = $this->arParams['USE_CODE'] === "Y" ? true : false;
        if(!isset($arParams["CACHE_TIME"]))
            $arParams["CACHE_TIME"] = 36000000;
    }
    public function setArResult()
    {
        print_r($this->arParams["IBLOCK_ID"]);
        $arFilter = ['ACTIVE' => 'Y', "IBLOCK_TYPE" => $this->arParams['IBLOCK_TYPE']];
        $arSelect = ['ID', 'NAME', "PROPERTY_LINK", "PROPERTY_DISPLAY_ON_MAIN", "PREVIEW_PICTURE"];
        foreach ($this->arParams["IBLOCK_ID"] as $iblockID) {

            if (!intval($iblockID))
                continue;

            if($this->arParams['USE_CODE'])
                $arFilter["IBLOCK_CODE "] = $iblockID;
            else
                $arFilter["IBLOCK_ID"] = $iblockID;

            $r = CIBlockElement::GetList(["name" => "ASC"], $arFilter, false, false, $arSelect);
            while ($res = $r->Fetch()) {

                if(!empty($res['PREVIEW_PICTURE']))
                    $res['PREVIEW_PICTURE'] = CFile::GetFileArray($res['PREVIEW_PICTURE']);

                $res['LINK'] = !empty($res['PROPERTY_LINK_VALUE']) ? $res['PROPERTY_LINK_VALUE'] : "";
                if ($this->arParams['ONLY_WITH_DISPLAY_PARAM']) { // Выводить элементы с параметром
                    if($res["MAIN_PAGE"]) { // Это главная страница?
                        if ($res['PROPERTY_DISPLAY_ON_MAIN_VALUE'] === "Да") // Параметр для главной страницы
                            $this->arResult[] = $res;
                    }
                    else{
                        if ($res['PROPERTY_DISPLAY_ON_CATALOG_VALUE'] === "Да") // Параметр для внутренних
                            $this->arResult[] = $res;
                    }
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