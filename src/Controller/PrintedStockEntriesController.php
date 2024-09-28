<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PrintedStockEntries Controller
 *
 * @property \App\Model\Table\PrintedStockEntriesTable $PrintedStockEntries
 * @method \App\Model\Entity\PrintedStockEntry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PrintedStockEntriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Picks'=> ['Deniers'],'Designs'],
        ];
        $printedStockEntries = $this->paginate($this->PrintedStockEntries);

        $this->set(compact('printedStockEntries'));
    }

    /**
     * View method
     *
     * @param string|null $id Printed Stock Entry id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $printedStockEntry = $this->PrintedStockEntries->get($id, [
            'contain' => ['Picks'=> ['Deniers'],'Designs'],
        ]);

        $this->set(compact('printedStockEntry'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $printedStockEntry = $this->PrintedStockEntries->newEmptyEntity();
        $session = $this->request->getSession();

        $lastWaterjet = $this->PrintedStockEntries->find()
            ->select(['date'])
            ->order(['date' => 'DESC'])
            ->first();

        // Get the date from the last entry, or default to the previous day
        $lastSubmittedDate = !empty($lastWaterjet) ? $lastWaterjet->date->format('Y-m-d') : date('Y-m-d', strtotime('-1 day'));

        if ($this->request->is('post')) {
            $printedStockEntry = $this->PrintedStockEntries->patchEntity($printedStockEntry, $this->request->getData());
            if ($this->PrintedStockEntries->save($printedStockEntry)) {
                $this->Flash->success(__('The {0} has been saved.', 'Printed Stock Entry'));
                $session->write('lastSubmittedDate', $this->request->getData('date'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Printed Stock Entry'));
        }
        $picks = $this->PrintedStockEntries->Picks->find()
        ->select(['Picks.id', 'Picks.name', 'Deniers.den'])
        ->contain(['Deniers'])
        ->all()
        ->combine('id', function ($pick) {
            return $pick->name . ' (' . $pick->denier->den . ')';
        })
        ->toArray();
        $designs = $this->PrintedStockEntries->Designs->find('list', ['keyValue'=>'name', 'limit' => 200]);
        $deniers = [];
        $totalquantity = [];
        $this->set(compact('printedStockEntry','picks','designs','deniers','lastSubmittedDate','totalquantity'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Printed Stock Entry id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $printedStockEntry = $this->PrintedStockEntries->get($id, [
            'contain' => ['Picks', 'Designs'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $printedStockEntry = $this->PrintedStockEntries->patchEntity($printedStockEntry, $this->request->getData());
            if ($this->PrintedStockEntries->save($printedStockEntry)) {
                $this->Flash->success(__('The {0} has been saved.', 'Printed Stock Entry'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Printed Stock Entry'));
        }

        $picks = $this->PrintedStockEntries->Picks->find('list', ['keyValue' => 'name', 'limit' => 200]);
        $designs = $this->PrintedStockEntries->Designs->find('list', ['keyValue' => 'name', 'limit' => 200]);

        $denier = null;
        if ($printedStockEntry->pick_id) {
            $pick = $this->PrintedStockEntries->Picks->get($printedStockEntry->pick_id, [
                'contain' => ['Deniers']
            ]);

            if ($pick && $pick->denier) {
                $denier = $pick->denier->den;
            }
        }

        $this->set(compact('printedStockEntry', 'picks', 'designs', 'denier'));
    }

    public function getDenier($pickId = null)
    {
        $this->autoRender = false;
        $this->response = $this->response->withType('application/json');

        $denier = null;

        if ($pickId) {
            $pick = $this->PrintedStockEntries->Picks->get($pickId, [
                'contain' => ['Deniers']
            ]);

            if ($pick && $pick->denier) {
                $denier = $pick->denier->den;
            }
        }

        return $this->response->withStringBody(json_encode(['denier' => $denier]));
    }
    public function getTotalQuantity($pickId = null)
    {
        $this->autoRender = false;
        $this->response = $this->response->withType('application/json');

        $totalQuantity = 0;

        if ($pickId) {
            // Assuming the Waterjets table is loaded and has a 'pick_id' field
            $totalQuantity = $this->loadModel('Waterjets')->find()
                ->where(['pick_id' => $pickId])
                ->sumOf('quantity'); // Adjust 'quantity' if the column name is different
        }

        return $this->response->withStringBody(json_encode(['totalQuantity' => $totalQuantity]));
    }

    /**
     * Delete method
     *
     * @param string|null $id Printed Stock Entry id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $printedStockEntry = $this->PrintedStockEntries->get($id);
        if ($this->PrintedStockEntries->delete($printedStockEntry)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Printed Stock Entry'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Printed Stock Entry'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
