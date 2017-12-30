<?php

use App\AppSettings;

function getAppSettings($name, $default=""){

	$appSettings = AppSettings::whereName($name)->first(['value']);

	return !empty($appSettings->value) ? $appSettings->value : $default;
}

function getAllAppSettings(){

	$appSettingss = AppSettings::get(['name','value']);

	if(!$appSettingss){
		return [];
	}

	$myOptions = [];
	foreach ($appSettingss as $appSettings) {
		$myOptions[$appSettings->name] = $appSettings->value;
	}

	return $myOptions;
}

function addOrUpdateAppSettings($name, $value){

	$appSettings = AppSettings::whereName($name)->first();

	if(!$appSettings){
		$appSettings = new AppSettings();
		$appSettings->name = $name;
	}
	$appSettings->value = $value;

	return $appSettings->save() ? true : false;
}

function deleteAppSettings($name){

	$appSettings = AppSettings::whereName($name)->first();

	if(!$appSettings){
		//no option found in db to delete
		return false;
	}

	return $appSettings->delete() ? true : false;
}