<?php
App::uses('Phone', 'Model');

/**
 * Phone Test Case
 *
 */
class PhoneTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.phone',
		'app.user',
		'app.contact',
		'app.email'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Phone = ClassRegistry::init('Phone');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Phone);

		parent::tearDown();
	}

}
