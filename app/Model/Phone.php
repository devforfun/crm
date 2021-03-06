<?php
App::uses('AppModel', 'Model');
/**
 * Phone Model
 *
 * @property Contact $Contact
 */
class Phone extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'number' => array(
					        'rule' => 'phone',
					        'regex' => null,
					        'country' => 'us',
					        'message' => 'Please supply a valid US Phone number. (xxx) xxx-xxxx'
					    ),
		'contact_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
