<?php
App::uses('AppController', 'Controller');
/**
 * Phones Controller
 *
 * @property Phone $Phone
 * @property PaginatorComponent $Paginator
 */
class PhonesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Phone->recursive = 0;
		$this->set('phones', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Phone->exists($id)) {
			throw new NotFoundException(__('Invalid phone'));
		}
		$options = array('conditions' => array('Phone.' . $this->Phone->primaryKey => $id));
		$this->set('phone', $this->Phone->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Phone->create();
			if ($this->Phone->save($this->request->data)) {
				$this->Session->setFlash(__('The phone has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phone could not be saved. Please, try again.'));
			}
		}
		$contacts = $this->Phone->Contact->find('list');
		$this->set(compact('contacts'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Phone->exists($id)) {
			throw new NotFoundException(__('Invalid phone'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Phone->save($this->request->data)) {
				$this->Session->setFlash(__('The phone has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phone could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Phone.' . $this->Phone->primaryKey => $id));
			$this->request->data = $this->Phone->find('first', $options);
		}
		$contacts = $this->Phone->Contact->find('list');
		$this->set(compact('contacts'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Phone->id = $id;
		if (!$this->Phone->exists()) {
			throw new NotFoundException(__('Invalid phone'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Phone->delete()) {
			$this->Session->setFlash(__('The phone has been deleted.'));
		} else {
			$this->Session->setFlash(__('The phone could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
