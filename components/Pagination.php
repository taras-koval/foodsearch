<?php

class Pagination
{
	// Page navigation links
	private $max = 10;

	// The key for GET, which is written page number
	private $index = 'page';

	// Current page
	private $current_page;

	// Total number of records
	private $total;

	// Limit of records per page
	private $limit;


	public function __construct($total, $currentPage, $limit, $index)
	{
		// Set the total number of records
		$this->total = $total;
		// Set the number of records per page
		$this->limit = $limit;
		// Set the key in the url
		$this->index = $index;
		// Set the number of pages
		$this->amount = $this->amount();
		// Set the current page number
		$this->setCurrentPage($currentPage);
	}

	// To display links, return HTML code with navigation links
	public function get()
	{
		// To record links
		$links = null;

		// Get loop constraints
		$limits = $this->limits();

		$html = '<ul class="pagination">';
		// Generate links
		for ($page = $limits[0]; $page <= $limits[1]; $page++) {

			// If the current is the current page, there is no link and the active class is added
			if ($page == $this->current_page) {
				$links .= '<li class="active"><a href="#">' . $page . '</a></li>';
			} else {
				// Otherwise, generate link
				$links .= $this->generateHtml($page);
			}
		}

		// If links are created
		if (!is_null($links)) {
			// If the current page is not the first
			if ($this->current_page > 1)
				// Create a link "on the first"
				$links = $this->generateHtml(1, '&lt;') . $links;

			// If the current page is not the first
			if ($this->current_page < $this->amount)
				// Create a link "to the last"
				$links .= $this->generateHtml($this->amount, '&gt;');
		}

		$html .= $links . '</ul>';

		return $html;
	}

	// To generate HTML link code
	private function generateHtml($page, $text = null)
	{
		if (!$text) 
			$text = $page;

		$currentURI = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
		$currentURI = preg_replace('~/page-[0-9]+~', '', $currentURI);

		// Generate HTML link code and return
		return '<li><a href="' . $currentURI . $this->index . $page . '">' . $text . '</a></li>';
	}

	// For where to start, return array with start and end of reference
	private function limits()
	{
		// Compute the links to the left (to the active link was in the middle)
		$left = $this->current_page - ceil($this->max / 2);

		// Calculate the origin
		$start = $left > 0 ? $left : 1;

		// If the front there is a minimum of $ this-> max pages
		if ($start + $this->max <= $this->amount)
			// Assign the end of a cycle ahead by $ this-> max pages or just the minimum
			$end = $start > 1 ? $start + $this->max : $this->max;
		else {
			// End - total number of pages
			$end = $this->amount;

			// Start - minus $this->max from the end
			$start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
		}

		return array($start, $end);
	}

	private function setCurrentPage($currentPage)
	{
		// Get the page number
		$this->current_page = $currentPage;

		if ($this->current_page > 0) {
			// If the current page is less than the total number of pages
			if ($this->current_page > $this->amount)
				// Set the page to the last
				$this->current_page = $this->amount;
		} else
			// Set the page to the first
			$this->current_page = 1;
	}

	// To get the total number of pages, return number of pages
	private function amount()
	{
		return ceil($this->total / $this->limit);
	}
}

?>