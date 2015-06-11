<?php
App::uses('AppController', 'Controller');
App::import('Vendor','Classes/PHPExcel');
/**
 * Contacts Controller
 *
 * @property Contact $Contact
 * @property PaginatorComponent $Paginator
 */
class ContactsController extends AppController {

	private $time="";

	var $uses = array('Contact','Log');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter() {
		$this->time=microtime();
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set('contacts', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Contact->exists($id)) {
			throw new NotFoundException(__('Invalid contact'));
		}
		$options = array('conditions' => array('Contact.' . $this->Contact->primaryKey => $id));
		$this->set('contact', $this->Contact->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Contact->create();
			$this->request->data['Contact']['user_id']=$this->Auth->user('id');
			if ($this->Contact->save($this->request->data)) {
				
				$phone['Phone']['number']=$this->request->data['Contact']['number'];
				$phone['Phone']['contact_id']=$this->Contact->id;
				
				$this->Contact->Phone->create();
				$this->Contact->Phone->save($phone);
				
				$email['Email']['email']=$this->request->data['Contact']['email'];
				$email['Email']['contact_id']=$this->Contact->id;
				

				$this->Contact->Email->create();
				$this->Contact->Email->save($email);
				$this->Session->setFlash(__('The contact has been saved.'));
		
				$this->set('result', true);

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contact could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Contact->exists($id)) {
			throw new NotFoundException(__('Invalid contact'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Contact->save($this->request->data)) {
				$this->Session->setFlash(__('The contact has been saved.'));
				$this->set('result', true);
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contact could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Contact.' . $this->Contact->primaryKey => $id));
		$this->set('contact', $this->Contact->find('first', $options));
			$this->request->data = $this->Contact->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Contact->id = $id;
		if (!$this->Contact->exists()) {
			throw new NotFoundException(__('Invalid contact'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Contact->delete()) {
			$this->Session->setFlash(__('The contact has been deleted.'));
		} else {
			$this->Session->setFlash(__('The contact could not be deleted. Please, try again.'));
		}
		$this->set('result', true);
		return $this->redirect(array('action' => 'index'));
	}

/**
 * import method
 *
 * @return void
 */

	public function import(){
		
		if ($this->request->is('post')) {
			if($this->uploadFile()){
				$result=$this->processUpload();
				$datalog["Log"]=array("description"=>$result['msg'],"user_id"=>$this->Auth->user('id') );
				
				$this->Log->save($datalog);
				$this->set('result', $result['result']);
				$this->set('msg', $result['msg']);

			}
		}else{

		}		
	}

/**
 * uploadFile method
 *
 * @return void
 */

	private function uploadFile() {
		  $file = $this->request->data['Upload']['file'];
		  if ($file['error'] === UPLOAD_ERR_OK) {
		    $id = String::uuid();
		    if (move_uploaded_file($file['tmp_name'], APP.DS.'webroot'.DS.'uploads'.DS.$file['name'])) {
		      $this->request->data['Upload']['user_id'] = $this->Auth->user('id');
		      $this->request->data['Upload']['file']['path'] = APP.DS.'webroot'.DS.'uploads'.DS.$file['name'];
		      $this->request->data['Upload']['file']['extension'] = pathinfo($file['name'], PATHINFO_EXTENSION);
		      $this->request->data['Upload']['time'] =  round(($this->time), 4);
		      return true;
		    }
		  }
		  return false;
	}

/**
 * processUpload method
 *
 * @return void
 */

	private function processUpload() {

		if($this->request->data['Upload']['file']['extension']=='csv')
	    {
	        $objPHPExcel = PHPExcel_IOFactory::createReader('CSV')
	            ->setDelimiter(';')
	            ->setEnclosure('"')
	            ->setLineEnding("\n")
	            ->setSheetIndex(0)
	            ->load($this->request->data['Upload']['file']['path']); 
	    } elseif ($this->request->data['Upload']['file']['extension']=='tsv') {
	    	$objPHPExcel = PHPExcel_IOFactory::createReader('CSV')
	            ->setDelimiter('	')
	            ->setEnclosure('"')
	            ->setLineEnding("\n")
	            ->setSheetIndex(0)
	            ->load($this->request->data['Upload']['file']['path']); 
	    } else {
	        $objPHPExcel = PHPExcel_IOFactory::load($this->request->data['Upload']['file']['path']);
	    }

		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

		    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
		    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		   
		    $nrColumns = ord($highestColumn) - 64;

		    $nrUsers=$highestRow;

	       	if($this->request->data['Upload']['header_row'])
	       		$nrUsers--;

	       	if($nrUsers<=0){
	       		$result['result']=false;
	       		$result['msg']="There is no records in the file";
	       		return $result;
	       	}
		    

	       	if($nrColumns<3){
	       		$result['result']=false;
	       		$result['msg']="Contact data is missing, the required contact information is first name, last name and phone number, there is only $nrColumns data columns";
	       		return $result;
	       	}


		    for ($row = 1; $row <= $highestRow; ++ $row) {
	        	
	        	if($this->request->data['Upload']['header_row'] and $row==1)
        			continue;

		        $dataCell['Contact']['firstname']=$worksheet->getCellByColumnAndRow(0, $row)->getValue();
		        $dataCell['Contact']['lastname']=$worksheet->getCellByColumnAndRow(1, $row)->getValue();

		        $array_numbers=explode(',',$worksheet->getCellByColumnAndRow(2, $row)->getValue());
		        $numbers=array();
		        foreach($array_numbers as $number){
		        	$numbers[]=array('number'=>$number);
		        }
		        $dataCell['Phone']=$numbers;

		        $array_emails=explode(',',$worksheet->getCellByColumnAndRow(3, $row)->getValue());
		        $emails=array();
		        foreach($array_emails as $email){
		        	$emails[]=array('email'=>$email);
		        }

		        $dataCell['Email']=$emails;
		        $dataCell['Contact']['gender']=$worksheet->getCellByColumnAndRow(4, $row)->getValue();
		        $dataCell['Contact']['user_id']=$this->request->data['Upload']['user_id'];
		        
		        $cellDate = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
		        $dataCell['Contact']['birthdate']=date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($cellDate));
		        
		        $this->Contact->set($dataCell);
		        


		        if($this->Contact->saveAll($dataCell, array('validate' => 'only')))				    
		        {   
		        	$validRecords[]=$dataCell;

		        }else{
		       		$result['result']=false;
		    		$result['msg'] = "<p>The file <strong>".$this->request->data['Upload']['file']['name']."</strong> has been uploaded in ".$this->request->data['Upload']['time']." seconds at ".date("F j, Y, g:i a")." by the user: <strong> ".AuthComponent::user('username')."</strong> with ".count(array_keys($this->Contact->invalidFields()))." errors. </p>";
		       		$result['msg'].="<p>These fields are invalid : <strong>".implode(", ",array_keys($this->Contact->invalidFields())). "</strong> on the row number $row</p>";

	       			return $result;

		        }

		    }
		}
			$this->Contact->saveAll($validRecords,array('deep' => true));
	       	$result['result']=true;
		    $result['msg'] = "<p>The file <strong>".$this->request->data['Upload']['file']['name']."</strong> has been imported in ".$this->request->data['Upload']['time']." seconds at ".date("F j, Y, g:i a")." by the user <strong> ".AuthComponent::user('username')."</strong> with 0 errors. </p>";
		    $result['msg'].= "<p>The file has ". $nrColumns . ' data columns and ' . $nrUsers . ' contacts were imported.</p>';
		   
		    return $result;
	}
}
