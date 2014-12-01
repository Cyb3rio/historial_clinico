<?php
class UsersController extends AppController {
    var $name = 'Users';
    var $paginate = array(
        'User' => array(
            'limit' => 20,
            'order' => array(
                'User.full_name' => 'asc',
            ),
        ),
    );
    
    var $uses = array('User');
    
    /**
     * Set this to false if you don't want to store clear passwords in the database
     * @var bool
     * @access private
     */
    var $_store_clear_password = true;
    
    function index() {
        $users = $this->paginate('User');
        $this->set(compact('users'));
    }
    
    function add()
    {
        $areas = $this->Areas->find("list",array("fields"=>array("id_area","descrip"),"order"=>"descrip"));
        $areas_aux = $areas;
        foreach($areas as $id=>$area)
        {
            $areas_aux[$id] = utf8_encode($area);
        }
        
        $this->set("areas",$areas_aux);
        if (!empty($this->data)) {
            $this->User->set($this->data);
            if ($this->User->validates()) {
                $this->data['User']['password'] = $this->data['User']['clear_password'];
                $this->data = $this->Auth->hashPasswords($this->data);
                if (!$this->_store_clear_password)
                {
                    unset($this->data['User']['clear_password']);
                }
                $this->User->save($this->data, false);
                $this->Session->setFlash('User Added');
                $this->redirect('index');
            }
        }
    }
    
    function edit($id = null) {
        if (!empty($this->data)) {
            $fields = array_keys($this->data['User']);
            if (!empty($this->data['User']['clear_password']) || !empty($this->data['User']['confirm_password'])) {
                $fields[] = 'password';
            } else {
                $fields = array_diff($fields, array('clear_password', 'confirm_password'));
            }
            $this->User->set($this->data);
            if ($this->User->validates()) {
                if (!empty($this->data['User']['clear_password'])) {
                    $this->data['User']['password'] = $this->data['User']['clear_password'];
                }
                $this->data = $this->Auth->hashPasswords($this->data);
                if (!$this->_store_clear_password) {
                    unset($this->data['User']['clear_password']);
                }
                $this->User->save($this->data, false, $fields);
                $this->Session->setFlash('User Updated');
                $this->redirect('index');
            }
        } else {
            $user = $this->User->findById($id);
            if (empty($user)) {
                $this->Session->setFlash('Invalid User ID', 'flash_notice');
                $this->redirect('add');
            } else {
                unset($user['User']['clear_password']);
                $this->data = $user;
            }
        }
    }
    
    function delete() {
        $delete_count = 0;
        if (!empty($this->data['User']['delete'])) {
            foreach($this->data['User']['delete'] as $id => $delete) {
                if ($delete == 1) {
                    if ($this->User->delete($id)) {
                        $delete_count++;
                    }
                }
            }
        }
        $this->Session->setFlash($delete_count . ' User' . (($delete_count == 1) ? ' was' : 's were') . ' deleted');
        $this->redirect('index');
    }
    
    function login() {
        if (!empty($this->data) && $this->Auth->user())
        {
            $this->User->id = $this->Auth->user('id');
            //e($this->User->id);exit();
            if($this->User->id!=null)
            {
                $this->redirect('/');
            }else
                {
                    $this->redirect('/Users/login');
                }
        }
    }
    
    function logout() {
        //$this->Session->setFlash('You are now logged out');
        session_destroy();
        //unset($_SESSION);
        $this->redirect($this->Auth->logout());
    }
}
