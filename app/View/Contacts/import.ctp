<h2>Contact</h2>
<?php 
echo $this->Form->create('Upload', array('type'=>'file'));
echo $this->Form->input('file',array('type' => 'file'));
echo $this->Form->input('header_row', array(
    'label' => 'Skip header row',
    'selected' => true,
    'type'=>'checkbox'
));
echo $this->Form->end('Submit');
