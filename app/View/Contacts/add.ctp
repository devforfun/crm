<div class="contacts form">
<?php echo $this->Form->create('Contact'); ?>
	<fieldset>
		<legend><?php echo __('Add Contact'); ?></legend>
	<?php
		echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
		$options = array('M' => 'Male', 'F' => 'Female');
		$attributes = array('legend' => false);
		echo $this->Form->radio('gender', $options, $attributes);
		echo $this->Form->input('birthdate');
		echo $this->Form->input('number');
		echo $this->Form->input('email');
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Import Contacts'), array('action' => 'import')); ?></li>
		<li><?php echo $this->Html->link(__('List Contacts'), array('action' => 'index')); ?></li>
	</ul>
</div>
