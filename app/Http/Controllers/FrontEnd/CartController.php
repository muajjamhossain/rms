<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu;
use App\Restaurant;
use Cart;

class CartController extends Controller
{
	public function loadCart($id)
	{
		$restaurant = Restaurant::findOrFail($id);
		return view('front-end.layout'.$restaurant->menu_theme.'.cart.index', compact('restaurant'));
	}

    public function addCart($id, $type)
    {
    	$menu = Menu::findOrFail($id);
    	$addToCart = Cart::add([
    		'id' => $menu->id, 
    		'name' => $menu->name, 
    		'qty' => 1, 
    		'price' => $menu->price,
    		'weight' => 0, 
    		'options' => ['photo' => $menu->photo, 'type' => $type]]);
    	return Cart::content()->count();
    }

    public function deleteCartItem($id, $itemId)
    {
    	$restaurant = Restaurant::findOrFail($id);
    	foreach (Cart::content() as $item) {
    		if($item->id == $itemId) {
    			$rowId = $item->rowId;
    		}
    	}
    	Cart::remove($rowId);
    	return view('front-end.layout'.$restaurant->menu_theme.'.cart.index', compact('restaurant'));
    }

    public function updateQty($id, $itemId, $action)
    {
        $restaurant = Restaurant::findOrFail($id);
        foreach (Cart::content() as $item) {
            if($item->id == $itemId) {
                $rowId = $item->rowId;
                $qty = $item->qty;
            }
        }
        if($action == 'inc') {
            Cart::update($rowId, ++$qty);
        } else if($action == 'dec') {
            Cart::update($rowId, --$qty);
        }
        
        return view('front-end.layout'.$restaurant->menu_theme.'.cart.index', compact('restaurant'));
    }
}
