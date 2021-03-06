<div class="phones view">
<h2><?php echo __('Phone'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($phone['Phone']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number'); ?></dt>
		<dd>
			<?php echo h($phone['Phone']['number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contact Id'); ?></dt>
		<dd>
			<?php echo h($phone['Phone']['contact_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Phone'), array('action' => 'edit', $phone['Phone']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Phone'), array('action' => 'delete', $phone['Phone']['id']), array(), __('Are you sure you want to delete # %s?', $phone['Phone']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Phones'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phone'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contacts'), array('controller' => 'contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact'), array('controller' => 'contacts', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Contacts'); ?></h3>
	<?php if (!empty($phone['Contact'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('First Name'); ?></th>
		<th><?php echo __('Last Name'); ?></th>
		<th><?php echo __('Gender'); ?></th>
		<th><?php echo __('Birthdate'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php $contact=$phone['Contact']; ?>
		<tr>
			<td><?php echo $contact['id']; ?></td>
			<td><?php echo $contact['firstname']; ?></td>
			<td><?php echo $contact['lastname']; ?></td>
			<td><?php echo $contact['gender']; ?></td>
			<td><?php echo $contact['birthdate']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'contacts', 'action' => 'view', $contact['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'contacts', 'action' => 'edit', $contact['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'contacts', 'action' => 'delete', $contact['id']), array(), __('Are you sure you want to delete # %s?', $contact['id'])); ?>
			</td>
		</tr>
	<?php  ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Contact'), array('controller' => 'contacts', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
