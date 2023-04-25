<div id="menu-right" class="sb-slidebar sb-right">
	<div class="close-div">
		
	</div>
	<ul>
		<li></li>
		<li><a href=<?php echo LNK_ROOT . "/tenant/dashboard/home";?> ><span>Home</span></a></li>
		<li><a href=<?php echo LNK_ROOT . "/tenant/dashboard/bills";?> ><span>Bills</span></a></li>
		<li><a href=<?php echo LNK_ROOT . "/tenant/dashboard/transactions";?> ><span>Transactions</span></a></li>
		<li><a href=<?php echo LNK_ROOT . "/tenant/dashboard/account";?> ><span>Account</span></a></li>
		<li><a href=<?php echo LNK_ROOT . "/tenant/dashboard/logout";?> ><span>Log Out</span></a></li>
	</ul>
</div>

<script type="text/javascript" src=<?php echo LNK_SLIDEBAR_JS; ?> ></script>
<script>
	$(function() {
		$(document).ready(function() {
		  $.slidebars();
		});
	})
</script>