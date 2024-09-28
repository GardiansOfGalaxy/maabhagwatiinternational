<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * GreyRemainings Controller
 *
 * @method \App\Model\Entity\GreyRemaining[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GreyRemainingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $greyRemainings = $this->paginate($this->GreyRemainings);

        $this->set(compact('greyRemainings'));
    }

    /**
     * View method
     *
     * @param string|null $id Grey Remaining id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $greyRemaining = $this->GreyRemainings->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('greyRemaining'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $greyRemaining = $this->GreyRemainings->newEmptyEntity();
        if ($this->request->is('post')) {
            $greyRemaining = $this->GreyRemainings->patchEntity($greyRemaining, $this->request->getData());
            if ($this->GreyRemainings->save($greyRemaining)) {
                $this->Flash->success(__('The grey remaining has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grey remaining could not be saved. Please, try again.'));
        }
        $this->set(compact('greyRemaining'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Grey Remaining id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $greyRemaining = $this->GreyRemainings->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $greyRemaining = $this->GreyRemainings->patchEntity($greyRemaining, $this->request->getData());
            if ($this->GreyRemainings->save($greyRemaining)) {
                $this->Flash->success(__('The grey remaining has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grey remaining could not be saved. Please, try again.'));
        }
        $this->set(compact('greyRemaining'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Grey Remaining id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $greyRemaining = $this->GreyRemainings->get($id);
        if ($this->GreyRemainings->delete($greyRemaining)) {
            $this->Flash->success(__('The grey remaining has been deleted.'));
        } else {
            $this->Flash->error(__('The grey remaining could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
