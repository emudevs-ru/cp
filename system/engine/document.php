<?php
/*
    Autor: mrSlink
    Update date: 9.07.2020
    Description:
    Document class
*/
class Document {
	private $title;
	private $robots;
	private $description;
	private $keywords;
	private $links = array();
	private $styles = array();
	private $scripts = array();
	private $og_image;

	/**
     * Function that saves the current page title
     * @param	string	$title
     */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
     * Function giving the current page title
	 * @return	string
     */
	public function getTitle() {
		return $this->title;
	}
	
	public function setRobots($robots) {
		$this->robots = $robots;
	}
	
	public function getRobots() {
		return $this->robots;
	}

	/**
     * Function that saves the current page description
     * @param	string	$description
     */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
     * Function giving the current page description
     * @param	string	$description
	 * @return	string
     */
	public function getDescription() {
		return $this->description;
	}

	/**
     * Function that saves the current page keywords
     * @param	string	$keywords
     */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
     * Function giving the current page keywords
	 * @return	string
     */
	public function getKeywords() {
		return $this->keywords;
	}
	
	/**
     * Adding <link> Page
     * @param	string	$href
	 * @param	string	$rel
     */
	public function addLink($href, $rel) {
		$this->links[$href] = array(
			'href' => $href,
			'rel'  => $rel
		);
	}

	/**
     * Adding <link> Page
	 * @return	array
     */
	public function getLinks() {
		return $this->links;
	}

	/**
     * Adding <link> Page Styles
     * @param	string	$href
	 * @param	string	$rel
	 * @param	string	$media
     */
	public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
		$this->styles[$href] = array(
			'href'  => $href,
			'rel'   => $rel,
			'media' => $media
		);
	}

	/**
     * Adding <link> Page Styles
	 * @return	array
     */
	public function getStyles() {
		return $this->styles;
	}

	/**
     * Adding <script> Page Scripts
     * @param	string	$href
	 * @param	string	$postion
     */
	public function addScript($href, $postion = 'header') {
		$this->scripts[$postion][$href] = $href;
	}

	/**
     * Adding <script> Page Scripts
     * @param	string	$postion
	 * 
	 * @return	array
     */
	public function getScripts($postion = 'header') {
		if (isset($this->scripts[$postion])) {
			return $this->scripts[$postion];
		} else {
			return array();
		}
	}
	
	public function setOgImage($image) {
		$this->og_image = $image;
	}

	public function getOgImage() {
		return $this->og_image;
	}
}