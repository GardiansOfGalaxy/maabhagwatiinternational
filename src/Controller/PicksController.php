<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Picks Controller
 *
 * @method \App\Model\Entity\Pick[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PicksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain'=>['Deniers'],
        ];
        $picks = $this->paginate($this->Picks);

        $this->set(compact('picks'));
    }

    /**
     * View method
     *
     * @param string|null $id Pick id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pick = $this->Picks->get($id, [
            'contain' => ['Deniers'],
        ]);

        $this->set(compact('pick'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pick = $this->Picks->newEmptyEntity();
        if ($this->request->is('post')) {
            $pick = $this->Picks->patchEntity($pick, $this->request->getData());
            if ($this->Picks->save($pick)) {
                $this->Flash->success(__('The {0} has been saved.', 'Pick'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Pick'));
        }
        $deniers = $this->Picks->Deniers->find('list', ['valueField'=>'den', 'limit' => 200]);
        $this->set(compact('pick','deniers'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Pick id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pick = $this->Picks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pick = $this->Picks->patchEntity($pick, $this->request->getData());
            if ($this->Picks->save($pick)) {
                $this->Flash->success(__('The {0} has been saved.', 'Pick'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Pick'));
        }
        $deniers = $this->Picks->Deniers->find('list', ['valueField'=>'den', 'limit' => 200]);
        $this->set(compact('pick','deniers'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Pick id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pick = $this->Picks->get($id);
        if ($this->Picks->delete($pick)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Pick'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Pick'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
