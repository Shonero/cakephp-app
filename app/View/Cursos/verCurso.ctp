<div class="cursos view">
    <h2><?php echo h($curso['Curso']['nombre']); ?></h2>
    <dl class="dl-horizontal">
        <dt><?php echo __('Descripción'); ?></dt>
        <dd><?php echo h($curso['Curso']['descripcion']); ?></dd>
        <dt><?php echo __('Fecha de Inicio'); ?></dt>
        <dd><?php echo h($curso['Curso']['fecha_inicio']); ?></dd>
        <dt><?php echo __('Fecha de Fin'); ?></dt>
        <dd><?php echo h($curso['Curso']['fecha_fin']); ?></dd>
    </dl>
</div>

<div class="related">
    <h3><?php echo __('Compañeros de Clase'); ?></h3>
    <?php if (!empty($curso['Usuario'])): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?php echo __('Nombre'); ?></th>
                    <th><?php echo __('Correo Electrónico'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($curso['Usuario'] as $usuario): ?>
                    <tr>
                        <td><?php echo h($usuario['nombre']); ?></td>
                        <td><?php echo h($usuario['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">
            <p><?php echo __('No hay compañeros de clase en este curso.'); ?></p>
        </div>
    <?php endif; ?>
</div>

<div class="actions">
    <?php echo $this->Html->link(
        '<span class="glyphicon glyphicon-arrow-left"></span> Volver a Mis Cursos',
        array('action' => 'miscursos'),
        array('class' => 'btn btn-default', 'escape' => false)
    ); ?>
</div>