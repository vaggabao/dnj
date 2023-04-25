<div id="menu-right" class="sb-slidebar sb-right">
	<div class="close-div">
		
	</div>
	<ul>
		<li></li>
        <li><a href=<?php echo LNK_ROOT . "/admin/home";?> ><span>Home</span></a></li>
        <li><a href=<?php echo LNK_ROOT . "/admin/calendar";?> ><span>Calendar</span></a></li>
        <li><a href=<?php echo LNK_ROOT . "/admin/messages";?> ><span>Messages</span></a></li>
        <li><a href=<?php echo LNK_ROOT . "/admin/utilities";?> ><span>Utilities</span></a></li>
        <li><a href=<?php echo LNK_ROOT . "/admin/logout";?> ><span>Log Out</span></a></li>
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