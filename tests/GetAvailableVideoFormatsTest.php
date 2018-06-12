<?php
use PHPUnit\Framework\TestCase;

class GetAvailableVideoFormatsTest extends TestCase
{
	
    public function testGetFormatsThroughYdl()
    {
		$url = 'http://hotstar-test1.herokuapp.com/getAvailableVideoFormats.php';
		$data = array('url' => 'http://www.hotstar.com/tv/chinnathambi/15301/chinnathambi-yearns-for-nandini/1100003795');

		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		
		$this->assertTrue($result !== FALSE);
		
		$response = json_decode($result, true);
		
		//Since playlistId changes as more episodes gets added, we fix that one to a constant value
		$response['playlistId'] = 149;
		
		$expected = array();
		$expected['status'] = "true";
		$expected['source'] = "ydl";
		$expected['videoId'] = "1100003795";
		$expected['playlistId'] = 149;
		$expected['hls-121'] = "320x180";
		$expected['hls-241'] = "320x180";
		$expected['hls-461'] = "416x234";
		$expected['hls-861'] = "640x360";
		$expected['hls-1362'] = "720x404";
		$expected['hls-2063'] = "1280x720";
		$expected['hls-3192'] = "1600x900";
		$expected['hls-4694'] = "1920x1080";
		
		$this->assertEquals($expected, $response);
		
    }
	
	 public function testGetFormatsThroughApi()
    {
		$url = 'http://hotstar-test1.herokuapp.com/getAvailableVideoFormats.php';
		$data = array('url' => 'http://www.hotstar.com/tv/khoka-babu/8828/tori-a-pampered-child/1000093817');

		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		
		$this->assertTrue($result !== FALSE);
		
		$response = json_decode($result, true);
		
		$this->assertEquals("true", $response['status']);
		$this->assertEquals("api", $response['source']);
		$this->assertEquals("1000093817", $response['videoId']);
		$this->assertEquals(1, $response['episodeNumber']);
		$this->assertEquals("Tori, a Pampered Child", $response['title']);
		$this->assertEquals("Starting tonight, Khoka Babu is about a happy-go-lucky girl, Tori. The only daughter of industrialist Rajsekhar, she is pampered by her father. Tori's mother, Anuradha is worried about her carefree nature. Her father fixes her engagement with Preet, but Anuradha is unhappy with the alliance.", $response['description']);
		
		
    }
	
}
?>