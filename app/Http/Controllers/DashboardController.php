<?php

namespace App\Http\Controllers;

use App\Models\UserDeal;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Deal;


class DashboardController extends Controller
{


    public function listDeals()
    {
        $userId = Auth::id();
    
        // Retrieve all deals associated with the user
        $deals = UserDeal::where('user_id', $userId)->get();
        info($deals);
    
        $dealIds = $deals->pluck('deal_id')->toArray();
    
        $allDeals = Deal::whereIn('dealID', $dealIds)->get();
    
        // Retrieve ratings for each deal
        $dealRatings = $deals->pluck('rating', 'deal_id')->toArray();
    
        // Add ratings to each deal
        $allDealsWithRatings = $allDeals->map(function ($deal) use ($dealRatings) {
            $deal->rating = $dealRatings[$deal->dealID] ?? null;
            return $deal;
        });
    
        return response()->json([
            'deals' => $allDealsWithRatings
        ]);
    }
    
    public function add(Request $request)
    {
        try {
            $item = $request->all(); // Get the item data from the request
    
            // Check if the deal already exists
            $deal = Deal::where('dealID', $item['dealID'])->first();
            if ($deal) {
                    
            }
            else{
                // Save the item to the database
                $deal = new Deal();
                $deal->dealID = $item['dealID'];
                $deal->storeID = $item['storeID'];
                $deal->gameID = $item['gameID'];
                $deal->thumb = $item['thumb'];
                $deal->title = $item['title'];
                $deal->salePrice = $item['salePrice'];
                $deal->normalPrice = $item['normalPrice'];
                $deal->isOnSale = $item['isOnSale'];
                $deal->savings = $item['savings'];
                $deal->metacriticScore = $item['metacriticScore'];
                $deal->steamRatingText = $item['steamRatingText'];
                $deal->steamRatingPercent = $item['steamRatingPercent'];
                $deal->steamRatingCount = $item['steamRatingCount'];
                $deal->steamAppID = $item['steamAppID'];
                $deal->releaseDate = $item['releaseDate'];
                $deal->lastChange = $item['lastChange'];
                $deal->dealRating = $item['dealRating'];
                $deal->internalName = $item['internalName'];
                $deal->metacriticLink = $item['metacriticLink'];
        
                $deal->save();
        
                // Retrieve the newly created deal item
                // $savedDeal = Deal::find($deal->dealID);

            }


            $userId = Auth::id();

            $existingUserDeal = UserDeal::where('user_id', $userId)
            ->where('deal_id', $deal->dealID)
            ->first();
            if ($existingUserDeal) {
                return response()->json(['message' => 'UserDeal already exists'], 409);
            }

            
        
            $user_deal = new UserDeal();
            $user_deal->user_id =  $userId;
            $user_deal->deal_id = $deal->dealID;
            $user_deal->save();
            $savedUserDeal = UserDeal::find($user_deal->id);

    
       
            
            return response()->json([
                'message' => 'Item added successfully',
                'item' => $savedUserDeal
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }



    public function delete($dealID)
    {   
 

        $userID = Auth::id();

        $userDeal = UserDeal::where('deal_id', $dealID)
            ->where('user_id', $userID)
            ->first();
    
        if (!$userDeal) {
            return response()->json(['message' => 'UserDeal not found'], 404);
        }
    
        $userDeal->delete();
        return response()->json(['message' => 'UserDeal deleted successfully']);
    }

    public function saveRating(Request $request, $dealID)
    {
        try {
            $validatedData = $request->validate([
                'rating' => 'required|integer|between:0,10'
            ]);

            $userID = Auth::id();

            $userDeal = UserDeal::where('deal_id', $dealID)
                ->where('user_id', $userID)
                ->first();

            if (!$userDeal) {
                return response()->json(['message' => 'UserDeal not found'], 404);
            }

            $userDeal->rating = $validatedData['rating'];
            $userDeal->save();

            return response()->json(['message' => 'Rating saved successfully']);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
    
}



