<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DispatchStockSales Controller
 *
 * @property \App\Model\Table\DispatchStockSalesTable $DispatchStockSales
 * @method \App\Model\Entity\DispatchStockSale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DispatchStockSalesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Lengths', 'Designs'],
        ];
        $dispatchStockSales = $this->paginate($this->DispatchStockSales);

        $this->set(compact('dispatchStockSales'));
    }

    /**
     * View method
     *
     * @param string|null $id Dispatch Stock Sale id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dispatchStockSale = $this->DispatchStockSales->get($id, [
            'contain' => ['Lengths', 'Designs'],
        ]);

        $this->set(compact('dispatchStockSale'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dispatchStockSale = $this->DispatchStockSales->newEmptyEntity();
        $session = $this->request->getSession();

        // Retrieve the last submitted date from the database
        $lastWaterjet = $this->DispatchStockSales->find()
            ->select(['date'])
            ->order(['date' => 'DESC'])
            ->first();

        // Get the date from the last entry, or default to the previous day
        $lastSubmittedDate = !empty($lastWaterjet) ? $lastWaterjet->date->format('Y-m-d') : date('Y-m-d', strtotime('-1 day'));

        if ($this->request->is('post')) {
            $dispatchStockSale = $this->DispatchStockSales->patchEntity($dispatchStockSale, $this->request->getData());
            if ($this->DispatchStockSales->save($dispatchStockSale)) {
                $this->Flash->success(__('The {0} has been saved.', 'Dispatch Stock Sale'));
                $session->write('lastSubmittedDate', $this->request->getData('date'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Dispatch Stock Sale'));
        }
        $lengths = $this->DispatchStockSales->Lengths->find('list', ['valueField'=>'L','limit' => 200]);
        $designs = $this->DispatchStockSales->Designs->find('list', ['keyValue'=>'name', 'limit' => 200]);
        $this->set(compact('dispatchStockSale', 'lengths', 'designs','lastSubmittedDate'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Dispatch Stock Sale id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dispatchStockSale = $this->DispatchStockSales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dispatchStockSale = $this->DispatchStockSales->patchEntity($dispatchStockSale, $this->request->getData());
            if ($this->DispatchStockSales->save($dispatchStockSale)) {
                $this->Flash->success(__('The {0} has been saved.', 'Dispatch Stock Sale'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Dispatch Stock Sale'));
        }
        $lengths = $this->DispatchStockSales->Lengths->find('list', ['valueField'=>'L','limit' => 200]);
        $designs = $this->DispatchStockSales->Designs->find('list', ['keyValue'=>'name','limit' => 200]);
        $this->set(compact('dispatchStockSale', 'lengths', 'designs'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Dispatch Stock Sale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dispatchStockSale = $this->DispatchStockSales->get($id);
        if ($this->DispatchStockSales->delete($dispatchStockSale)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Dispatch Stock Sale'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Dispatch Stock Sale'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function bulkDelete()
{
    $this->request->allowMethod(['post', 'delete']);
    $ids = $this->request->getData('ids');

    if (!empty($ids)) {
        $entities = $this->DispatchStockSales->find('all', [
            'conditions' => ['DispatchStockSales.id IN' => $ids]
        ])->toArray();

        if ($this->DispatchStockSales->deleteMany($entities)) {
            $this->Flash->success(__('The selected records have been deleted.'));
        } else {
            $this->Flash->error(__('Some records could not be deleted. Please try again.'));
        }
    } else {
        $this->Flash->error(__('No records selected.'));
    }

    return $this->redirect(['action' => 'index']);
}

}
