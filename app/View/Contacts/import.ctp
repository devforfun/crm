<div class="contacts index">
<?php
if(isset($result)){
	if($result==true)
		echo "<h2>Succes</h2>";
	else
		echo "<h2>Error</h2>";

echo "$msg";
}  
?>

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

?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>		
		<li><?php echo $this->Html->link(__('List Contacts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact'), array('action' => 'add')); ?> </li>
	</ul>
</div>