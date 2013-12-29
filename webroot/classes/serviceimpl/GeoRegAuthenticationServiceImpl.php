<?php

class GeoRegAuthenticationServiceImpl implements AuthenticationService {
	
	public function authenticate() {
		return new GeoUser(null, 'anonymous', true);
	}
	
}
