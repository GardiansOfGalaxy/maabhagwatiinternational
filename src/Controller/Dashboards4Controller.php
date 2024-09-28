<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;

class Dashboards4Controller extends AppController
{
    public function index() {}
    public function view()
    {
        $this->loadModel('Widths');
        $this->loadModel('Picks');
        $this->loadModel('Deniers');

        // Fetch widths with id and name
        $widths = $this->Widths->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        // Fetch all picks
        $picks = $this->Picks->find('list', ['keyField' => 'id', 'valueField' => 'name', 'limit' => 200])->toArray();

        // Fetch all deniers
        $deniers = $this->Deniers->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

        // Get selected values from query
        $selectedWidth = $this->request->getQuery('width_id');
        $selectedPick = $this->request->getQuery('pick_id');
        $selectedDenier = $this->request->getQuery('denier_id');
        // Set variables for the view
        $this->set(compact('widths', 'picks', 'deniers', 'selectedWidth', 'selectedPick', 'selectedDenier'));
    }

    // Add this action to your Dashboards4Controller
    public function getPicksAndDeniersByWidth($width_id = null)
    {
        $this->loadModel('Widths');
        $this->loadModel('Picks');
        $this->loadModel('Deniers');
        $this->autoRender = false;

        // Ensure $width_id is numeric
        if (!is_numeric($width_id)) {
            $this->response = $this->response->withStatus(400)
                ->withStringBody(json_encode(['error' => 'Invalid width_id']));
            return $this->response;
        }


        // Find the pick IDs associated with the width ID
        $pickIdsData = $this->Widths->find('all')
            ->where(['Widths.id' => $width_id])
            ->select('pick_id')
            ->toArray();

        $pickIds = array_column($pickIdsData, 'pick_id');

        // If there are no pick IDs, return empty options
        if (empty($pickIds)) {
            $this->response = $this->response->withType('application/json')
                ->withStringBody(json_encode(['picks' => [], 'deniers' => []]));
            return $this->response;
        }

        // Fetch picks and deniers based on the pick IDs
        $picks = $this->Picks->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
            ->where(['Picks.id IN' => $pickIds])
            ->toArray();

        // Fetch deniers based on the picks
        $denierIds = $this->Widths->find('all')
            ->where(['Widths.id' => $width_id])
            ->select('denier_id')
            ->toArray();

        $denierIds = array_column($denierIds, 'denier_id');

        $deniers = $this->Deniers->find('list', [
            'keyField' => 'id',
            'valueField' => 'den'
        ])
            ->where(['Deniers.id IN' => $denierIds])
            ->toArray();


        // Send both picks and deniers as JSON response
        $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode(['picks' => $picks, 'deniers' => $deniers]));
        return $this->response;
    }

    public function calculateReport($width_id = null, $pick_id = null, $denier_id = null)
    {
        $this->loadModel('Widths');
        $this->loadModel('Picks');
        $this->loadModel('Deniers');
        $this->loadModel('Waterjets');
        $this->loadModel('YarnStocks');
        // var_dump($width_id, $pick_id, $denier_id);
        // exit;
        $this->autoRender = false;
        // debug($width_id);die();
        // Log received parameters
        error_log('Width ID: ' . $width_id);
        error_log('Pick ID: ' . $pick_id);
        error_log('Denier ID: ' . $denier_id);

        // Ensure all parameters are numeric
        if (!is_numeric($width_id) || !is_numeric($pick_id) || !is_numeric($denier_id)) {
            $this->response = $this->response->withStatus(400)
                ->withStringBody(json_encode(['error' => 'Invalid parameters']));
            return $this->response;
        }

        // Fetch width, pick, and denier data
        try {
            $width = $this->Widths->get($width_id);
            $pick = $this->Picks->get($pick_id);
            $denier = $this->Deniers->get($denier_id);
            // $width = 1;
            // $pick =1;
            // $denier = 1;
            // $width_id = 1;
            // $pick_id = 1;
            // $denier_id = 1;
            // $WidthsData = $this->Widths->find('all')
            //     ->where(['Widths.id' => $width_id])
            //     ->select('name')
            //     ->toArray();
            $WidthsData = $this->Widths->find('list', [
                'valueField' => 'name'
            ])
                ->where(['Widths.id IN' => $width_id])
                ->toArray();
            $pickIdsData = $this->Widths->find('all')
                ->where(['Widths.id' => $width_id])
                ->select('pick_id')
                ->toArray();

            $pickIds = array_column($pickIdsData, 'pick_id');

            // If there are no pick IDs, return empty options
            if (empty($pickIds)) {
                $this->response = $this->response->withType('application/json')
                    ->withStringBody(json_encode(['picks' => [], 'deniers' => []]));
                return $this->response;
            }

            // Fetch picks and deniers based on the pick IDs
            $picks = $this->Picks->find('list', [
                'valueField' => 'name'
            ])
                ->where(['Picks.id IN' => $pickIds])
                ->toArray();

            // Fetch deniers based on the picks
            $denierIds = $this->Widths->find('all')
                ->where(['Widths.id' => $width_id])
                ->select('denier_id')
                ->toArray();

            $denierIds = array_column($denierIds, 'denier_id');

            $deniers = $this->Deniers->find('list', [
                'valueField' => 'den'
            ])
                ->where(['Deniers.id IN' => $denierIds])
                ->toArray();
            // Ensure that `value` field exists in your tables
            $widthValue = (float)array_values($WidthsData)[0];

            $pickValue = (float)array_values($picks)[0];

            $deniersFloat = (float)array_values($deniers)[0];

            $result = (105 * $widthValue * $pickValue * $deniersFloat)/ 900000 ;
            $result = $result/ 1000;
            // Fetch the quantity from the Waterjets table
            $waterjet = $this->Waterjets->find('all')
                ->where(['Waterjets.pick_id IN' => $pickIds])
                ->select('quantity')
                ->first();
            //    $waterjet2= (float)($waterjet);
            // Check if the quantity exists
            $quantity = $waterjet ? $waterjet['quantity'] : 0;

            $startDate = $this->request->getQuery('start_date');
            $endDate = $this->request->getQuery('end_date');
            //         // Subtract the quantity from the result
            $finalResult1 = $result * $quantity;
            $yarnStocksTotalKg = $this->YarnStocks->find('all')
                ->where([
                    // 'YarnStocks.pick_id' => $pickIds,
                    'YarnStocks.date >=' => $startDate,
                    'YarnStocks.date <=' => $endDate
                ])
                ->select(['totalKg' => 'SUM(YarnStocks.kg)'])
                ->first();

            $kgFromYarnStocks = $yarnStocksTotalKg ? $yarnStocksTotalKg->totalKg : 0;
            if ($quantity == 0) {
                // Send a response that will trigger an alert
                echo json_encode(['status' => 'error', 'message' => 'Quantity is not available for pick']);
                exit;  // Make sure to exit to stop further processing
            }
            
            // // Subtract the kg from the final result
            $finalResult = $finalResult1 - $kgFromYarnStocks;
            // Return result as JSON
            try {
                // Just return a simple static JSON response for testing
                $this->response = $this->response->withType('application/json')
                    ->withStringBody(json_encode(['result' => (float)$finalResult]));
                return $this->response;
            } catch (\Exception $e) {
                // Log exception and return a JSON error response
                error_log('Exception: ' . $e->getMessage());
                $this->response = $this->response->withStatus(500)
                    ->withType('application/json')
                    ->withStringBody(json_encode(['error' => 'Server error']));
                return $this->response;
            }
        } catch (\Exception $e) {
            // Log exception
            $jsonResponse = json_encode(['result' => $result]);
            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log('JSON encoding error: ' . json_last_error_msg());
            }
            $this->response = $this->response->withType('application/json')
                ->withStringBody($jsonResponse);
        }
    }
}
