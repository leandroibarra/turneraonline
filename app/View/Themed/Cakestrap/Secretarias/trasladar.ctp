<?php
/**
 *
 *
 */
?>
<div class="row-fluid">
    <div class="span4 well">
        <h3>Turno original</h3>
        <table class="table table-bordered table-condensed">
            <tbody>
                <tr>
                    <td>#ID</td>
                    <td><?php echo h( "#".$turno_original['Turno']['id_turno']); ?></td>
                </tr>
                <tr>
                    <td>Fecha</td>
                    <td><?php echo date('d/m/Y', strtotime( $turno_original['Turno']['fecha_inicio'] ) ); ?></td>
                </tr>
                <tr>
                    <td>Hora</td>
                    <td><?php echo date('H:i', strtotime( $turno_original['Turno']['fecha_inicio'] ) ); ?></td>
                </tr>
                <tr>
                    <td>Medico</td>
                    <td><?php echo h( $turno_original['Medico']['razonsocial'] ); ?></td>
                </tr>
                <tr>
                    <td>Consultorio</td>
                    <td><?php echo h( $turno_original['Consultorio']['nombre']); ?></td>
                </tr>
                <tr>
                    <td>Paciente</td>
                    <td><?php echo h( $turno_original['Paciente']['razonsocial']); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="span8">
        <?php if( count( $turnos ) > 0 ) : ?>
            <table class="table table-bordered table-condensed table-striped">
                <tbody>
                    <tr>
                        <th>#ID</th>
                        <th>Horario</th>
                        <th>Médico</th>
                        <th>Consultorio</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach( $turnos as $turno ) : ?>
                    <tr>
                        <td><?php echo h( "#".$turno['Turno']['id_turno'] ); ?></td>
                        <td><?php echo date( 'H:i', strtotime( $turno['Turno']['fecha_inicio'] ) ); ?> a
                            <?php echo date( 'H:i', strtotime( $turno['Turno']['fecha_fin'] ) ); ?></td>
                        <td><?php //echo h( $turno['Medico']['razonsocial'] ); ?></td>
                        <td><?php echo h( $turno['Consultorio']['nombre'] ); ?></td>
                        <td>
                            <?php echo $this->Html->link( 'Trasladar', "#" ); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No existe ningún turno al cual se pueda trasladar el turno original</p>
        <?php endif; ?>
    </div>
</div>
