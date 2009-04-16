<?php
if ($t['_flash']->hasFlash()) { ?>
<?php foreach ($t['_flash']->read() as $style => $messages) { ?>
	<div id="flash" class="<?php echo $style; ?>">
		<?php foreach ($messages as $message) { 
			echo $message . '<br />';
		}
		?>
	</div>
<?php }
}
?>
