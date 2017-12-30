<?php

namespace Helpers\Classes;

use Auth;
use App\Menu;

class Permission {

    public static function check() {

        if (Auth::user()->role->title == 'admin') {
            return true;
        }

        $request = app('request');
        
        $action = $request->route()->getAction();
        $requestedRoute = class_basename($action['controller']);
        
        list($c, $a) = explode('@', $requestedRoute);
        
        if(in_array($c,['AuthController','ErrorController'])){
            return true;
        }
        
        if ($request->isMethod('POST')) {
            return true;
        }

        $access = explode(',', Auth::user()->role->access);
        $menu = Menu::whereIn('id', $access)->get(['route']);

        return self::searchRouteInPermittedMenu($requestedRoute, $menu);
    }

    private static function searchRouteInPermittedMenu($currentRoute, $objMenu) {
        foreach ($objMenu as $menu) {
            if ($currentRoute == $menu->route) {
                return true;
            }
        }
        return false;
    }

}
