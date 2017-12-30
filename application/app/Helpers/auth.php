<?php

function isSuperAdmin(){
	if(!Auth::check()){
		return false;
	}

	return Auth::user()->role == 'super-admin' ? true : false;
}

function isAdmin(){
	if(!Auth::check()){
		return false;
	}

	return Auth::user()->role == 'admin' ? true : false;
}

function isAgent(){
	if(!Auth::check()){
		return false;
	}

	return Auth::user()->role == 'agent' ? true : false;
}