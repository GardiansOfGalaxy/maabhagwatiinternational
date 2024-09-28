<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Designs Controller
 *
 * @property \App\Model\Table\DesignsTable $Designs
 * @method \App\Model\Entity\Design[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DesignsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $designs = $this->paginate($this->Designs);

        $this->set(compact('designs'));
    }

    /**
     * View method
     *
     * @param string|null $id Design id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
{
    $design = $this->Designs->get($id, [
        'contain' => ['DispatchStockSales' => ['Lengths','Designs'], 'Foldings' => ['Lengths','Designs','Mtrperrolls']],
    ]);

    $this->set(compact('design'));
}

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $design = $this->Designs->newEmptyEntity();
        if ($this->request->is('post')) {
            $design = $this->Designs->patchEntity($design, $this->request->getData());
            if ($this->Designs->save($design)) {
                $this->Flash->success(__('The {0} has been saved.', 'Design'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Design'));
        }
        $this->set(compact('design'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Design id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $design = $this->Designs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $design = $this->Designs->patchEntity($design, $this->request->getData());
            if ($this->Designs->save($design)) {
                $this->Flash->success(__('The {0} has been saved.', 'Design'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Design'));
        }
        $this->set(compact('design'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Design id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $design = $this->Designs->get($id);
        if ($this->Designs->delete($design)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Design'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Design'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
