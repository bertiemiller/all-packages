<?php

namespace Topicmine\Core\Requests\Traits;

trait CoreRequestMethods {

    public function sanitise($inputs)
    {
        if (false == $this->inputs_are_array($inputs)){
            foreach($inputs as $name=>$value) {
                if(empty($value)) continue;
                $inputs[$name] = $this->sanitiser($name,$value);
            }

            return $inputs;
        }

        foreach($inputs as $name=>$values) {
            if(! is_array($values)) continue;
            foreach($values as $num=>$value) {
                if(empty($value)) continue;
                $inputs[$name][$num] = $this->sanitiser($name, $value);
            }
        }

        return $inputs;
    }

    function inputs_are_array($inputs)
    {
        foreach ($inputs as $n => $items)
        {
            if (is_array($items))
            {
                return true;
            }
        }

        return false;
    }
    
    function format_rules_if_array($inputs, $rules)
    {
        if(isset($inputs['selectedIds'])) {
            return [];
        }

        if (! $this->inputs_are_array($inputs)){
            return $rules;
        }

        $rulesArr = [];
        foreach ($rules as $name => $rule)
        {
            if (!isset($inputs[$name])) continue;
            foreach ($inputs[$name] as $k => $value)
            {
                if (empty($value)) continue;
                $rulesArr[$name . '.' . $k] = $rule;
            }
        }

        return $rulesArr;
    }

}




