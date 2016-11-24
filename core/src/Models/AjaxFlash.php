<?php

namespace Topicmine\Core\Models;

/**
 * There is a helper function to load this
 * set in the core package file helpers.php
 */

class AjaxFlash {

    public $important = null;
    public $params = [];
    public $message;
    public $response;

    public function __toString() {
        return json_encode($this->response);
    }

    public function setMessage($message, $type)
    {
        $this->message = $message;
        $this->type = $type;
    }

    public function notifier()
    {
        $this->response['message'] = $this->message;
        $this->response['type'] = $this->type;
        $this->response['important'] = $this->important;
        $this->response['params'] = $this->params;

        return $this;
    }

    public function params($params)
    {
        $this->response['params'] = [$params];

        return $this;
    }

    public function important()
    {
        $this->response['important'] = 'important';

        return $this;
    }

}