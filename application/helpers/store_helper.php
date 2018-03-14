<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('load_header'))
{
    function load_header()
    {
		
		$build_categories_func = function() {
			$CI = get_instance();
			$CI->load->model('product_model');
			$categories = $CI->product_model->get_categorylist();
			$string = '';
			foreach ($categories as $cat) {
				$string = $string . '<a href="' . base_url('store/categories/' . strtolower($cat['category'])) . '"><div class="categoryNavItem">' . $cat['category'] . '</div></a>';
			}
			return $string;
		};
		
		$data['search'] = base_url('store/search/');
		if (isset($_SESSION['name'])) {
			$data['welcome'] = "Welcome, " . $_SESSION['name'];
			$data['reg'] = '';
			
			if (isset($_SESSION['user_id'])) {
				$data['MyPageMenu'] = '<li id="navMyPage" class="usrnavItem">
					<a id="mypagelink" href="' . base_url('user/') . '">My Page</a>
						<div id="navMyPageMenu">
						<ul>
							<li class="navPageMenuItem"><a href="' . base_url('user/profile') . '">>My Profile</a></li>
							<li class="navPageMenuItem"><a href="' . base_url('user/wishlist') . '">>Wishlist</a></li>
							<li class="navPageMenuItem"><a href="' . base_url('user/order_history') . '">>Order History</a></li>
							<li class="navPageMenuItem"><a href="' . base_url('auth/logout') . '">>Logout</a></li>
						</ul>
					</div></li>';
				$data['wishcart'] = '<a href="' . base_url('user/wishlist/') . '"><li id="navWish" class="usrnavItem">
					wishlist
				</li></a>
				<a href="' . base_url('cart') . '">
				<li id="navCart" class="usrnavItem">
					Cart
				</li>';
				$data['categoryNav'] = '<li id="categoryNav" class="navItem">
					<a href="' . base_url('store/categories/') . '">Categories</a>
					<div id="categoryNavMenu">
						<ul>' . $build_categories_func() . '</ul>
					</div>
				</li>
				<li class="navItem">
					<a href="' . base_url('store/faq/') . '">FAQ</a>
				</li>';
			}
			elseif (isset($_SESSION['admin_id'])) {
				$data['MyPageMenu'] = '';
				$data['wishcart'] = '<span style="position: relative; padding: 7px; top: 20px; border: 1px solid;">ADMIN ACCOUNT</span>';
				$data['categoryNav'] = '<li class="navItem"><a href="' . base_url('admin') . '">Admin Panel</a></li>
										<li class="navItem"><a href="' . base_url('auth/logout') . '">Logout</a></li>';
				$data['search'] = base_url('admin/search/');
			}
		}
		else {
			$data['welcome'] = '';
			$data['reg'] = '<li id="regbutton"><a href="' . base_url('auth/register') . '">Register</a></li><li><a href="' . base_url('auth/login') . '">Login</a></li>';
			$data['MyPageMenu'] = '<li id="navMyPage" class="usrnavItem">
					<a id="mypagelink" href="' . base_url('user/') . '">My Page</a></li>';
			$data['wishcart'] = '<a href="' . base_url('user/wishlist/') . '"><li id="navWish" class="usrnavItem">
					wishlist
				</li></a>
				<a href="' . base_url('cart') . '">
				<li id="navCart" class="usrnavItem">
					Cart
				</li>';
			$data['categoryNav'] = '<li id="categoryNav" class="navItem">
					<a href="' . base_url('store/categories/') . '">Categories</a>
					<div id="categoryNavMenu">
						<ul>' . $build_categories_func() . '</ul>
					</div>
				</li>
				<li class="navItem">
					<a href="' . base_url('store/faq/') . '">FAQ</a>
				</li>';
		}
		
		if(isset($_POST['search'])) {
			$data['previous_search'] = $_POST['search'];
		}
		else {
			$data['previous_search'] = '';
		}
		
		if(isset($_SESSION['user_id'])) {
			$CI = get_instance();
			$CI->load->model('cart_model');
			$products = $CI->cart_model->get_cart($_SESSION['user_id']);
			if(!isset($products)) {
				$data['cart_items'] = 0;
			}
			else {
				$data['cart_items'] = sizeof($products);
			}
		}
		elseif(isset($_SESSION['admin_id'])) {
			$data['cart_items'] = '';
		}
		else {
			$data['cart_items'] = 0;
		}
		return $data;
    }
	
}

if ( ! function_exists('check_database'))
{
	function check_database($model, $id, $user)
	{
		if (strlen($user)==0) {
			return false;
		}
		$check = $model->check($id, $user);
		return isset($check) ? true : false;
	}
}

?>