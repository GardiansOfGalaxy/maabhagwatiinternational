<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Waterjets Controller
 *
 * @method \App\Model\Entity\Waterjet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WaterjetsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Picks' => ['Deniers']],
        ];
        $waterjets = $this->paginate($this->Waterjets);

        $this->set(compact('waterjets'));
    }

    /**
     * View method
     *
     * @param string|null $id Waterjet id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $waterjet = $this->Waterjets->get($id, [
            'contain' => ['Picks'=> ['Deniers']],
        ]);

        $this->set(compact('waterjet'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $waterjet = $this->Waterjets->newEmptyEntity();
        $session = $this->request->getSession();

        // Retrieve the last submitted date from the database
        $lastWaterjet = $this->Waterjets->find()
            ->select(['date'])
            ->order(['date' => 'DESC'])
            ->first();

        // Get the date from the last entry, or default to the previous day
        $lastSubmittedDate = !empty($lastWaterjet) ? $lastWaterjet->date->format('Y-m-d') : date('Y-m-d', strtotime('-1 day'));

        if ($this->request->is('post')) {
            $waterjet = $this->Waterjets->patchEntity($waterjet, $this->request->getData());
            if ($this->Waterjets->save($waterjet)) {
                $this->Flash->success(__('The {0} has been saved.', 'Waterjet'));

                // Save the current date as the last submitted date in the session
                $session->write('lastSubmittedDate', $this->request->getData('date'));

                return $this->redirect(['action' => 'add']); // Redirect to the same add page
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Waterjet'));
        }

        $picks = $this->Waterjets->Picks->find()
        ->select(['Picks.id', 'Picks.name', 'Deniers.den'])
        ->contain(['Deniers'])
        ->all()
        ->combine('id', function ($pick) {
            return $pick->name . ' (' . $pick->denier->den . ')';
        })
        ->toArray();
         $this->set(compact('waterjet', 'picks', 'lastSubmittedDate'));
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
     * @param string|null $id Waterjet id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $waterjet = $this->Waterjets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $waterjet = $this->Waterjets->patchEntity($waterjet, $this->request->getData());
            if ($this->Waterjets->save($waterjet)) {
                $this->Flash->success(__('The {0} has been saved.', 'Waterjet'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Waterjet'));
        }
        $picks = $this->Waterjets->Picks->find('list', ['keyValue'=>'name', 'limit' => 200]);
        $denier = null;
    if ($waterjet->pick_id) {
        $pick = $this->Waterjets->Picks->get($waterjet->pick_id, [
            'contain' => ['Deniers']
        ]);
        if ($pick && $pick->denier) {
            $denier = $pick->denier->den;
        }
    }
        $this->set(compact('waterjet','picks','denier'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Waterjet id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $waterjet = $this->Waterjets->get($id);
        if ($this->Waterjets->delete($waterjet)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Waterjet'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Waterjet'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
