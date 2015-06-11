<div class="contacts form">
<?php echo $this->Form->create('Contact'); ?>
	<fieldset>
		<legend><?php echo __('Edit Contact'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
		$options = array('M' => 'Male', 'F' => 'Female');
		$attributes = array('legend' => false);
		echo $this->Form->radio('gender', $options, $attributes);
		echo $this->Form->input('birthdate');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Import Contacts'), array('action' => 'import')); ?></li>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Contact.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Contact.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Contacts'), array('action' => 'index')); ?></li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Emails'); ?></h3>
	<?php if (!empty($contact['Email'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Contact Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($contact['Email'] as $email): ?>
		<tr>
			<td><?php echo $email['id']; ?></td>
			<td><?php echo $email['email']; ?></td>
			<td><?php echo $email['contact_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'emails', 'action' => 'view', $email['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'emails', 'action' => 'edit', $email['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'emails', 'action' => 'delete', $email['id']), array(), __('Are you sure you want to delete # %s?', $email['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Email'), array('controller' => 'emails', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Phones'); ?></h3>
	<?php if (!empty($contact['Phone'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Number'); ?></th>
		<th><?php echo __('Contact Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($contact['Phone'] as $phone): ?>
		<tr>
			<td><?php echo $phone['id']; ?></td>
			<td><?php echo $phone['number']; ?></td>
			<td><?php echo $phone['contact_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'phones', 'action' => 'view', $phone['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'phones', 'action' => 'edit', $phone['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'phones', 'action' => 'delete', $phone['id']), array(), __('Are you sure you want to delete # %s?', $phone['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Phone'), array('controller' => 'phones', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
