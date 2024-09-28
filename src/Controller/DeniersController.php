<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Deniers Controller
 *
 * @method \App\Model\Entity\Denier[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DeniersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $deniers = $this->paginate($this->Deniers);

        $this->set(compact('deniers'));
    }

    /**
     * View method
     *
     * @param string|null $id Denier id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $denier = $this->Deniers->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('denier'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $denier = $this->Deniers->newEmptyEntity();
        if ($this->request->is('post')) {
            $denier = $this->Deniers->patchEntity($denier, $this->request->getData());
            if ($this->Deniers->save($denier)) {
                $this->Flash->success(__('The {0} has been saved.', 'Denier'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Denier'));
        }
        $this->set(compact('denier'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Denier id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $denier = $this->Deniers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $denier = $this->Deniers->patchEntity($denier, $this->request->getData());
            if ($this->Deniers->save($denier)) {
                $this->Flash->success(__('The {0} has been saved.', 'Denier'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Denier'));
        }
        $this->set(compact('denier'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Denier id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $denier = $this->Deniers->get($id);
        if ($this->Deniers->delete($denier)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Denier'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Denier'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
