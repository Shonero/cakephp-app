<?php
App::uses('AppController', 'Controller');
/**
 * Cursos Controller
 */
class CursosController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

	public $uses = array('Curso', 'Usuario'); // Usa los modelos necesarios
	public $components = array('Paginator');
    
    public function beforeFilter() {
        parent::beforeFilter();
    
        // Permitir acceso a las acciones solo si el usuario tiene el perfil "Usuario"
        if ($this->Auth->user('perfil') == 'user') {
            $this->Auth->allow('misCursos', 'verCurso');
        }
    }
    public function index() {
       
		$this->set('cursos', $this->Curso->find('all'));
        
    }

  


    public function agregar() {
        // Obtener la lista de usuarios disponibles
        $this->loadModel('Usuario'); 
        $usuarios = $this->Usuario->find('list', array(
            'fields' => array('Usuario.id', 'Usuario.nombre'),
            'conditions' => array('Usuario.perfil' => 'user') // Filtra solo usuarios con perfil "user"
        ));
    
        if ($this->request->is('post')) {
            // Crear el nuevo curso
            $this->Curso->create();
    
            // Guardar los datos del curso
            if ($this->Curso->save($this->request->data)) {
                // Obtener el ID del curso recién creado
                $cursoId = $this->Curso->id;
    
                // Asignar los usuarios seleccionados al curso
                if (!empty($this->request->data['Usuario']['usuarios'])) {
                    foreach ($this->request->data['Usuario']['usuarios'] as $usuarioId) {
                        // Crear la relación entre el curso y el usuario
                        $this->Curso->UsuariosCurso->create();
                        $this->Curso->UsuariosCurso->save(array(
                            'curso_id' => $cursoId,
                            'usuario_id' => $usuarioId
                        ));
                    }
                }
    
                $this->Session->setFlash('El curso ha sido creado y los usuarios asignados correctamente.', 'default', array('class' => 'alert alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('No se pudo crear el curso. Por favor, intente nuevamente.', 'default', array('class' => 'alert alert-danger'));
            }
        }
    
        // Pasar la lista de usuarios disponibles a la vista
        $this->set(compact('usuarios'));
    }



   
        public function editar($id = null) {
            if (!$id) {
                throw new NotFoundException(__('Curso no válido'));
            }
            $curso = $this->Curso->findById($id);
            if (!$curso) {
                throw new NotFoundException(__('Curso no encontrado'));
            }
        
            // Obtener todos los usuarios
            $usuarios = $this->Curso->Usuario->find('all' ,array('conditions' => array('Usuario.perfil' => 'user')));
        
            // Obtener los IDs de los usuarios inscritos en el curso
            $usuariosInscritosIds = $this->Curso->UsuariosCurso->find('list', array(
                'conditions' => array('UsuariosCurso.curso_id' => $id),
                'fields' => array('usuario_id')
            ));
        
            // Marcar los usuarios inscritos
            foreach ($usuarios as &$usuario) {
                $usuario['Usuario']['inscrito'] = in_array($usuario['Usuario']['id'], $usuariosInscritosIds);
            }
        




            if ($this->request->is(array('post', 'put'))) {
                $this->Curso->id = $id;
                if ($this->Curso->save($this->request->data)) {
                    // Agregar usuarios seleccionados al curso
                    if (!empty($this->request->data['Usuario']['agregar'])) {
                        foreach ($this->request->data['Usuario']['agregar'] as $usuarioId) {
                            $this->Curso->UsuariosCurso->create();
                            $this->Curso->UsuariosCurso->save(array(
                                'curso_id' => $id,
                                'usuario_id' => $usuarioId
                            ));
                        }
                    }
        
                    // Eliminar usuarios seleccionados del curso
                    if (!empty($this->request->data['Usuario']['eliminar'])) {
                        foreach ($this->request->data['Usuario']['eliminar'] as $usuarioId) {
                            $this->Curso->UsuariosCurso->deleteAll(array(
                                'curso_id' => $id,
                                'usuario_id' => $usuarioId
                            ));
                        }
                    }
        
                    $this->Flash->success(__('Curso actualizado correctamente.'));
                    return $this->redirect(array('action' => 'index'));
                }
                $this->Flash->error(__('No se pudo actualizar el curso.'));
            }
        
            if (!$this->request->data) {
                $this->request->data = $curso;
            }
        
            $this->set(compact('curso', 'usuarios'));
        }
    

    public function eliminar($id = null) {

        if ($this->request->is('post')) {
            if ($this->Curso->delete($id)) {
                $this->Session->setFlash('Curso eliminado.');
            } else {
                $this->Session->setFlash('Error al eliminar el curso.');
            }
            return $this->redirect(array('action' => 'index'));
        }
    }



    
    public function ver($id = null) {
        // Verificar si el curso existe
        if (!$id || !$this->Curso->exists($id)) {
            throw new NotFoundException(__('Curso no encontrado.'));
        }
    
        // Obtener los detalles del curso junto con los usuarios inscritos
        $curso = $this->Curso->find('first', array(
            'conditions' => array('Curso.id' => $id),
            'contain' => array('User') // Obtener los usuarios inscritos
        ));
    
        // Pasar los datos del curso a la vista
        $this->set(compact('curso'));
    }


    
    public function removeSelectedUsers($cursoId = null) {
        if ($this->request->is('post')) {
            $usuarios = $this->request->data['usuarios'];
            if (!empty($usuarios)) {
                foreach ($usuarios as $usuarioId) {
                    $this->Curso->UsuariosCurso->deleteAll(array(
                        'UsuariosCurso.curso_id' => $cursoId,
                        'UsuariosCurso.usuario_id' => $usuarioId
                    ));
                }
                $this->Flash->success(__('Usuarios eliminados correctamente.'));
            } else {
                $this->Flash->error(__('No se seleccionaron usuarios para eliminar.'));
            }
        }
        return $this->redirect(array('action' => 'editar', $cursoId));
    }

    public function addSelectedUsers($cursoId = null) {
        // Solo permitir solicitudes AJAX
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException();
        }
    
        // Configurar la respuesta como JSON
        $this->autoRender = false;
        $this->response->type('json');
    
        $response = array('success' => false, 'message' => 'Error al procesar la solicitud.');
    
        if ($this->request->is('post')) {
            // Verificar si se enviaron usuarios seleccionados
            if (!empty($this->request->data['usuarios'])) {
                foreach ($this->request->data['usuarios'] as $usuarioId) {
                    // Verificar si el usuario ya está inscrito en el curso
                    $existe = $this->Curso->UsuariosCurso->find('first', array(
                        'conditions' => array(
                            'UsuariosCurso.curso_id' => $cursoId,
                            'UsuariosCurso.usuario_id' => $usuarioId
                        )
                    ));
    
                    // Si no existe, crear la relación
                    if (!$existe) {
                        $this->Curso->UsuariosCurso->create();
                        $this->Curso->UsuariosCurso->save(array(
                            'curso_id' => $cursoId,
                            'usuario_id' => $usuarioId
                        ));
                    }
                }
                $response['success'] = true;
                $response['message'] = 'Usuarios agregados correctamente.';
            } else {
                $response['message'] = 'No se seleccionaron usuarios para agregar.';
            }
        }
    
        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }

    

    public function misCursos() {
       
        
        $user = $this->Auth->user(['Usuario']);
        $user = $this->checkRoleByEmail($user['email']);
     
        // Obtener los cursos en los que el usuario está inscrito
        $this->Curso->unbindModel(array('hasMany' => array('UsuariosCurso'))); // Evitar cargar datos innecesarios
        $cursos = $this->Curso->find('all', array(
            'joins' => array(
                array(
                    'table' => 'usuarios_cursos',
                    'alias' => 'UsuariosCurso',
                    'type' => 'INNER',
                    'conditions' => array(
                        'UsuariosCurso.curso_id = Curso.id',
                        'UsuariosCurso.usuario_id' => $user
                    )
                )
            )
        ));
        
    
        // Pasar los cursos a la vista
        $this->set('cursos', $cursos);
    }

    public function verCurso($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Curso no válido'));
        }
    
        // Obtener el curso con los usuarios inscritos
        $curso = $this->Curso->find('first', array(
            'conditions' => array('Curso.id' => $id),
            'contain' => array(
                'Usuario' => array(
                    'fields' => array('Usuario.id', 'Usuario.nombre', 'Usuario.email')
                )
            )
        ));
    
        if (!$curso) {
            throw new NotFoundException(__('Curso no encontrado'));
        }
    
        // Pasar los datos a la vista
        $this->set('curso', $curso);

    }
    public function checkRoleByEmail($email) {

    
        $this->loadModel('Usuario'); 
        $id= $this->Usuario->getIdByEmail($email);
        
        if ($id) {
            return $id;
        } else {
            throw new NotFoundException(__('Usuario no encontrado'));
        }
    }
}
