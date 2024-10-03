<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Mtrperrolls Controller
 *
 * @method \App\Model\Entity\Mtrperroll[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MtrperrollsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $mtrperrolls = $this->paginate($this->Mtrperrolls);

        $this->set(compact('mtrperrolls'));
    }

    /**
     * View method
     *
     * @param string|null $id Mtrperroll id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mtrperroll = $this->Mtrperrolls->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('mtrperroll'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mtrperroll = $this->Mtrperrolls->newEmptyEntity();
        if ($this->request->is('post')) {
            // Extract number from request data
            $number = (int)$this->request->getData('number');

            // Check if the number already exists in the database
            $existingMtrperroll = $this->Mtrperrolls->find()
                ->where(['number' => $number])
                ->first();

            if (!$existingMtrperroll) {
                // If the number doesn't exist, patch the entity and save it
                $mtrperroll = $this->Mtrperrolls->patchEntity($mtrperroll, $this->request->getData());
                if ($this->Mtrperrolls->save($mtrperroll)) {
                    $this->Flash->success(__('The {0} has been saved.', 'Mtrperroll'));

                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Mtrperroll'));
                }
            } else {
                // If the number already exists, show an error message
                $this->Flash->error(__('The {0} could not be saved. Data already exists, try again.', 'Mtrperroll'));
            }
        }

        $this->set(compact('mtrperroll'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Mtrperroll id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mtrperroll = $this->Mtrperrolls->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mtrperroll = $this->Mtrperrolls->patchEntity($mtrperroll, $this->request->getData());
            if ($this->Mtrperrolls->save($mtrperroll)) {
                $this->Flash->success(__('The {0} has been saved.', 'Mtrperroll'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Mtrperroll'));
        }
        $this->set(compact('mtrperroll'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Mtrperroll id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mtrperroll = $this->Mtrperrolls->get($id);
        if ($this->Mtrperrolls->delete($mtrperroll)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Mtrperroll'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Mtrperroll'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function deleteMultiple()
{
    if ($this->request->is('post')) {
        $selectedIds = $this->request->getData('selected_ids');
        if (!empty($selectedIds)) {
            // Find the selected records
            $records = $this->Mtrperrolls->find()->where(['id IN' => $selectedIds]);

            // Delete the selected records
            if ($this->Mtrperrolls->deleteMany($records)) {
                $this->Flash->success(__('The selected records have been deleted.'));
            } else {
                $this->Flash->error(__('There was an error deleting the records. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('No records selected.'));
        }
    }
    return $this->redirect(['action' => 'index']);
}

}
