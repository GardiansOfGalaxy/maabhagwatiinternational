<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Lengths Controller
 *
 * @method \App\Model\Entity\Length[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LengthsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $lengths = $this->paginate($this->Lengths);

        $this->set(compact('lengths'));
    }

    /**
     * View method
     *
     * @param string|null $id Length id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $length = $this->Lengths->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('length'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $length = $this->Lengths->newEmptyEntity();
        if ($this->request->is('post')) {
            $length = $this->Lengths->patchEntity($length, $this->request->getData());
            if ($this->Lengths->save($length)) {
                $this->Flash->success(__('The {0} has been saved.', 'Length'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Length'));
        }
        $this->set(compact('length'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Length id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $length = $this->Lengths->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $length = $this->Lengths->patchEntity($length, $this->request->getData());
            if ($this->Lengths->save($length)) {
                $this->Flash->success(__('The {0} has been saved.', 'Length'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Length'));
        }
        $this->set(compact('length'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Length id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $length = $this->Lengths->get($id);
        if ($this->Lengths->delete($length)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Length'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Length'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
