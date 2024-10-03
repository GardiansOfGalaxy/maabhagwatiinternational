<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Widths Controller
 *
 * @property \App\Model\Table\WidthsTable $Widths
 * @method \App\Model\Entity\Width[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WidthsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Picks', 'Deniers'],
        ];
        $widths = $this->paginate($this->Widths);

        $this->set(compact('widths'));
    }

    /**
     * View method
     *
     * @param string|null $id Width id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $width = $this->Widths->get($id, [
            'contain' => ['Picks', 'Deniers'],
        ]);

        $this->set(compact('width'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $width = $this->Widths->newEmptyEntity();
        if ($this->request->is('post')) {
            $width = $this->Widths->patchEntity($width, $this->request->getData());
            if ($this->Widths->save($width)) {
                $this->Flash->success(__('The width has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The width could not be saved. Please, try again.'));
        }
        $picks = $this->Widths->Picks->find('list', ['keyValue'=>'name','limit' => 200]);
        $deniers = $this->Widths->Deniers->find('list', ['valueField'=>'den','limit' => 200]);
        $this->set(compact('width', 'picks', 'deniers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Width id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $width = $this->Widths->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $width = $this->Widths->patchEntity($width, $this->request->getData());
            if ($this->Widths->save($width)) {
                $this->Flash->success(__('The width has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The width could not be saved. Please, try again.'));
        }
        $picks = $this->Widths->Picks->find('list', ['keyValue'=>'name','limit' => 200]);
        $deniers = $this->Widths->Deniers->find('list', ['valueField'=>'den','limit' => 200]);
        $this->set(compact('width', 'picks', 'deniers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Width id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $width = $this->Widths->get($id);
        if ($this->Widths->delete($width)) {
            $this->Flash->success(__('The width has been deleted.'));
        } else {
            $this->Flash->error(__('The width could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function deleteMultiple()
    {
        $this->request->allowMethod(['post', 'delete']);
        $ids = $this->request->getData('ids');
        if (!empty($ids)) {
            $this->Widths->deleteAll(['id IN' => $ids]);
            $this->Flash->success(__('The selected widths have been deleted.'));
        } else {
            $this->Flash->error(__('No widths selected.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
