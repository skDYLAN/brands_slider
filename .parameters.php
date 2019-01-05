<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */
if(!CModule::IncludeModule("iblock"))
    return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!= "-" ? $arCurrentValues["IBLOCK_TYPE"] : "")));
while($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];

// спиосок секций
$db_iblock = CIBlockSection::GetList(array("SORT"=>"ASC"),["IBLOCK_ID" => ($arCurrentValues["IBLOCK_ID"]!= "-" ? $arCurrentValues["IBLOCK_ID"] : "")], false);
while ($arRes = $db_iblock->Fetch())
    $arSection[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];

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
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("STLW_LISTOFBRANDS_PARAMS_IBLOCK"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "ADDITIONAL_VALUES" => "Y",
            "MULTIPLE" => "Y"
        ),
        "ONLY_WITH_DISPLAY_PARAM" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("STLW_LISTOFBRANDS_PARAMS_ONLY_WITH_DISPLAY_PARAM"),
            "TYPE" => "CHECKBOX",
            "ADDITIONAL_VALUES" => "Y",
        ),
        'CACHE_TIME' => array('DEFAULT' => 36000000),
    ),
);