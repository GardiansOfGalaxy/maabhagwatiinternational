<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Foldings Controller
 *
 * @method \App\Model\Entity\Folding[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FoldingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Lengths', 'Designs','Mtrperrolls'],
        ];
        $foldings = $this->paginate($this->Foldings);

        $this->set(compact('foldings'));
    }

    /**
     * View method
     *
     * @param string|null $id Folding id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $folding = $this->Foldings->get($id, [
            'contain' => ['Lengths', 'Designs','Mtrperrolls'],
        ]);

        $this->set(compact('folding'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $folding = $this->Foldings->newEmptyEntity();
        $session = $this->request->getSession();

        // Retrieve the last submitted date from the database
        $lastWaterjet = $this->Foldings->find()
            ->select(['date'])
            ->order(['date' => 'DESC'])
            ->first();

        // Get the date from the last entry, or default to the previous day
        $lastSubmittedDate = !empty($lastWaterjet) ? $lastWaterjet->date->format('Y-m-d') : date('Y-m-d', strtotime('-1 day'));

        if ($this->request->is('post')) {
            $folding = $this->Foldings->patchEntity($folding, $this->request->getData());
            if ($this->Foldings->save($folding)) {
                $this->Flash->success(__('The {0} has been saved.', 'Folding'));
                $session->write('lastSubmittedDate', $this->request->getData('date'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Folding'));
        }
        $lengths = $this->Foldings->Lengths->find('list', ['valueField'=>'L','limit' => 200]);
        $designs = $this->Foldings->Designs->find('list', ['keyValue'=>'name', 'limit' => 200]);
        $mtrperrolls = $this->Foldings->Mtrperrolls->find('list', ['valueField'=>'number', 'limit' => 200]);
        $this->set(compact('folding','lengths','designs','mtrperrolls','lastSubmittedDate'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Folding id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $folding = $this->Foldings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $folding = $this->Foldings->patchEntity($folding, $this->request->getData());
            if ($this->Foldings->save($folding)) {
                $this->Flash->success(__('The {0} has been saved.', 'Folding'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Folding'));
        }
        $lengths = $this->Foldings->Lengths->find('list', ['valueField'=>'L','limit' => 200]);
        $designs = $this->Foldings->Designs->find('list', ['keyValue'=>'name', 'limit' => 200]);
        $mtrperrolls = $this->Foldings->Mtrperrolls->find('list', ['valueField'=>'number', 'limit' => 200]);
        $this->set(compact('folding','lengths','designs','mtrperrolls'));

    }


    /**
     * Delete method
     *
     * @param string|null $id Folding id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $folding = $this->Foldings->get($id);
        if ($this->Foldings->delete($folding)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Folding'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Folding'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function deleteMultiple()
{
    if ($this->request->is('post')) {
        $ids = $this->request->getData('ids');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $folding = $this->Foldings->get($id);
                $this->Foldings->delete($folding);
            }
            $this->Flash->success(__('The selected records have been deleted.'));
        } else {
            $this->Flash->error(__('Please select at least one record to delete.'));
        }
    }
    return $this->redirect(['action' => 'index']);
}

}
