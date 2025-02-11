<?php
App::uses('AppController', 'Controller');
/**
 * Usuarios Controller
 */

class UsuariosController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
public $scaffold;
	
public $components = array('Paginator');

		public function login() {
			if ($this->request->is('post')) {
				// Intenta autenticar al usuario
				//pr($this->Auth->user());die;
				if ($this->Auth->login($this->request->data)) {
					// Redirige a la URL definida en loginRedirect

					$user = $this->checkRoleByEmail($this->request->data['Usuario']['email']);
					if ($user === 'admin') {
						return $this->redirect(array('controller' => 'usuarios', 'action' => 'index'));
					} else {
						return $this->redirect(array('controller' => 'cursos', 'action' => 'miscursos')); // Página de usuario normal
					}


					//return $this->redirect($this->Auth->redirectUrl());
				} else {
					// Muestra un mensaje de error si las credenciales son incorrectas
					$this->Flash->error(__('Email o contraseña incorrectos.'));
				}
			}
		}


		
	
	
		public function logout() {
			// Cierra la sesión del usuario
			$this->Flash->success(__('Has cerrado sesión.'));
			return $this->redirect($this->Auth->logout());
		}
	
	
	
		// Listar todos los usuarios
		public function index() {
			$this->set('usuarios', $this->Usuario->find('all'));

		}

		
		
		// Ver detalles de un usuario
		public function ver($id = null) {
			if (!$id) {
				throw new NotFoundException(__('Usuario no válido'));
			}
			$usuario = $this->Usuario->findById($id);
			if (!$usuario) {
				throw new NotFoundException(__('Usuario no encontrado'));
			}
			$this->set('usuario', $usuario);
		}
	
		// Agregar un nuevo usuario
		public function agregar() {
			if ($this->request->is('post')) {
				$this->Usuario->create();
				$this->request->data['Usuario']['password'] = password_hash(
					$this->request->data['Usuario']['password'],
					PASSWORD_DEFAULT
				); // Hashear la contraseña
				if ($this->Usuario->save($this->request->data)) {
					$this->Flash->success(__('Usuario creado correctamente.'));
					return $this->redirect(array('action' => 'index'));
				}
				$this->Flash->error(__('No se pudo crear el usuario.'));
			}

				$this->loadModel('Curso'); 
			  	// Obtener todos los cursos disponibles
			$cursos = $this->Usuario->Curso->find('list', array(
				'fields' => array('id', 'nombre')
			));
				
				$this->set(compact('cursos'));


			
		}
	
		// Editar un usuario existente
		public function editar($id = null) {
			if (!$id) {
				throw new NotFoundException(__('Usuario no válido'));
			}
			$usuario = $this->Usuario->findById($id);
			if (!$usuario) {
				throw new NotFoundException(__('Usuario no encontrado'));
			}
		
			// Obtener todos los cursos disponibles
			$cursos = $this->Usuario->Curso->find('list', array(
				'fields' => array('id', 'nombre')
			));
		
			// Obtener los cursos asignados al usuario
			$cursosAsignados = $this->Usuario->UsuariosCurso->find('list', array(
				'conditions' => array('UsuariosCurso.usuario_id' => $id),
				'fields' => array('curso_id')
			));
		
			if ($this->request->is(array('post', 'put'))) {
				$this->Usuario->id = $id;
				// Guardar el usuario y los cursos seleccionados
				if ($this->Usuario->saveAssociated($this->request->data)) {
					$this->Flash->success(__('Usuario actualizado correctamente.'));
					return $this->redirect(array('action' => 'index'));
				}
				$this->Flash->error(__('No se pudo actualizar el usuario.'));
			}
		
			if (!$this->request->data) {
				$this->request->data = $usuario;
				$this->request->data['Curso'] = $cursosAsignados; // Pre-seleccionar cursos asignados
			}
		
			$this->set(compact('usuario', 'cursos'));
		}
		
	
		// Eliminar un usuario
		public function eliminar($id) {
			if ($this->request->is('get')) {
				throw new MethodNotAllowedException();
			}
			if ($this->Usuario->delete($id)) {
				$this->Flash->success(__('Usuario eliminado correctamente.'));
			} else {
				$this->Flash->error(__('No se pudo eliminar el usuario.'));
			}
			return $this->redirect(array('action' => 'index'));
		}

		

		public function checkRoleByEmail($email) {

			$perfil= $this->Usuario->getRoleByEmail($email);
			if ($perfil) {
				return $perfil;
			} else {
				throw new NotFoundException(__('Usuario no encontrado'));
			}
		}

		


		


}
