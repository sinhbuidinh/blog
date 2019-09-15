<?php

function parseErrorsExceptInput($errors)
{
    $exceptInputs = array_filter($errors, function($key){
        return is_numeric($key);
    }, ARRAY_FILTER_USE_KEY);
    if (empty($exceptInputs)) {
        return '';
    }
    return parseMessage($exceptInputs);
}
function parseMessage($messages)
{
    $result = '<div class="message">';
    if (!empty($messages) && is_array($messages)) {
        foreach ($messages as $message_type => $value) {
            //fetch & generate data
            $result .= parseMessageByType($message_type, $value);
        }
    }
    $result .= '</div>';
    return $result;
}
function parseMessageByType($type, $msg_val)
{
    if (empty($msg_val)) {
        return '';
    }
    $class = parseClassByMsgType($type);
    $message_return = '';
    if (!is_array($msg_val)
        && is_string($msg_val)
    ) {
        $message_return .= '<label class="' . $class . ' fade in">';
        $message_return .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        $message_return .= $msg_val;
        $message_return .= '</label>';
        
        return $message_return;
    }
    foreach ($msg_val as $selector_element => $msg) {
        $message_return .= '<label id="alert_' . $selector_element . '" class="' . $class . ' fade in" for="' . $selector_element . '">';
        $message_return .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        $message_return .= $msg;
        $message_return .= '</label>';
    }
    return $message_return;
}
function parseClassByMsgType($msg_type)
{
    $class = 'alert';
    switch ($msg_type) {
        case config('constant.MESSAGE_TYPE_SUCCESS'):
            $class .= ' alert-success';
            break;
        case config('constant.MESSAGE_TYPE_ERROR'):
            $class .= ' alert-danger';
            break;
        case config('constant.MESSAGE_TYPE_WARNING'):
            $class .= ' alert-warning';
            break;
        case config('constant.MESSAGE_TYPE_INFO'):
            $class .= ' alert-info';
            break;
        default:
            $class .= ' alert-info';
            break;
    }
    return $class;
}
function isActiveClass($routeName, $parameters = [])
{
    $pathCheck = route($routeName, $parameters, false);
    if ($pathCheck === '/') {
        $path = $pathCheck;
    } else {
        $ex = explode('/', $pathCheck);
        array_shift($ex);
        $path = implode('/', $ex);
    }
    // $routeName == 'user.index' ? dd('helper', $path, request()->path(), request()->is($path)) : '';
    if(request()->is($path)){
        return ' active';
    }
    return '';
}
