<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 10/27/15
 * Time: 11:58 PM
 */

namespace ZfcUser\Form;


class AddUser extends Base
{

    public function __construct()
    {
        parent::__construct('AddUser');
        $this->setAttribute('action', '/adddisciple');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'fullname',
            'attributes' => array('type' => 'text',
                'id' => 'name'
            ),
            'options' => array(
                'id' => 'name',
                'label' => 'Full Name:',
            )));
        $this->add(array(
            'name' => 'email',
            'attributes' => array('type' => 'email',
            ),
            'options' => array(),));
        $this->add(array(
            'name' => 'phonen',
            'attributes' => array('type' => 'number',
                'id' => 'phoneno'
            ),
            'options' => array(
                'id' => 'name',
                'label' => 'Phone NO:',
            )));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array('type' => 'submit',
                'value' => 'Eintragen'
            ),));

    }
}