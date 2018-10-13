<?php
    require('simple_html_dom.php');

    class DuzceBot{
        
        function __construct(){
			
        }
        
        function duyuruHttpOutput(){
			$user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Trans/20041002 Firefox/0.10';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://www.duzce.edu.tr/fakulte-duyurular');
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , FALSE);
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER , TRUE);
	    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION , TRUE);
	    	curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
		    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			$icerik = curl_exec($ch);
			curl_close($ch);
			return $icerik;
        }

        function getContent(){
            $html = new simple_html_dom();
                $html->load($this->duyuruHttpOutput(), true, false);

                $i = 0;
                foreach($html->find('ul.tum-d') as $article) {
                    $i++;
                    $item['headline'] = $article->find('.news-content h4', 0)->plaintext;
                    $item['date'] = $article->find('.news-date', 0)->plaintext;
                    $item['content'] = $article->find('.news-content', 0)->last_child->plaintext;

                    $articles[] = $item;
                    if($i == 10) break;
                }
                
                $html->clear();
                unset($html);
                return $articles;	
        }

        function duyuruJsonEncode(){
			$json["duyuru"] = $this->getContent();
			return json_encode($json);
		}
		
		function jsonFileOutput($file){
			
			if(!file_exists($file)){
				touch($file);
			}
			
			$dosya = fopen($file, "w");
			fwrite($dosya, $this->duyuruJsonEncode());
			
			fclose($dosya);
		}

    }

?>