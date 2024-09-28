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
class Dashboards2Controller extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

     public function view()
{
    $this->loadModel('Waterjets');
    $this->loadModel('DispatchToOwnFactories');
    $this->loadModel('Picks');
    $this->loadModel('PrintedStockEntries'); // Assuming this is the correct model name

    // Fetch the date range from the request
    $startDate = $this->request->getQuery('startDate');
    $endDate = $this->request->getQuery('endDate');

    // Initialize arrays
    $waterjets = [];
    $dispatches = [];
    $printedStocks = [];
    $calculatedData = [];

    // If only endDate is provided, find the earliest date in your data and use it as startDate
    if (!$startDate && $endDate) {
        // Fetch the earliest date from the Waterjets table
        $earliestDate = $this->Waterjets->find()
            ->select(['date'])
            ->order(['date' => 'ASC'])
            ->first();
        
        // Check if an earliest date was found
        if ($earliestDate) {
            $startDate = $earliestDate->date;
        }
    }

    if ($startDate && $endDate) {
        $waterjets = $this->Waterjets->find('all', [
            'conditions' => [
                'date >=' => $startDate,
                'date <=' => $endDate
            ],
            'contain' => ['Picks'] // Assuming Waterjets has a belongsTo association with Picks
        ])->toArray();

        $dispatches = $this->DispatchToOwnFactories->find('all', [
            'conditions' => [
                'date >=' => $startDate,
                'date <=' => $endDate
            ],
            'contain' => ['Picks'] // Assuming DispatchToOwnFactories has a belongsTo association with Picks
        ])->toArray();

        $printedStocks = $this->PrintedStockEntries->find('all', [
            'conditions' => [
                'date >=' => $startDate,
                'date <=' => $endDate
            ],
            'contain' => ['Picks'] // Assuming PrintedStockEntries has a belongsTo association with Picks
        ])->toArray();

        // Group waterjets data by pick_id
        $groupedWaterjets = [];
        foreach ($waterjets as $waterjet) {
            $pickId = $waterjet->pick_id;
            if (!isset($groupedWaterjets[$pickId])) {
                $groupedWaterjets[$pickId] = [
                    'pick' => $waterjet->pick->pick_value,
                    'quantity' => 0
                ];
            }
            $groupedWaterjets[$pickId]['quantity'] += $waterjet->quantity;
        }

        // Group dispatches data by pick_id
        $groupedDispatches = [];
        foreach ($dispatches as $dispatch) {
            $pickId = $dispatch->pick_id;
            if (!isset($groupedDispatches[$pickId])) {
                $groupedDispatches[$pickId] = [
                    'pick' => $dispatch->pick->pick_value,
                    'quantity' => 0
                ];
            }
            $groupedDispatches[$pickId]['quantity'] += $dispatch->quantity;
        }

        // Group printed stocks data by pick_id
        $groupedPrintedStocks = [];
        foreach ($printedStocks as $printedStock) {
            $pickId = $printedStock->pick_id;
            if (!isset($groupedPrintedStocks[$pickId])) {
                $groupedPrintedStocks[$pickId] = [
                    'pick' => $printedStock->pick->pick_value,
                    'quantity' => 0
                ];
            }
            $groupedPrintedStocks[$pickId]['quantity'] += $printedStock->quantity;
        }

        // Calculate remaining quantities by subtracting dispatch and printed stock quantities from waterjet quantities
        foreach ($groupedWaterjets as $pickId => $data) {
            $dispatchQuantity = isset($groupedDispatches[$pickId]) ? $groupedDispatches[$pickId]['quantity'] : 0;
            $printedStockQuantity = isset($groupedPrintedStocks[$pickId]) ? $groupedPrintedStocks[$pickId]['quantity'] : 0;
            $remainingQuantity = $data['quantity'] - $dispatchQuantity - $printedStockQuantity;

            $calculatedData[] = [
                'pick' => $waterjet->pick->name, // Use the correct pick value here
                'data' => $remainingQuantity . ' MTR'
            ];
        }
    }

    $this->set(compact('calculatedData'));
}


}
