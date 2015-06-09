<?php
App::uses('Email', 'Model');

/**
 * Email Test Case
 *
 */
class EmailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.email',
		'app.user',
		'app.contact',
		'app.phone'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Email = ClassRegistry::init('Email');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Email);

		parent::tearDown();
	}

}
