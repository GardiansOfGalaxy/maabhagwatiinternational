<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * YarnStocks Controller
 *
 * @property \App\Model\Table\YarnStocksTable $YarnStocks
 * @method \App\Model\Entity\YarnStock[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class YarnStocksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Deniers', 'Agents'],
        ];
        $yarnStocks = $this->paginate($this->YarnStocks);

        $this->set(compact('yarnStocks'));
    }

    /**
     * View method
     *
     * @param string|null $id Yarn Stock id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $yarnStock = $this->YarnStocks->get($id, [
            'contain' => ['Deniers', 'Agents'],
        ]);

        $this->set(compact('yarnStock'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $yarnStock = $this->YarnStocks->newEmptyEntity();
        if ($this->request->is('post')) {
            $yarnStock = $this->YarnStocks->patchEntity($yarnStock, $this->request->getData());
            if ($this->YarnStocks->save($yarnStock)) {
                $this->Flash->success(__('The {0} has been saved.', 'Yarn Stock'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Yarn Stock'));
        }
        $deniers = $this->YarnStocks->Deniers->find('list', ['valueField'=>'den', 'limit' => 200]);
        $agents = $this->YarnStocks->Agents->find('list', ['keyValue'=>'name','limit' => 200]);
        $this->set(compact('yarnStock', 'deniers', 'agents'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Yarn Stock id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $yarnStock = $this->YarnStocks->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $yarnStock = $this->YarnStocks->patchEntity($yarnStock, $this->request->getData());
            if ($this->YarnStocks->save($yarnStock)) {
                $this->Flash->success(__('The {0} has been saved.', 'Yarn Stock'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Yarn Stock'));
        }
        $deniers = $this->YarnStocks->Deniers->find('list', ['valueField'=>'den', 'limit' => 200]);
        $agents = $this->YarnStocks->Agents->find('list', ['keyValue'=>'name','limit' => 200]);
        $this->set(compact('yarnStock', 'deniers', 'agents'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Yarn Stock id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $yarnStock = $this->YarnStocks->get($id);
        if ($this->YarnStocks->delete($yarnStock)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Yarn Stock'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Yarn Stock'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
