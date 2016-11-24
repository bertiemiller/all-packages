<?php
$name = $input['name'];
$type = $input['type'];
$options = (isset($input['options']) ? $input['options'] : null);
$value = (isset($input['value']) ? $input['value'] : null);
$disabled = (isset($data['disabled']) ? $data['disabled'] : null);

view()->share('name', $name);
view()->share('type', $type);
view()->share('options', $options);
view()->share('value', $value);
view()->share('disabled', $disabled);
