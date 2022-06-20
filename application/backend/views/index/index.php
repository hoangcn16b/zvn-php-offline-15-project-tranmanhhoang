<?php
$linkGroup = URL::createLink($this->arrParams['module'], 'group', $this->arrParams['action']);
$linkUser = URL::createLink($this->arrParams['module'], 'user', $this->arrParams['action']);
$arrMenu = [
	['total' => $this->total['Group'], 'name' => 'Group', 'class' => 'people', 'href' => $linkGroup],
	['total' => $this->total['User'], 'name' => 'User', 'class' => 'person', 'href' => $linkUser],
	['total' => 10, 'name' => 'Category', 'class' => 'clipboard', 'href' => '#'],
	['total' => 50, 'name' => 'Book', 'class' => 'book', 'href' => '#']
];
$xhtml = '';
foreach ($arrMenu as $key => $value) {
	$xhtml .= '
				<div class="col-lg-3 col-6">
					<div class="small-box bg-info">
						<div class="inner">
							<h3>' . $value['total'] . '</h3>
							<p>' . $value['name'] . '</p>
						</div>
						<div class="icon">
							<i class=" ion ion-ios-' . $value['class'] . '"></i>
						</div>
						<a href="' . $value['href'] . '" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
			';
}

?>

<div class="row">
	<?= $xhtml ?>
	<!-- <div class="col-lg-3 col-6">
		<div class="small-box bg-info">
			<div class="inner">
				<h3>3</h3>
				<p>Group</p>
			</div>
			<div class="icon">
				<i class="ion ion-ios-people"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-6">
		<div class="small-box bg-info">
			<div class="inner">
				<h3>3</h3>

				<p>User</p>
			</div>
			<div class="icon">
				<i class="ion ion-ios-person"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-6">
		<div class="small-box bg-info">
			<div class="inner">
				<h3>10</h3>

				<p>Category</p>
			</div>
			<div class="icon">
				<i class="ion ion-clipboard"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-6">
		<div class="small-box bg-info">
			<div class="inner">
				<h3>30</h3>

				<p>Book</p>
			</div>
			<div class="icon">
				<i class="ion ion-ios-book"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div> -->
</div>