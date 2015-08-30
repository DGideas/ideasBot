<?php
//This file include MediaWiki APIs.
//Author:DGideas

class ideasBot
{
	function __construct()
	{
		
	}
	
	public function set(wiki,username,password)
	{
		
	}
	
	public function connect()
	{
		$ideasconnect = curl_init();
		if ($post!="")
		{
			$post=$post."&format=xml";
		}
		
		if ($site=="")
		{
			curl_setopt ($ideasconnect, CURLOPT_URL, $url[$GLOBALS["wiki"]]);
		}
		else
		{
			curl_setopt ($ideasconnect, CURLOPT_URL, $url[$site]);
		}
		curl_setopt ($ideasconnect, CURLOPT_HEADER, False);
		curl_setopt ($ideasconnect, CURLOPT_ENCODING, "UTF-8");
		curl_setopt ($ideasconnect, CURLOPT_USERAGENT, $UserAgent);
		curl_setopt ($ideasconnect, CURLOPT_POST, True); 
		curl_setopt ($ideasconnect, CURLOPT_POSTFIELDS,$post);
		curl_setopt ($ideasconnect, CURLOPT_RETURNTRANSFER, True);
		curl_setopt ($ideasconnect, CURLOPT_COOKIEFILE, $CookieFile);
		curl_setopt ($ideasconnect, CURLOPT_COOKIEJAR, $CookieFile);
		
		$data=curl_exec($ideasconnect);
		
		return $data;
	}
	
	public function register()
	{
		
	}
	
	public function login()
	{
		
	}
	
	public function get()
	{
		
	}
	
	public function edit()
	{
		
	}
	
	public function delete()
	{
		
	}
	
	public function watch()
	{
		
	}
	
	public function unwatch()
	{
		
	}
	
	public function protect()
	{
		
	}
	
	public function rollback()
	{
		
	}
	
	public function move()
	{
		
	}
	
	public function undelete()
	{
		
	}
	
	public function patrol()
	{
		
	}
	
	protected function get_token()
	{
		
	}
	
	protected function uuid(){
		if (function_exists('com_create_guid')){ 
			return com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);
			$uuid = substr($charid, 0, 8).$hyphen
					.substr($charid, 8, 4).$hyphen
					.substr($charid,12, 4).$hyphen
					.substr($charid,16, 4).$hyphen
					.substr($charid,20,12);
			$uuid=strtolower($uuid);
			return $uuid;
		}
	}

}
?>
