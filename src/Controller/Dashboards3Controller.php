<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

use Cake\Core\Configure;

/**
 * Addstudents Controller
 *
 * // * @property \App\Model\Table\AddstudentsTable $Addstudents
 * // * @method \App\Model\Entity\Addstudent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class Dashboards3Controller extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

     public function view()
     {
         $this->loadModel('Waterjets');

         // Fetch the date range from the request (optional)
         $startDate = $this->request->getQuery('startDate');
         $endDate = $this->request->getQuery('endDate');

         $conditions = [];
         if ($startDate && $endDate) {
             $conditions = [
                 'date >=' => $startDate,
                 'date <=' => $endDate
             ];
         }

         $waterjets = $this->Waterjets->find('all', [
             'conditions' => $conditions,
             'contain' => ['Picks'] // Assuming Waterjets has a belongsTo association with Picks
         ])->toArray();

         // Prepare data for the table
         $tableData = [];
         foreach ($waterjets as $waterjet) {
             $tableData[] = [
                 'date' => $waterjet->date->format('d/M'),
                 'pick' => $waterjet->pick->name,
                 'quantity' => $waterjet->quantity . ' Mtr'
             ];
         }

         $this->set(compact('tableData'));
     }


}
