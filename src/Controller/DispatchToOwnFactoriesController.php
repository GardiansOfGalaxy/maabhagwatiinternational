<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DispatchToOwnFactories Controller
 *
 * @property \App\Model\Table\DispatchToOwnFactoriesTable $DispatchToOwnFactories
 * @method \App\Model\Entity\DispatchToOwnFactory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DispatchToOwnFactoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Picks'=> ['Deniers']],
        ];
        $dispatchToOwnFactories = $this->paginate($this->DispatchToOwnFactories);

        $this->set(compact('dispatchToOwnFactories'));
    }

    /**
     * View method
     *
     * @param string|null $id Dispatch To Own Factory id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dispatchToOwnFactory = $this->DispatchToOwnFactories->get($id, [
            'contain' => ['Picks'=> ['Deniers']],
        ]);

        $this->set(compact('dispatchToOwnFactory'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dispatchToOwnFactory = $this->DispatchToOwnFactories->newEmptyEntity();
        $session = $this->request->getSession();

        // Retrieve the last submitted date from the database
        $lastWaterjet = $this->DispatchToOwnFactories->find()
            ->select(['date'])
            ->order(['date' => 'DESC'])
            ->first();

        // Get the date from the last entry, or default to the previous day
        $lastSubmittedDate = !empty($lastWaterjet) ? $lastWaterjet->date->format('Y-m-d') : date('Y-m-d', strtotime('-1 day'));

        if ($this->request->is('post')) {
            $dispatchToOwnFactory = $this->DispatchToOwnFactories->patchEntity($dispatchToOwnFactory, $this->request->getData());
            if ($this->DispatchToOwnFactories->save($dispatchToOwnFactory)) {
                $this->Flash->success(__('The {0} has been saved.', 'Dispatch To Own Factory'));
                $session->write('lastSubmittedDate', $this->request->getData('date'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Dispatch To Own Factory'));
        }
        $picks = $this->DispatchToOwnFactories->Picks->find()
        ->select(['Picks.id', 'Picks.name', 'Deniers.den'])
        ->contain(['Deniers'])
        ->all()
        ->combine('id', function ($pick) {
            return $pick->name . ' (' . $pick->denier->den . ')';
        })
        ->toArray();        $this->set(compact('dispatchToOwnFactory', 'picks','lastSubmittedDate'));
    }

    public function getDeniersByPick($pickId = null)
    {
        $this->autoRender = false; // Disable view rendering

        if ($this->request->is('ajax')) {
            // Log the incoming pickId for debugging
            $this->log("Received pickId: " . $pickId, 'debug');

            $pick = $this->Waterjets->Picks->get($pickId);
            $this->log("Pick data: " . print_r($pick, true), 'debug');

            if (!empty($pick->denier_id)) {
                $deniers = $this->Waterjets->Picks->Deniers->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'den',
                    'conditions' => ['Deniers.id' => $pick->denier_id]
                ])->toArray();
                $this->log("Deniers fetched: " . print_r($deniers, true), 'debug');
            } else {
                $deniers = [];
                $this->log("No denier_id found for pickId: " . $pickId, 'debug');
            }

            echo json_encode($deniers);
        }
    }
    /**
     * Edit method
     *
     * @param string|null $id Dispatch To Own Factory id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dispatchToOwnFactory = $this->DispatchToOwnFactories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dispatchToOwnFactory = $this->DispatchToOwnFactories->patchEntity($dispatchToOwnFactory, $this->request->getData());
            if ($this->DispatchToOwnFactories->save($dispatchToOwnFactory)) {
                $this->Flash->success(__('The {0} has been saved.', 'Dispatch To Own Factory'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Dispatch To Own Factory'));
        }
        $picks = $this->DispatchToOwnFactories->Picks->find('list', ['limit' => 200]);
        $this->set(compact('dispatchToOwnFactory', 'picks'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Dispatch To Own Factory id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dispatchToOwnFactory = $this->DispatchToOwnFactories->get($id);
        if ($this->DispatchToOwnFactories->delete($dispatchToOwnFactory)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Dispatch To Own Factory'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Dispatch To Own Factory'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
