<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cookie Tag
 *
 * Returns the "cookie_tag" item from your config file
 *
 * @access	public
 * @return	string
 */	
if ( ! function_exists('cookie_tag'))
{
	function cookie_tag()
	{
		$CI =& get_instance();
		return $CI->config->item('cookie_tag');
	}
}
/**
 * Get the Cookie Id from the client
 *
 * Returns the "cookieId" from the user.
 *
 * @access	public
 * @return	string
 */	
if ( ! function_exists('getCookieId'))
{
	function getCookieId()
	{
		$cookieId = get_cookie(cookie_tag());

		return $cookieId;
	}
}
?>