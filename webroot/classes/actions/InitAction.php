<?php

class InitAction implements Action {
	
	public function serve(Request $request) {
		return new PageForward('index');
	}
	
}
