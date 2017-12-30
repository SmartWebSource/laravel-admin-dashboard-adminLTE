<?php

use App\Country;

function message($class, $icon_class = "", $message, $close_button = false) {
    $icon = $icon_class != "" ? "<i class='fa fa-$icon_class'></i>" : "";
    return "<div id='confirmation_message' class='tg-alert alert alert-".$class." fade in'>" . $icon .'<a href="#" class="close" data-dismiss="alert">×</a> '. $message . "</div>";
}

/**
 * We will use this function for styling validation error message
 * @param string
 * @return string
 */
function validation_error($message, $elementId = '', $optional = false) {
    if ($message == '' && $optional == true) {
        return '';
    }
    $myMessage = $message == "" ? "*" : "[$message]";
    $elmId = $elementId != '' ? "id=ve-" . trim($elementId) : '';
    return "<small $elmId class='validation-error'>$myMessage</small>";
}

function validationHints() {
    return "<small class='validation-error-hints pull-left'><i>All fields marked with an asterisk (*) are required.</i></small>";
}

/**
 * Display pagination summery
 *
 * @param int $totalData
 * @param int $dataPerPage
 * @param int $currentPage
 */
function getPaginationSummery($totalData, $dataPerPage, $currentPage) {
    $paginationSummery = "";
    if ($totalData > $dataPerPage) {
        if ($currentPage == 1) {
            $paginationSummery = "Showing 1 to $dataPerPage records of $totalData";
        } else {
            if (($totalData - $currentPage * $dataPerPage) > $dataPerPage) {
                $from = ($currentPage - 1) * $dataPerPage + 1;
                $to = $currentPage * $dataPerPage;
                $paginationSummery = "Showing $from to $to records of $totalData";
            } else {
                $from = ($currentPage - 1) * $dataPerPage + 1;
                $to = ($totalData - ($currentPage - 1) * $dataPerPage) + ($currentPage - 1) * $dataPerPage;
                $paginationSummery = "Showing $from to $to records of $totalData";
            }
        }
    }
    return $paginationSummery;
}

/**
* Description: This function will return app build info
* @return string App Build Info
*/
function app_build_info(){
    $build_path = base_path('build.json');
    if (file_exists($build_path)) {
        $file_handle = fopen($build_path, "r");
        $build_info_data = fread($file_handle, filesize($build_path));
        fclose($file_handle);
        $build_info = json_decode($build_info_data, true);
        if(is_array ( $build_info )){
            $output = "";
            if( array_key_exists('build_number', $build_info) && array_key_exists('build_date', $build_info) ){
                $output .=  "v".$build_info["build_number"].".".$build_info["build_date"];
            }
            if( array_key_exists('build_branch', $build_info) && !empty($build_info["build_branch"]) ){
                $output .= " | Branch: ".$build_info["build_branch"];
            }
                
            return $output;
        }
    }
}

function decodeJWT($token, $expectedData=null){
    try{
        $decoded = \Firebase\JWT\JWT::decode($token, env('JWT_SECRET'), ['HS256']);

        $output = [];

        if(count($expectedData) > 0){
            foreach ($expectedData as $key) {
                $output[$key] = !empty($decoded->$key) ? $decoded->$key : '';
            }
        }

        return $output;

    }catch ( \Firebase\JWT\ExpiredException $e ) {
        return response()->json(
            [
                'status' => 401,
                'message' => $e->getMessage(),
                'data' => []
            ],
            401
        );
    }catch ( \Exception $e ){
        return response()->json(
            [
                'status' => 500,
                'message' => $e->getMessage(),
                'data' => []
            ],
            500
        );
    }
}


/**
 * @param string exception|error|info
 * @param string OR object The error message or error object you want to post
 */

function notify2Slack($type, $data){
    if(in_array(env('APP_ENV'), ['production','development']) && env('APP_EXCEPTION') == true){
        
        $slack = new \SlackNotifier\SlackNotifier();
        
        if($type == 'exception'){
            $slack->notifyException($data);
        }elseif($type == 'error'){
            $slack->notifyError($data);
        }elseif($type == 'info'){
            $slack->notifyInfo($data);
        }else{
            $slack->notifyInfo('invalid type parameter!');
        }
    }
    return;
}