<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Agents Controller
 *
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AgentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $agents = $this->paginate($this->Agents);

        $this->set(compact('agents'));
    }

    /**
     * View method
     *
     * @param string|null $id Agent id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $agent = $this->Agents->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('agent'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $agent = $this->Agents->newEmptyEntity();
        if ($this->request->is('post')) {
            $agent = $this->Agents->patchEntity($agent, $this->request->getData());
            if ($this->Agents->save($agent)) {
                $this->Flash->success(__('The {0} has been saved.', 'Agent'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Agent'));
        }
        $this->set(compact('agent'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Agent id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $agent = $this->Agents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $agent = $this->Agents->patchEntity($agent, $this->request->getData());
            if ($this->Agents->save($agent)) {
                $this->Flash->success(__('The {0} has been saved.', 'Agent'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Agent'));
        }
        $this->set(compact('agent'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Agent id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $agent = $this->Agents->get($id);
        if ($this->Agents->delete($agent)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Agent'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Agent'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
