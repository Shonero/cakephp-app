<div class="usuarios form">
<?php echo $this->Form->create('Usuario'); ?>
	<fieldset>
		<legend><?php echo __('Add Usuario'); ?></legend>
	<?php
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('nombre');
		echo $this->Form->input('perfil', array(
			'class' => 'form-control',
			'options' => array('admin' => 'Administrador', 'user' => 'Usuario')
		));
		echo $this->Form->input('activo');
	?>
	</fieldset>

	<fieldset>
        <legend><?php echo __('Cursos Asignados'); ?></legend>
        <?php
            echo $this->Form->input('Curso', array(
                'class' => 'form-check-input',
                'type' => 'select',
                'multiple' => 'checkbox',
                'options' => $cursos
            ));
        ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Cursos'), array('controller' => 'cursos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Curso'), array('controller' => 'cursos', 'action' => 'agregar')); ?> </li>
	</ul>
</div>
