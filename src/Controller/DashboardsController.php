<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

use Cake\Core\Configure;

class DashboardsController extends AppController
{
    public function view()
    {
        // Load the models
        $this->loadModel('Foldings');
        $this->loadModel('Lengths');
        $this->loadModel('Mtrperrolls');
        $this->loadModel('Designs');
        $this->loadModel('DispatchStockSales');

        // Fetch data from the Foldings and DispatchStockSales tables
        $foldings = $this->Foldings->find('all')->toArray();
        $DispatchStockSales = $this->DispatchStockSales->find('all')->toArray();

        // Initialize arrays for data
        $lengths = [];
        $designNames = [];
        $calculatedResults = [];
        $remainingRolls = [];

        // Initialize an associative array to keep track of the values already processed
        $processed = [];
        $dispatchData = [];

        // Organize dispatch data by design and length
        foreach ($DispatchStockSales as $DispatchStockSale) {
            $dispatchKey = $DispatchStockSale->design_id . '-' . $DispatchStockSale->length_id;
            if (!isset($dispatchData[$dispatchKey])) {
                $dispatchData[$dispatchKey] = 0;
            }
            $dispatchData[$dispatchKey] += (int)$DispatchStockSale->total_no_rolls;
        }

        // Loop through each folding record
        foreach ($foldings as $folding) {
            $lengthId = $folding->length_id;
            $mtrperrollId = $folding->mtrperroll_id;

            // Fetch Length and Mtrperroll values
            $length = $this->Lengths->find('all')
                ->where(['Lengths.id' => $lengthId])
                ->select('L')
                ->first();

            $mtrperroll = $this->Mtrperrolls->find('all')
                ->where(['Mtrperrolls.id' => $mtrperrollId])
                ->select('number')
                ->first();

            // Calculate result
            if ($length && $mtrperroll) {
                $lengthValue = (int)$length->L;
                $mtrperrollValue = (int)$mtrperroll->number;
                $ftotalRolls = (int)$folding->total_rolls;

                $Designsdata = $this->Designs->find('all')
                    ->where(['Designs.id' => $folding->design_id])
                    ->select('name')
                    ->first();

                // Check if this combination of design and length has already been processed
                $uniqueKey = $folding->design_id . '-' . $lengthValue . '-' . $mtrperrollValue;

                if (!isset($processed[$uniqueKey])) {
                    // Get corresponding dispatch rolls
                    $dispatchKey = $folding->design_id . '-' . $lengthId;
                    $dispatchTotalRolls = isset($dispatchData[$dispatchKey]) ? $dispatchData[$dispatchKey] : 0;

                    // Calculate remaining rolls and value
                    $remainingRoll = $ftotalRolls - $dispatchTotalRolls;
                    $calculatedValue = $mtrperrollValue * $lengthValue / 100 * $ftotalRolls;

                    // Store values if they haven't been added yet
                    $lengths[] = $lengthValue;
                    $designNames[] = $Designsdata['name'];
                    $calculatedResults[] = $calculatedValue;
                    $remainingRolls[] = $remainingRoll;

                    // Mark this combination as processed
                    $processed[$uniqueKey] = true;
                }
            }
        }

        // Chart options
        $chartOptions = [
            'responsive' => true,
            'maintainAspectRatio' => false
        ];

        // Load the Designs model
        $designs = $this->Designs->find('all')->toArray();
        $designsValue = [];
        foreach ($designs as $design) {
            $designsValue[] = $design->name;
        }

        // Set the variables to the view
        $this->set(compact('lengths', 'designNames', 'calculatedResults', 'chartOptions', 'designsValue', 'remainingRolls'));
    }
}
