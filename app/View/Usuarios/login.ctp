<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Iniciar Sesión</h3>
            </div>
            <div class="card-body">
                <?php echo $this->Form->create('Usuario', array('url' => array('controller' => 'usuarios', 'action' => 'login'))); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => 'Correo Electrónico')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('password', array('class' => 'form-control', 'label' => 'Contraseña', 'type' => 'password')); ?>
                </div>
                <?php echo $this->Form->button('Iniciar Sesión', array('class' => 'btn btn-primary')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>