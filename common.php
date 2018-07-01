<?php

//很好用的html压缩函数
function compress_html($string) {
      return ltrim(rtrim(preg_replace(array("/> *([^ ]*) *</","/<!--[^!]*-->/","'/\*[^*]*\*/'","/\r\n/","/\n/","/\t/",'/>[ ]+</'),array(">\\1<",'','','','','','><'),$string)));
}

//格式化输出函数
if(file_exists('dump')){
	function dump($data){
		echo "<pre>";
		print_r($data);
		echo '</pre>';
	}
}

//格式化输出函数,并中断
if(file_exists('halt')){
	function halt($data){
		echo "<pre>";
		print_r($data);
		echo '</pre>';
		exit;
	}
}
 
