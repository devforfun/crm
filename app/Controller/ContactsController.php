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
		$this->Contact->recursive = 0;
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
		public function import(){
			
			if ($this->request->is('post')) {
				if($this->uploadFile()){
					$this->parseUpload();
				}
			}		
		}
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
		private function parseUpload() {

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
				    }
				    else
				    {
				        $objPHPExcel = PHPExcel_IOFactory::load($this->request->data['Upload']['file']['path']);
				    }
					foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
					    $worksheetTitle     = $worksheet->getTitle();
					    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
					    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
					    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
					    $nrColumns = ord($highestColumn) - 64;

					    echo "<br>The file ".$this->request->data['Upload']['file']['name']." has been uploaded in ".$this->request->data['Upload']['time']." seconds worksheet ".$worksheetTitle." has ";
					    echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
					    echo ' and ' . $highestRow . ' row.';
					    echo '<br>Data: <table border="1"><tr>';
					    for ($row = 1; $row <= $highestRow; ++ $row) {
				        	
				        	if($this->request->data['Upload']['header_row'] and $row==1)
			        			continue;
	
					        echo '<tr>';
					        $dataCell['Contact']['firstname']=$worksheet->getCellByColumnAndRow(0, $row)->getValue();
					        $dataCell['Contact']['lastname']=$worksheet->getCellByColumnAndRow(1, $row)->getValue();
					        $dataCell['Contact']['gender']=$worksheet->getCellByColumnAndRow(4, $row)->getValue();
					        $cellDate = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					        $dataCell['Contact']['birthdate']=date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($cellDate));
					        
					        $this->Contact->set($dataCell);
					        
					        if($this->Contact->validates())
					        {    echo '<td>Valid</td>';
					    		$this->Contact->save();
					        }else{
					            echo '<td>Unvalid</td>';
					        }

					        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
					            $cell = $worksheet->getCellByColumnAndRow($col, $row);
					            if(PHPExcel_Shared_Date::isDateTime($cell)){
                                            $cellValue = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                                            $dateValue = PHPExcel_Shared_Date::ExcelToPHP($cellValue);                       
                                            $val  =  date('Y-m-d',$dateValue);                            

                                }else{
						            $val = $cell->getFormattedValue();

                                } 
					            $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
					            echo '<td>' . $val . '<br>(Typ ' . $dataType . ')</td>';
					        }
					        echo '</tr>';
					    }
					    echo '</table>';
					}
		}
}
