interval = <?php echo $_GET["interval"];?>;
count = <?php echo $_GET["count"];?>;

arp = 0;
function ajax_random_post() {
	arp_layer = $("#ajax-random-post li");
	$(arp_layer).hide("slow");
	$(arp_layer[arp]).show("slow");
	arp++;
	if (arp==count) arp=0;
}

setInterval(function() {ajax_random_post();},interval*1000);
ajax_random_post();