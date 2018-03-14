<!DOCTYPE html>
<html>
<head>
<title>Pure Imagination</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<script src="<?php echo dirname(base_url()) . '/';?>assets/jquery.min.js"></script>
<script src="<?php echo dirname(base_url()) . '/';?>assets/angular.min.js"></script>
<script src="<?php echo dirname(base_url()) . '/';?>assets/buttons.js"></script>
<script src="<?php echo dirname(base_url()) . '/';?>assets/quantity.js"></script>
<script src="<?php echo dirname(base_url()) . '/';?>assets/faq.js"></script>
<link rel="stylesheet" href="<?php echo dirname(base_url()) . '/';?>style/store.css">
</head>

<body>
<div id="main-container">
	<header id="headerArea">
		<div id="hdrow1">
			<div id="banner">
				<a href="<?php echo base_url();?>">
				<img src="<?php echo dirname(base_url()) . '/images/Uexkull_logo.png';?>"/>
				</a>
			</div>
			<nav id="nav">
			<ul>
				<?php echo $categoryNav;?>
			</ul>
			</nav>
			<nav id="usrnav">
			<ul>
				<?php echo $wishcart;?>
				<li id="navCartItems">
					<span><?php echo $cart_items;?></span>
				</li></a>
					<?php echo $MyPageMenu;?>
			</ul>
			</nav>
		</div>
		
		<div id="hdrow2">
			<form id="navSearch" action="<?php echo $search;?>" method="post">
				<input id="navSearchTextBox" placeholder="Search products" autocomplete="off" name="search" value="<?php echo $previous_search;?>" maxlength="126" type="text">
				<button id="navSearchButton" type="submit"><img src="<?php echo dirname(base_url()) . '/images/search.png';?>"/></button>
			</form>	
			<div id="navWel"><?php echo $welcome?></div>
			<div id="reg_log"><ul><?php echo $reg?></ul></div>
		</div>
	</header>