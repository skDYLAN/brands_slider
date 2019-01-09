<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */
if(!CModule::IncludeModule("iblock"))
    return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!= "-" ? $arCurrentValues["IBLOCK_TYPE"] : "")));
while($arRes = $db_iblock->Fetch()) {
    if($arCurrentValues["USE_CODE"] === "N")
        $arIBlocks[$arRes["ID"]] = "[" . $arRes["ID"] . "] " . $arRes["NAME"];
    else
        $arIBlocks[$arRes["CODE"]] = "[" . $arRes["CODE"] . "] " . $arRes["NAME"];
}

$arComponentParameters = array(
    "GROUPS" => array(
    ),
    "PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("STLW_LISTOFBRANDS_PARAMS_TYPE_IBLOCK"),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "DEFAULT" => "pars_movies",
            "REFRESH" => "Y",
        ),
        "USE_CODE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("STLW_LISTOFBRANDS_USE_CODE"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
            "REFRESH" => "Y"
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("STLW_LISTOFBRANDS_PARAMS_IBLOCK"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "MULTIPLE" => "Y"
        ),
        "ONLY_WITH_DISPLAY_PARAM" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("STLW_LISTOFBRANDS_PARAMS_ONLY_WITH_DISPLAY_PARAM"),
            "TYPE" => "CHECKBOX",
            "ADDITIONAL_VALUES" => "Y",
        ),
        "MAIN_PAGE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("STLW_LISTOFBRANDS_MAIN_PAGE"),
            "TYPE" => "CHECKBOX",
            "ADDITIONAL_VALUES" => "Y",
        ),
        'CACHE_TIME' => array('DEFAULT' => 36000000),
    ),
);