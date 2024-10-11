<?php


namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){

        $products = ProductModel::paginate(20);


       return view('product', compact('products'));
    }

    public function searchByPrice(Request $request) {
        $query = $request->input("product-search");

        if (empty($query) || !is_numeric($query)) {
            return response()->json([]);
        }

        $query = (float)$query;


        $products = ProductModel::orderByRaw('CAST(REPLACE(price, "$", "") AS DECIMAL(5, 3))')->get();


        $productsArray = $products->toArray();


        $searchResult = $this->binarySearchByPrice($productsArray, $query);

        return response()->json($searchResult);
    }




    private function binarySearchByPrice(array $products, float $targetPrice) {
        $low = 0;
        $high = count($products) - 1;
        $results = [];

        // Check if targetPrice kung naay bay point
        if (floor($targetPrice) == $targetPrice) {

            $lowerBound = floor($targetPrice);
            $upperBound = $lowerBound + 1;
        } else {
            // Exact decimal input, set lower and upper bound to target price
            $lowerBound = $targetPrice;
            $upperBound = $targetPrice;
        }

        while ($low <= $high) {
            $mid = (int)(($low + $high) / 2);

            $productPrice = (float)str_replace('$', '', $products[$mid]['price']);

            if ($targetPrice == $lowerBound && $upperBound == $lowerBound) {

                $productPrice = round($productPrice, 2);
                if ($productPrice == $targetPrice) {
                    $results[] = $products[$mid];

                    $left = $mid - 1;
                    while ($left >= 0) {
                        $leftProductPrice = round((float)str_replace('$', '', $products[$left]['price']), 2);
                        if ($leftProductPrice == $targetPrice) {
                            $results[] = $products[$left];
                            $left--;
                        } else {
                            break;
                        }
                    }



               $right = $mid + 1;
               while ($right < count($products)) {
                   $rightProductPrice = round((float)str_replace('$', '', $products[$right]['price']), 2);
                   if ($rightProductPrice == $targetPrice) {
                       $results[] = $products[$right];
                       $right++;
                   } else {
                       break;
                   }
               }
               break;
                } elseif ($productPrice < $targetPrice) {
                    $low = $mid + 1;
                } else {
                    $high = $mid - 1;
                }


 //******************************************************************************************************************* */
            } else {
                // Whole number input: match products in the range up and low bound !!!!!!!!!!!!!!!!!!!!
                if ($productPrice >= $lowerBound && $productPrice < $upperBound) {
                    $results[] = $products[$mid];
                    //left search
                    $left = $mid - 1;
                    while ($left >= 0) {
                        $leftProductPrice = (float)str_replace('$', '', $products[$left]['price']);
                        if ($leftProductPrice >= $lowerBound && $leftProductPrice < $upperBound) {
                            $results[] = $products[$left];
                            $left--;
                        } else {
                            break;
                        }
                    }

                    // Search right for more matching results
                    $right = $mid + 1;
                    while ($right < count($products)) {
                        $rightProductPrice = (float)str_replace('$', '', $products[$right]['price']);
                        if ($rightProductPrice >= $lowerBound && $rightProductPrice < $upperBound) {
                            $results[] = $products[$right];
                            $right++;
                        } else {
                            break;
                        }
                    }
                    break;
                } elseif ($productPrice < $lowerBound) {
                    $low = $mid + 1;
                } else {
                    $high = $mid - 1;
                }
            }
        }

        return $results;
    }



}
