<?php 
	function takeaway_menu($menus){
		$count = 0;
		foreach ($menus as $menu) {
			if($menu->takeaway_service == 1) {
				$count++;
			}
		}
		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}

	function dining_menu($menus){
		$count = 0;
		foreach ($menus as $menu) {
			if($menu->dining_service == 1) {
				$count++;
			}
		}
		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}