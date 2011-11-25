<?php

require_once 'simple_html_dom/simple_html_dom.php';

define("BASE_PATH", "http://www.google.com/movies");

class GoogleMovieShowtimes {
	function __construct($location = NULL, $mid = NULL, $tid = NULL) {
		$this->params = array(
			'near' => $location,
			'mid' => $mid,
			'tid' => $tid,
		);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, BASE_PATH . '?' . http_build_query($this->params));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl, CURLINFO_HEADER_OUT, 1);

		$this->response = array();
		$this->response['body'] = curl_exec($curl);
		$this->response['code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$this->response['headers'] = curl_getinfo($curl, CURLINFO_HEADER_OUT);

		curl_close($curl);

		if ($this->response['code'] == 200) {
			$this->html = str_get_html($this->response['body']);
		}
	}

	function check() {
		if ($this->response['code'] == 200) {
			return TRUE;
		}

		return FALSE;
	}

	function parse() {
		if ($this->params['mid']) {
			$i = 0;
			$resp = array();

			foreach ($this->html->find('#movie_results .movie') as $div) {
				$resp['movie'][$i]['name'] = $div->find('h2', 0)->innertext;
				$resp['movie'][$i]['info links'] = $div->find('.info, .links', 0)->innertext;
				$resp['movie'][$i]['info'] = $div->find('.info', 1)->innertext;

				$actors = $div->find('.info span');
				$j = 0;
				foreach($actors as $actor) {
					$resp['movie'][$i]['actors'][$j] = $actor->innertext;
					$j++;
				}

				$resp['movie'][$i]['stars'] = $div->find('nobr', 1)->innertext;

				$j = 0;
				foreach ($this->html->find('#movie_results .theater') as $div) {
					$resp['movie'][$i]['theater'][$j]['name'] = $div->find('.name a', 0)->innertext;
					$resp['movie'][$i]['theater'][$j]['address'] = $div->find('.address', 0)->innertext;

					$k = 0;
					foreach ($div->find('.times span') as $time) {
						$resp['movie'][$i]['theater'][$j]['time'][$k] = $time->innertext;

						$k++;
					}
					$j++;
				}

				$i++;
			}
		}

	}
}

?>
