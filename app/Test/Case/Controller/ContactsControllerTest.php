<?php
App::uses('ContactsController', 'Controller');

/**
 * ContactsController Test Case
 *
 */
class ContactsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.contact',
		'app.email',
		'app.user',
		'app.phone'
	);

/**
 * testIndex method
 *
 * @return void
 */
	
    public function testIndex() {
        $result = $this->testAction(
            '/contacts/index/',
            array('return' => 'vars')
        );
        $expected =array('contacts' => array(
							0 => array(
								'Contact' => array(
									'id' => '1',
									'firstname' => 'Test Name',
									'lastname' => 'Test LastName',
									'gender' => 'M',
									'birthdate' => '2015-06-08',
									'user_id' => '1'
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
            '/contacts/view/1',
            array('return' => 'vars')
        );
        $expected=array(
						'contact' => array(
							'Contact' => array(
								'id' => '1',
								'firstname' => 'Test Name',
								'lastname' => 'Test LastName',
								'gender' => 'M',
								'birthdate' => '2015-06-08',
								'user_id' => '1'
							),
							'Email' => array(
								(int) 0 => array(
									'id' => '1',
									'email' => 'test@test.com',
									'contact_id' => '1'
								)
							),
							'Phone' => array(
								(int) 0 => array(
									'id' => '1',
									'number' => '(541) 754-3010',
									'contact_id' => '1'
								)
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
            'Contact' => array(
                'firstname' => "firstname",
                'lastname' => "lastname",
                'gender' => "M",
                'user_id' => "1",
                'birthdate' => array("month" => '06'),
                'birthdate' => array("day" => '10'),
                'birthdate' => array("year" => '2015'),
                'number' => '(541) 754-3010',
                'email' => 'email@email.com'
            )
        );
        $result = $this->testAction(
            '/contacts/add',
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
            'Contact' => array(
                'id' => "1",
                'firstname' => "firstname",
                'lastname' => "lastname",
                'gender' => "M",
                'user_id' => "1",
                'birthdate' => array("month" => '06'),
                'birthdate' => array("day" => '10'),
                'birthdate' => array("year" => '2015'),
                'number' => '(541) 754-3010',
                'email' => 'email@email.com'
            )
        );
        $result = $this->testAction(
            '/contacts/edit/1',
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
            '/contacts/delete/1',
            array('method' => 'delete','return' => 'vars')
        );

        $this->assertEqual($result['result'],true);
	}

}
