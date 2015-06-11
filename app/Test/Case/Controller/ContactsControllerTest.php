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
								),
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
							),
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
            'Contact' => array(
                'firstname' => "firstname",
                'lastname' => "lastname",
                'gender' => "M",
                'user_id' => "1",
                'birthdate' => array("month" => '06'),
                'birthdate' => array("day" => '10'),
                'birthdate' => array("year" => '2015'),
                'number' => '(541) 754-3010',
                'email' => 'email@email.com',
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

/**
 * testProcessUploadXLSX method
 *
 * @return void
 */
	public function testProcessUploadXLSX() {
		
		$data['Upload']['user_id'] = 1;
	      $data['Upload']['file']['name'] = "format_contact.xlsx";
	      $data['Upload']['file']['path'] = APP.DS.'webroot'.DS.'tests'.DS."format_contact.xlsx";
	      $data['Upload']['file']['extension'] = "xlsx";
	      $data['Upload']['header_row'] = 1;
	      $data['Upload']['time'] =  round((microtime()), 4);

		$result = $this->testAction(
            '/contacts/processUpload',
            array('data' => $data, 'method' => 'post','return' => 'result')
        );
        $this->assertEqual($result['result'],true);
	}

/**
 * testProcessUploadXLS method
 *
 * @return void
 */
	public function testProcessUploadXLS() {
		
		$data['Upload']['user_id'] = 1;
	      $data['Upload']['file']['name'] = "format_contact.xls";
	      $data['Upload']['file']['path'] = APP.DS.'webroot'.DS.'tests'.DS."format_contact.xls";
	      $data['Upload']['file']['extension'] = "xls";
	      $data['Upload']['header_row'] = 1;
	      $data['Upload']['time'] =  round((microtime()), 4);

		$result = $this->testAction(
            '/contacts/processUpload',
            array('data' => $data, 'method' => 'post','return' => 'result')
        );
        $this->assertEqual($result['result'],true);
	}

/**
 * testProcessUploadCSV method
 *
 * @return void
 */
	public function testProcessUploadCSV() {
		
		$data['Upload']['user_id'] = 1;
	      $data['Upload']['file']['name'] = "format_contact.csv";
	      $data['Upload']['file']['path'] = APP.DS.'webroot'.DS.'tests'.DS."format_contact.csv";
	      $data['Upload']['file']['extension'] = "csv";
	      $data['Upload']['header_row'] = 1;
	      $data['Upload']['time'] =  round((microtime()), 4);

		$result = $this->testAction(
            '/contacts/processUpload',
            array('data' => $data, 'method' => 'post','return' => 'result')
        );
        $this->assertEqual($result['result'],true);
	}
/**
 * testProcessUploadCSV method
 *
 * @return void
 */
	public function testProcessUploadTSV() {
		
		$data['Upload']['user_id'] = 1;
	      $data['Upload']['file']['name'] = "format_contact.tsv";
	      $data['Upload']['file']['path'] = APP.DS.'webroot'.DS.'tests'.DS."format_contact.tsv";
	      $data['Upload']['file']['extension'] = "tsv";
	      $data['Upload']['header_row'] = 1;
	      $data['Upload']['time'] =  round((microtime()), 4);

		$result = $this->testAction(
            '/contacts/processUpload',
            array('data' => $data, 'method' => 'post','return' => 'result')
        );
        $this->assertEqual($result['result'],true);
	}
/**
 * testProcessUploadLessInfo method
 *
 * @return void
 */
	public function testProcessUploadLessInfo() {
		
		$data['Upload']['user_id'] = 1;
	      $data['Upload']['file']['name'] = "less_info_contact.xlsx";
	      $data['Upload']['file']['path'] = APP.DS.'webroot'.DS.'tests'.DS."less_info_contact.xlsx";
	      $data['Upload']['file']['extension'] = "xlsx";
	      $data['Upload']['header_row'] = 1;
	      $data['Upload']['time'] =  round((microtime()), 4);

		$result = $this->testAction(
            '/contacts/processUpload',
            array('data' => $data, 'method' => 'post','return' => 'result')
        );
        $this->assertEqual($result['result'],false);
	}

/**
 * testProcessUploadBadInfo method
 *
 * @return void
 */
	public function testProcessUploadBadInfo() {
		
		$data['Upload']['user_id'] = 1;
	      $data['Upload']['file']['name'] = "bad_info_contact.xlsx";
	      $data['Upload']['file']['path'] = APP.DS.'webroot'.DS.'tests'.DS."bad_info_contact.xlsx";
	      $data['Upload']['file']['extension'] = "xlsx";
	      $data['Upload']['header_row'] = 1;
	      $data['Upload']['time'] =  round((microtime()), 4);

		$result = $this->testAction(
            '/contacts/processUpload',
            array('data' => $data, 'method' => 'post','return' => 'result')
        );
        $this->assertEqual($result['result'],false);
	}

}
