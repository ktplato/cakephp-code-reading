<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 * @method \App\Model\Entity\Task[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TasksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function search()
    {
        $this->fetchTable("Tasks");
        $tasks = $this->Tasks->find()->all();

        $this->set(compact('tasks'));
        $this->viewBuilder()->setOption('serialize', ['tasks']);
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->fetchTable("Tasks");
        $task = $this->Tasks->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('task'));
        $this->viewBuilder()->setOption('serialize', ['task']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function create()
    {
        $this->fetchTable("Tasks");
        $postData = $this->request->getData();
        
        $task = $this->Tasks->newEntity($postData);

        if ($task->hasErrors()) {
            $this->set('errors', $task->getErrors());
            $this->viewBuilder()->setOption('serialize', ['errors']);

            return;
        }

        if (!$this->Tasks->save($task)) {
            throw new \RuntimeException("save 失敗");
        }

        $this->set(compact('task'));
        $this->viewBuilder()->setOption('serialize', ['task']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function update(?string $id = null)
    {
        $this->fetchTable("Tasks");

        $task = $this->Tasks->get($id, [
            'contain' => [],
        ]);
        $postData = $this->request->getData();

        if ($task->hasErrors()) {
            $this->set('errors', $task->getErrors());
            $this->viewBuilder()->setOption('serialize', ['errors']);

            return;
        }

        if (!$this->Tasks->save($task)) {
            throw new \RuntimeException("save 失敗");
        }

        $this->set(compact('task'));
        $this->viewBuilder()->setOption('serialize', ['task']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->fetchTable("Tasks");

        $task = $this->Tasks->get($id, [
            'contain' => [],
        ]);

        if (!$this->Tasks->delete($task)) {
            throw new \RuntimeException("save 失敗");
        }

        $this->response = $this->response->withStatus(204);
        $this->viewBuilder()->setOption('serialize', []);
    }
}
