<?php

namespace ES\Response;

class CommonResponse
{
    public  $is_support_jsonp = false;
    public  $header_list;

    public  function arrSuccess($message = 'ok', $code = 200)
    {
        return [BaseConstant::ERROR => false, BaseConstant::MESSAGE => $message, BaseConstant::CODE => $code];
    }

    public  function arrFail($message, $code = -1)
    {
        return [BaseConstant::ERROR => true, BaseConstant::MESSAGE => $message, BaseConstant::CODE => $code];
    }

    /**
     * 失败返回接口
     * @param string $message
     * @param int $code
     * @return string
     */
    public  function jsonError($message = '', $code = -1)
    {
        if (empty($message)) {
            $message = 'unknown error';
        }
        $view = [
            'code' => $code,
            BaseConstant::MESSAGE => $message,
        ];
        $json = json_encode($view);
        return $this->dumpJsonData($json);
    }

    /**
     * 成功返回接口
     * @param string $message
     * @param int $code
     * @return string
     */
    public  function jsonSuccess($message = '', $code = 0)
    {
        $view = [
            BaseConstant::CODE => $code,
            BaseConstant::MESSAGE => BaseConstant::OK,
            BaseConstant::DATA => $message
        ];
        $json = json_encode($view);
        return $this->dumpJsonData($json);
    }

    /**
     * 直接处理接口数据
     * @param $ret
     */
    public  function dealRet($ret)
    {
        if (true === $ret['error']) {
            $this->jsonError($ret[BaseConstant::MESSAGE] ?: 'unknown error');
        } else {
            $this->jsonSuccess($ret[BaseConstant::MESSAGE] ?: BaseConstant::OK);
        }
    }

    /**
     * 根据是否为JSONP做特殊处理输出
     * @param $json
     * @return string
     */
    public  function dumpJsonData($json)
    {
        $callback = '';
        if (true === $this->is_support_jsonp) {
            $this->header('Content-type', 'application/javascript');
            $callback_key = 'jsonpcallback';
            $callback = $_GET[$callback_key];
            if ($callback) {
                $callback = $callback_key;
                $json = $callback . '(' . $json . ')';
            }
        }
        if (!$callback) {
            $this->header('Content-type', 'application/json');
        }
        return response($json, 200, $this->getHeaders());
    }

    /**
     * @param $json_str
     * @param string $callback_key
     * @return string
     */
    public  function printByJson($json_str, $callback_key = '')
    {
        $callback = '';
        if ($callback_key) {
            $callback = $_GET[$callback_key] ?? '';
        }
        if ($callback) {
            $callback = $callback_key;
            $this->header('Content-type', 'application/javascript');
            return $callback . '(' . $json_str . ')';
        } else {
            $this->header('Content-type', 'application/json');
            return $json_str;
        }
    }

    /**
     * @param $arr
     * @param string $callback_key
     * @return string
     */
    public  function printByArr($arr, $callback_key = '')
    {
        $callback = '';
        if ($callback_key) {
            $callback = $_GET[$callback_key] ?? '';
        }
        if ($callback) {
            $callback = $callback_key;
            $this->header('Content-type', 'application/javascript');
            return $callback . '(' . json_encode($arr) . ')';
        } else {
            $this->header('Content-type', 'application/json');
            return json_encode($arr);
        }
    }

    public  function getHeaders()
    {
        return $this->header_list;
    }

    public  function header($key, $value)
    {
        $this->header_list[$key] = $value;
    }
}
