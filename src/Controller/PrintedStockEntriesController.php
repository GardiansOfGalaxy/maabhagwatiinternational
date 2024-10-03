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
            // Load Waterjets table and get total quantity
            $totalQuantitywaterjet = $this->loadModel('Waterjets')->find()
            ->where(['pick_id' => $pickId])
            ->sumOf('quantity');

            // Fetch the corresponding denier for the pick
            // $denier = $this->loadModel('Waterjets')->find()
            //     ->select(['denier'])
            //     ->where(['pick_id' => $pickId])
            //     ->first();

            // Load PrintedStockEntries table and get total quantity for matching pick and denier
            $printedStockTotal = $this->loadModel('PrintedStockEntries')->find()
                ->where(['pick_id' => $pickId])
                ->sumOf('quantity'); // Adjust 'quantity' if needed

            // // Subtract PrintedStockEntry total from Waterjet total
            $totalQuantity = $totalQuantitywaterjet - $printedStockTotal;
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
    public function bulkDelete()
    {
        if ($this->request->is(['post'])) {
            // Retrieve selected IDs from the form
            $selectedIds = $this->request->getData('selected_ids');

            if (!empty($selectedIds)) {
                // Attempt to delete the selected entries
                $this->PrintedStockEntries->deleteAll(['id IN' => $selectedIds]);

                // Set a success flash message
                $this->Flash->success(__('Selected entries have been deleted.'));
            } else {
                // Set an error flash message if no entries were selected
                $this->Flash->error(__('Please select at least one entry to delete.'));
            }
        }

        // Redirect back to the index (or wherever you want to redirect)
        return $this->redirect(['action' => 'index']);
    }

}
