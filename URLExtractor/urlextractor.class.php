<?php

/**
 * UrlExtractor class
 *
 * @package UrlExtractor
 * @author  João Ribeiro
 * 
 * @TODO: Extract thumbnails from videos
 * @TODO: Meybe split the code into smaller classes (One to handle meta tags 
 * 		  and other to handle images and thumbnails)
 * @TODO: Change get_meta_tags to Regex
 * @TODO: Get only the important parts of the site to work with Regex at first
 * @TODO: Return a JSON array with the URL info on extractAll fucntion
 */

Class UrlExtractor {
	
	/**
	 * URL passed as a parameter in construct
	 *
	 * @var string $url
	 */
	protected $url;
	
	/**
	 * Host extracted from the URL
	 *
	 * @var string $host
	 */
	protected $host;
	
	/**
	 * Array to store all the images extracted from the URL
	 *
	 * @var array $images
	 */
	public $images = array();
	
	/**
	 * Title extracted from the URL
	 *
	 * @var string $title
	 */	
	public $title;
	
	/**
	 * Description extracted from the URL
	 *
	 * @var string $description
	 */	
	public $description;
	
	/**
	 * Array to store the keywords extracted from the URL
	 *
	 * @var array $keywords
	 */	
	public $keywords = array();
	
	/**
	 * Array containing the name of the meta tags to be extracted
	 *
	 * @var array $metaTagNames
	 */	
	protected $metaTagNames = array(
								'title' => array(
									'twitter:title',
									'og:title'
								),
								'description' => array(
									'description',
									'twitter:description',
									'og:description'
								),
								'keywords' => array(
									'keywords'
								),
								'images' => array(
									'twitter:image',
									'og:image'
								)
							);
	
	/**
	 * Class contructor
	 *
	 * @param string $url
	 * @return void
	 */
	public function __construct($url) {
		if (!empty($url)) {
			$this->url = $url;
		} else {
			throw new Exception("URL can\'t be empty!");
		}
	}
	
	/**
	 * Function extractAll
	 * 
	 * Extract all the elements from the URL
	 * (title, description, keywords and images)
	 *
	 * @return void
	 */
	public function extractAll() {
		$urlContent = @file_get_contents($this->url);

		if ($urlContent !== FALSE) {
			
			$this->getHost($this->url);

			$this->getPageTitle($urlContent);

			$this->getMetaTagsByName($this->url);

			$this->getMetaTagsByProperty($urlContent);

			$this->getImages($urlContent);

		}
	}
	
	/**
	 * Function getHost
	 * 
	 * Get the host from the URL (Ex: http://localhost.com 
	 * is the host extracted from http://localhost.com/test/index.php)
	 *
	 * @param string $url
	 * @return void
	 */
	protected function getHost($url) {
		$pattern = '/([^:]*:\/\/)?([^\/]*\.)*([^\/\.]+\.[^\/]+)/i';
		
		preg_match($pattern, $url, $results);
		
		$this->host = $results[0];
	}	
	
	/**
	 * Function getPageTitle
	 * 
	 * Get the text inside the <title> tag
	 *
	 * @param string $urlContent
	 * @return void
	 */
	protected function getPageTitle($urlContent) {
		$this->title = $this->getText($urlContent, "<title>", "</title");
	}
	
	/**
	 * Function getMetaTagsByName
	 * 
	 * Get the regular meta tags (Description, keywords, etc..)
	 *
	 * @param string $url
	 * @return void
	 */
	protected function getMetaTagsByName($url) {
		$metaTags = get_meta_tags($this->url);
		$this->setUrlAtributes($metaTags);
	}

	/**
	 * Function getMetaTagsByProperty
	 * 
	 * Get property meta tags like open graph for example
	 * (Ex: <meta property="og:title" content="The Rock" />)
	 * 
	 * @param string $urlContent
	 * @return void
	 */
	protected function getMetaTagsByProperty($urlContent) {
		$pattern = '/<meta.*?property=["|\'](.*?)["|\'].*?content=["|\'](.*?)["|\'].*?>|<meta.*?content=["|\'](.*?)["|\'].*?property=["|\'](.*?)["|\'].*?>/i';
		preg_match_all($pattern, $urlContent, $results);
			
		$metaTags = $this->formatMetaTagsArray($results);
		
		if ($metaTags !== FALSE) {
			$this->setUrlAtributes($metaTags);
		}
	}
	
	/**
	 * Function getImages
	 * 
	 * Get the images from the URL
	 * 
	 * @param string $urlContent
	 * @return void
	 */
	protected function getImages($urlContent) {
		$pattern = '/<img.*?src=["|\'](.*?)["|\'].*?>/i';
		
		preg_match_all($pattern, $urlContent, $results);

		foreach ($results[1] as $image) {
			$image = $this->checkImageUrl($image);
			if ($image !== NULL) {
				array_push($this->images, $image);
			}
		}
	}
	
	/**
	 * Function setUrlAtributes
	 * 
	 * Set the class atributes and overwrite duplicates 
	 * (Ex: Description, Keywords)
	 * 
	 * @param string $metaTags
	 * @return void
	 */
	protected function setUrlAtributes($metaTags) {
		foreach ($this->metaTagNames as $key => $name) {
			
			foreach ($name as $value) {
				
				if (array_key_exists($value, $metaTags)) {
					
					if (is_array($this->$key)) {
						
						if (!empty($metaTags[$value])) {
							array_push($this->$key, $metaTags[$value]);
						}
					} else {
						
						if (!empty($metaTags[$value])) {
							$this->$key = $metaTags[$value];
						}
					}
				}
			}
		}
	}
	
	/**
	 * Function formatMetaTagsArray
	 * 
	 * Utility function used by getMetaTagsByProperty to
	 * properly format the meta tag array expected by 
	 * setUrlAtributes
	 * 
	 * @param array $array
	 * @return array | boolean
	 */
	protected function formatMetaTagsArray($array) {
		$pattern = '/^og:.*/i';
		
		if (preg_grep($pattern, $array[1])) {
			return array_combine($array[1], $array[2]);
		} elseif (preg_grep($pattern, $array[2])) {
			return array_combine($array[2], $array[1]);
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Function checkImageUrl
	 * 
	 * Utility function used by getImages to check image URL
	 * and complete relative URLs
	 * 
	 * @param string $url
	 * @return string
	 */
	protected function checkImageUrl($url) {
		$pattern = '/^[^(\.|\/)].*?[\.?].*?(.jpg|.gif|.png|.jpeg|.bmp)/i';	
		$pattern2 = '/(.jpg|.gif|.png|.jpeg|.bmp)$/i';
		
		$url = preg_replace('/\.\.\//i', '', $url);
		
		if (!preg_match($pattern, $url)) {
			
			if (preg_match($pattern2, $url)) {
				return ($url[0] === '/') ? $this->host . $url : $this->host . '/' . $url;
			} 
		} else {
			return $url;
		}

	}
	
	/**
	 * Function getText
	 * 
	 * Utility function that extract text between start and end points
	 * 
	 * @param string $text
	 * @param string $start
	 * @param string $end
	 * @return string
	 */
	protected function getText($text, $start, $end) {
		$a = explode($start,$text);
		$b = explode($end,$a[1]);
		return $b[0];
	}
}

