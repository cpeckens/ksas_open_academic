<!--
For development environment search and replace javascripts/min. for javascripts/
For production environment search and replace javascripts/ for javascripts/min.
-->
<!***********ALL PAGES**************>  
<script src="<?php echo get_template_directory_uri() ?>/assets/javascripts/min.foundation.js"></script> 
<script src="<?php echo get_template_directory_uri() ?>/assets/javascripts/app.js"></script>
<script>
var $l = jQuery.noConflict();
$l(document).ready(function() {
$l('.nav-bar .has-flyout .flyout .has-flyout').hover(function() {$l(this).find('ul.flyout').show();}, function() {$l(this).find('ul.flyout').hide();});
});
</script>
<!**********TABLET/MOBILE MENUS**************>  
<?php $user_agent = empty($_SERVER['HTTP_USER_AGENT']) ? false : $_SERVER['HTTP_USER_AGENT'];if(preg_match('/(ipad|viewpad|tablet|bolt|xoom|touchpad|playbook|kindle|gt-p|gt-i|sch-i|sch-t|mz609|mz617|mid7015|tf101|g-v|ct1002|transformer|silk| tab)/i', $user_agent ) || ( preg_match('/android/i', $user_agent ) && !preg_match('/mobile/i', $user_agent )) ) ://do something here for tablets  ?>
		<script>
			jQuery(document).ready(function () {
			    jQuery('#main_nav').meanmenu({meanScreenWidth: "1400"});
			});
		</script>
		<style>#search-bar {margin-top:50px;}</style>
<?php else : ?>
	<script>
		jQuery(document).ready(function () {
		    jQuery('#main_nav').meanmenu();
		});
	</script>
<?php endif; ?>

<!***********DIRECTORY**************>
<?php $theme_option = flagship_sub_get_global_options();
if ( is_page_template( 'template-people-directory.php' ) && $theme_option['flagship_sub_directory_search']  == '1' )  { ?>
  	<script src="<?php echo get_template_directory_uri() ?>/assets/javascripts/min.page.directory.js"></script>
  	<script>
	    var $j = jQuery.noConflict();
	    $j(window).load(function() {
	        var filterFromQuerystring = getParameterByName('filter');
	        $j('.filter a[data-filter=".' + filterFromQuerystring  + '"]').click();
	    });
	</script>

<?php } ?>

<!***********SINGLE ITEMS (NEWS & PEOPLE_**************>
<?php 
	$about_id = ksas_get_page_id('about');
	$archive_id = ksas_get_page_id('archive');
	$people_id = ksas_get_page_id('people'); 
	if (empty($people_id) == true ) { $people_id = ksas_get_page_id('directoryindex'); }
	$faculty_id = ksas_get_page_id('faculty');
?>
<?php if (  is_singular('post') ) { ?>
	<script>
		var $j = jQuery.noConflict();
		$j(document).ready(function(){
			$j('li.page-id-<?php echo $about_id; ?>').addClass('current_page_ancestor');
			$j('li.page-id-<?php echo $archive_id; ?>').addClass('current_page_parent');
			});
	</script>
<?php } ?>

<?php if ( is_singular('people') ) { ?>
	<script>
		var $k = jQuery.noConflict();
		$k(document).ready(function(){
			$k('li.page-id-<?php echo $people_id; ?>').addClass('current_page_ancestor');
			$k('li.page-id-<?php echo $faculty_id; ?>').addClass('current_page_parent');
			});
	</script>
<?php } ?>

<!***********HOMEPAGE**************>
<?php if ( is_front_page()) { ?>
	<script src="<?php echo get_template_directory_uri() ?>/assets/javascripts/min.foundation.orbit.js"></script>
	<script>
		var $l = jQuery.noConflict();
		$l(window).load(function() {
        $l("#slider").orbit({
        	'animation' : 'fade',
        	'animationSpeed': 1000,
        	'timer' : true,
        	'advanceSpeed' : 8000,
        	'directionalNav' : false,
	        'bullets' : false,		
        });
   });
   </script>
<?php } ?> 

<!***********EVENT CALENDAR**************>
<?php $theme_option = flagship_sub_get_global_options();
if ( is_page_template( 'template-calendar.php' ))  { ?>   				
	<script src="<?php echo get_template_directory_uri() ?>/assets/javascripts/min.easyXDM.js"></script>
	<?php $calendar_url = $theme_option['flagship_sub_calendar_address'];
		$url_for_script = "http://krieger.jhu.edu/calendar/calendar_holder.html?url=" . $calendar_url . "/"; ?>

				<script>
				    new easyXDM.Socket({
				        remote: "<?php echo $url_for_script; ?>",
				        container: document.getElementById("calendar_container"),
				        onMessage: function(message, origin){
				            this.container.getElementsByTagName("iframe")[0].style.height = message + "px";
				            this.container.getElementsByTagName("iframe")[0].style.width = "100%";
				        }
				    });
				</script>

<?php } ?>

<!***********EVENT CALENDAR - MOBILE**************>
<?php $theme_option = flagship_sub_get_global_options();
if ( is_page_template( 'template-calendar-mobile.php' ))  { ?>   				
	<script src="<?php echo get_template_directory_uri() ?>/assets/javascripts/min.easyXDM.js"></script>
	<?php $calendar_url = $theme_option['flagship_sub_calendar_address'];
		$url_for_script = "http://krieger.jhu.edu/calendar/calendar_holder.html?url=" . $calendar_url . "/list/bymonth"; ?>

				<script>
				    new easyXDM.Socket({
				        remote: "<?php echo $url_for_script; ?>",
				        container: document.getElementById("calendar_container"),
				        onMessage: function(message, origin){
				            this.container.getElementsByTagName("iframe")[0].style.height = message + "px";
				            this.container.getElementsByTagName("iframe")[0].style.width = "100%";
				        }
				    });
				    var $j = jQuery.noConflict();
				    $j('td.SECalendarNoEvent').prev('td.SECalendarEventDate').css('display', 'none');
				</script>

<?php } ?>