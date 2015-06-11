<?php
App::uses('UsersController', 'Controller');

/**
 * UsersController Test Case
 *
 */
class UsersControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user',
		'app.email',
		'app.contact',
		'app.phone'
	);

/**
 * testIndex method
 *
 * @return void
 */
	
    public function testIndex() {
        $result = $this->testAction(
            '/users/index/',
            array('return' => 'vars')
        );
        $expected =array('users' => array(
							0 => array(
								'User' => array(
									'id' => '1',
									'firstname' => 'Test Name',
									'lastname' => 'Test LastName',
									'username' => 'user',
									'password' => '$2a$10$F12aJWR49FFfgiwfmrlopeOWkujiO0P/l1uxvXV6ZAyUzgms7XNZ6',
									'email' => 'email@email.com'
								)
							)
							)
						);
         $this->assertEqual($result,$expected);
    }

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
		$result = $this->testAction(
            '/users/view/1',
            array('return' => 'vars')
        );
        $expected=array(
						'user' => array(
							'User' => array(
								'id' => '1',
								'firstname' => 'Test Name',
								'lastname' => 'Test LastName',
								'username' => 'user',
								'password' => '$2a$10$F12aJWR49FFfgiwfmrlopeOWkujiO0P/l1uxvXV6ZAyUzgms7XNZ6',
								'email' => 'email@email.com'
							)
						)
					);
         $this->assertEqual($result,$expected);
        

	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
		$data = array(
            			'User' => array(
								'id' => '1',
								'firstname' => 'Test Name',
								'lastname' => 'Test LastName',
								'username' => 'user',
								'password' => 'user',
								'email' => 'email@email.com'
						)
        );
        $result = $this->testAction(
            '/users/add',
            array('data' => $data, 'method' => 'post','return' => 'vars')
        );
         $this->assertEqual($result['result'],true);

	}

/**
 * testEdit method
 *
 * @return void
 */
		public function testEdit() {
		$data = array(
            			'User' => array(
								'id' => '1',
								'firstname' => 'Test Name',
								'lastname' => 'Test LastName',
								'username' => 'user',
								'password' => 'user',
								'email' => 'email@email.com'
						)
        );
        $result = $this->testAction(
            '/users/edit/1',
            array('data' => $data, 'method' => 'put','return' => 'vars')
        );
         $this->assertEqual($result['result'],true);


	}


/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
		$result = $this->testAction(
            '/users/delete/1',
            array('method' => 'delete','return' => 'vars')
        );

        $this->assertEqual($result['result'],true);
	}

/**
 * testLogin method
 *
 * @return void
 */

	public function testLogin() {

		$data = array(
			            'User' => array(
			                			'username' => 'user',
										'password' => 'user'
			            				)
			        	);

        $result = $this->testAction(
            '/users/login',
            array('data' => $data, 'method' => 'post','return' => 'vars')
        );
		 
        $this->testAction(
            '/users/logout', array('method' => 'get')
        );

        $this->assertEqual($result['result'],true);
        

	}

}
