<?php
class Pagination_frontend
{

	private $totalItems;					// Tổng số phần tử
	private $totalItemsPerPage		= 1;	// Tổng số phần tử xuất hiện trên một trang
	private $pageRange				= 5;	// Số trang xuất hiện
	private $totalPage;						// Tổng số trang
	private $currentPage			= 1;	// Trang hiện tại

	public function __construct($totalItems, $pagination)
	{
		$this->totalItems			= $totalItems;
		$this->totalItemsPerPage	= $pagination['totalItemsPerPage'];

		if ($pagination['pageRange'] % 2 == 0) $pagination['pageRange'] = $pagination['pageRange'] + 1;

		$this->pageRange			= $pagination['pageRange'];
		$this->currentPage			= $pagination['currentPage'];
		$this->totalPage			= ceil($totalItems / $pagination['totalItemsPerPage']);
	}

	public function showPagination()
	{
		// Pagination
		$link = 'index.php?' . $_SERVER['QUERY_STRING'];
		$pos = strpos($link, '&page=');

		if ($pos) $link = substr($link, 0, $pos);

		$paginationHTML = '';
		if ($this->totalPage > 1) {
			$start 	= '
						<li class="page-item disabled">
							<a class="page-link"><i class="fa fa-angle-double-left"></i>
							</a>
						</li>
					';
			$prev 	= '
						<li class="page-item disabled"><a class="page-link">
							<i class="fa fa-angle-left"></i></a>
						</li>
					';
			if ($this->currentPage > 1) {
				$start 	= '
							<li class="page-item">
								<a class="page-link" href="' . $link . '&page=1" >
									<i class="fa fa-angle-double-left"></i>
								</a>
							</li>
						';
				$prev 	= '
							<li class="page-item">
								<a class="page-link" href="' . $link . '&page=' . ($this->currentPage - 1)
					. '">
									<i class="fa fa-angle-left"></i>
								</a>
							</li>
					';
			}

			$next 	= '<li class="page-item disabled">
							<a class="page-link"><i class="fa fa-angle-right"></i></a>
						</li>
			';
			$end 	= '<li class="page-item disabled">
							<a class="page-link"><i class="fa fa-angle-double-right"></i>
							</a>
						</li>';
			if ($this->currentPage < $this->totalPage) {
				$next 	= '<li class="page-item"><a class="page-link" href="' . $link . '&page=' . ($this->currentPage + 1) . '" ><i class="fa fa-angle-right"></i></a></li>';
				$end 	= '<li class="page-item"><a class="page-link" href="' . $link . '&page=' . $this->totalPage . '" ><i class="fa fa-angle-double-right"></i></a></li>';
			}

			if ($this->pageRange < $this->totalPage) {
				if ($this->currentPage == 1) {
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				} else if ($this->currentPage == $this->totalPage) {
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				} else {
					$startPage		= $this->currentPage - ($this->pageRange - 1) / 2;
					$endPage		= $this->currentPage + ($this->pageRange - 1) / 2;

					if ($startPage < 1) {
						$endPage	= $endPage + 1;
						$startPage = 1;
					}

					if ($endPage > $this->totalPage) {
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			} else {
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}
			$listPages = '';
			for ($i = $startPage; $i <= $endPage; $i++) {
				if ($i == $this->currentPage) {
					$listPages .= '<li class="page-item active"><a class="page-link" >' . $i . '</a></li>';
				} else {
					$listPages .= '<li class="page-item"><a class="page-link" href="' . $link . '&page=' . $i . '">' . $i . '</a>';
				}
			}
			$xhtmlNumOfPage = '<div class = "limit" style="margin:auto; margin-right:20px;"> Page ' . $this->currentPage . ' of ' . $this->totalPage . ' </div> ';
			$xhtmlNumOfPage = '';
			$paginationHTML = '<ul class="pagination">' . $xhtmlNumOfPage . $start . $prev . $listPages . $next . $end . '</ul>';
		}
		return $paginationHTML;
	}

	public function showNumPage()
	{
		$xhtml = '';
		$xhtml .= '
					<div class="col-xl-6 col-md-6 col-sm-12">
						<div class="product-search-count-bottom">
							<h5>Showing Items Page ' . $this->currentPage . '/' . $this->totalPage . ' of ' . $this->totalItems . ' Result</h5>
						</div>
					</div>
				';
		return $xhtml;
	}
}
