<?php

class ExtendedFilters extends CDbCriteria
{
    public function compare($column, $value, $partialMatch=false, $operator='AND', $escape=true)
	{
		//xdebug_break();
        if(is_array($value))
		{
			if($value===array())
				return $this;
			return $this->addInCondition($column,$value,$operator);
		}
		else
			$value="$value";
        if(preg_match('/(?P<var1>\w+) (?P<sepor>\s*(-)) (?P<var2>\d+)?(.*)$/',$value,$matches)){
                $value=array((int)$matches['var1'],(int)$matches['var2']);
                $op=$matches['sepor'];
        } elseif (preg_match('/^(?:\s*(<>|<=|>=|<|>|=))?(.*)$/',$value,$matches)){
            
			$value=$matches[2];
			$op=$matches[1];
        } else {
           $op=''; 
        }
			

		if($value==='')
			return $this;

		if($partialMatch) {
			if($op==='-')
				return $this->addBetweenCondition($column,$value[0],$value[1],$operator);
            if($op==='')
				return $this->addSearchCondition($column,$value,$escape,$operator);
			if($op==='<>')
				return $this->addSearchCondition($column,$value,$escape,$operator,'NOT LIKE');
		} elseif($op===''){
            $op='=';
            $this->addCondition($column.$op.self::PARAM_PREFIX.self::$paramCount,$operator);
            $this->params[self::PARAM_PREFIX.self::$paramCount++]=$value;
        } elseif ($op==='-') {
            return $this->addBetweenCondition($column,$value[0],$value[1],$operator);
        }
			

		

		return $this;
	}
}

