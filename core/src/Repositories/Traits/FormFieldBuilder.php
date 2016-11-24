<?php

namespace Topicmine\Core\Repositories\Traits;

use DB;
use App\Exceptions\GeneralException;

trait FormFieldBuilder {

    /*
     * Only using a selection of the input types at present. Would like
     * to change the matching to regext to simplify, but it's
     * working for now
     */
    public $inputTypes = [
//        'BIGINT' => 'text',
        'BLOB' => 'textarea',
        'BOOLEAN' => 'text',
//        'CHAR' => 'text',
        'DATE' => 'date',
        'DATETIME' => 'date',
//        'DECIMAL' => 'text',
//        'DOUBLE' => 'text',
//        'ENUM' => 'text',
//        'INTEGER' => 'text',
        'LONGTEXT' => 'textarea',
//        'MEDIUMINT' => 'text',
        'MEDIUMTEXT' => 'textarea',
//        'SMALLINT' => 'text',
//        'TINYINT' => 'text',
        'VARCHAR' => 'textarea',
//        'VARCHAR(100)' => 'text',
//        'VARCHAR(255)' => 'text',
//        'TEXT' => 'text',
        'TIME' => 'date',
//        'TIMESTAMP' => 'date',
//        'INT(10) UNSIGNED' => 'text',
//        'INT(11)' => 'text',
//        'TINYINT(3) UNSIGNED' => 'text',
//        'TINYINT(1)' => 'text',
//        'NULL' => 'hidden',
    ];
    
    private $columnFieldTypes;

    public function getCreateInputs()
    {
        return $this->getEditInputsFromFieldTypes();
    }

    public function getEditInputs($item)
    {
        $inputs = $this->getEditInputsFromFieldTypes();

        return $this->addItemValues($item, $inputs);
    }

    public function getEditInputsFromFieldTypes()
    {
        if( ! empty($this->formInputs) ){
            return $this->formInputs;
        }

        $updateFields = isset($this->modelBase->updateFields) ? 
            $this->modelBase->updateFields : $this->modelBase->getFillable();

        $columnFieldTypes = $this->getColumnFieldTypes();
        
        $formInputs = [];

        foreach($updateFields as $key=>$field) {
            $formInputs[$key] = [
                'name' => $this->getFieldName($field),
                'type' => $this->getFieldType($field, $columnFieldTypes),
                'value' => $this->getFieldValue($field),
                'options' => $this->getFieldOptions($field),
                'disable' => false,
            ];
        }

        return $formInputs;
    }

    public function getFieldName($field)
    {
        if( is_string($field))
        {
            return $field;
        }
        elseif( is_array($field) && isset($field['name']) )
        {
            return $field['name'];
        }
        else{
            throw new GeneralException('Error defining field type field type');
        }
    }

    public function getFieldType($field, $columnFieldTypes)
    {
        // convert $this->inputTypes match to regex function

        if( is_string($field)
            && isset( $this->inputTypes[ strtoupper( $columnFieldTypes[$field]) ]) )
        {
            return $this->inputTypes[ strtoupper( $columnFieldTypes[$field]) ];
        }
        elseif( is_array($field) && isset($field['type']) )
        {
            return $field['type'];
        }
        else
        {
            return 'text';
        }
        
    }

    public function getFieldValue($field)
    {
        if( isset( $field['value']) ){
            return $field['value'];
        }

        return null;
    }

    public function getFieldOptions($field)
    {
        if( isset($field['name']) ) {
            $options = $this->modelBase->{$field['name'].'Options'};
            if(! empty( $options ) ){
                return $options;
            }
        }

        return null;
    }

    public function getColumnFieldTypes()
    {
        $this->columnFieldTypes = [];
        $columns = DB::connection($this->modelBase->getConnectionName())
            ->select( "SHOW COLUMNS FROM ". DB::getTablePrefix() . $this->modelBase->getTable() );
        foreach($columns as $column){
            $this->columnFieldTypes[$column->Field] = $column->Type;
        }
        return $this->columnFieldTypes;
    }

    public function addItemValues($item, $inputs)
    {
        foreach($inputs as $k=>$input) {
            if(! array_key_exists($input['name'], $item)) {
                unset($inputs[$k]);
                continue;
            }
            $inputs[$k]['value'] = $item[$input['name']];
        }

        return $inputs;
    }

    public function getAllowedFields($allowed, $inputs)
    {
        $flipped_haystack = array_flip($allowed);
        foreach($inputs as $k=>$input) {
            foreach($input as $name=>$value) {
                $needle = $name;
                if (! isset($flipped_haystack[$needle]) )
                {
                    unset($inputs[$k][$name]);
                }
            }
        }

        return $inputs;
    }

    public function getSelectOptionsFromCollection($collection, $key = 'id', $value = 'name')
    {
        $options = [];

        foreach ($collection as $row)
        {
            if (is_array($collection))
            {
                $options[$row[$key]] = $row[$value];
            }
            else
            {
                $options[$row->$key] = $row->$value;
            }
        }

        return $options;
    }
}
