<?php

class WebUser extends CWebUser {
    private $_model = null;
 
    public function getRole() {
        if($user = $this->getModel()){
            // в таблице User есть поле role
            return $user->role;
        }
    }
 
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = User::model()->findByPk($this->id, array('select' => 'role'));
        }
        return $this->_model;
    }
    
    public function hasAdminAccess () {
        $role = $this->getRole();
        $accessArray = array(
            '3' => 'admin',
            '2' => 'moderator'
        );
        $var = false;
        if (array_key_exists($role,$accessArray)) {
            $var = true;
        }
        return $var;
    }
    public function isAdmin () {
        $role = $this->getRole();
        $accessArray = array(
            '3' => 'admin',
        );
        $var = false;
        if (array_key_exists($role,$accessArray)) {
            $var = true;
        }
        return $var;
    }
}
