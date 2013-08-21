	<?php $theme_option = flagship_sub_get_global_options(); ?>
		
		<div id="fields_search">
			<form action="#">
				<fieldset class="radius10">
			<?php if ($theme_option['flagship_sub_role_search'] == true) { ?>	
					<?php $roles = get_terms('role', array(
						'orderby'       => 'name', 
						'order'         => 'ASC',
						'hide_empty'    => true, 
						));
						
						$count_roles =  count($roles);
						if ( $count_roles > 0 ) { ?>
							<div class="row filter option-set" data-filter-group="role">
									<div class="button radio"><a href="#" data-filter="" class="selected">View All</a></div>
								<?php foreach ( $roles as $role ) { ?>
									<div class="button radio"><a href="#" data-filter=".<?php echo $role->slug; ?>"><?php echo $role->name; ?></a></div>
								<?php } ?>
							</div>
						<?php } ?>
			<?php } ?>
					<div class="row">		
						<input type="submit" class="icon-search" placeholder="Search by name, title, and research interests" value="&#xe004;" />
						<input type="text" name="search" id="id_search"  /> 
					</div>
			<?php if ($theme_option['flagship_sub_research_search'] == true) { ?>
					<div class="row">
						<h6>Filter by Research Area:</h6>
					</div>

					<?php $filters = get_terms('filter', array(
						'orderby'       => 'name', 
						'order'         => 'ASC',
						'hide_empty'    => true, 
						));
						
						$count_filters =  count($filters);
						if ( $count_filters > 0 ) { ?>
							<div class="row filter option-set" data-filter-group="expertise">
									<div class="button radius10 yellow_bg"><a href="#" class="black selected" data-filter="" class="selected">Clear Filters</a></div>
								<?php foreach ( $filters as $filter ) { ?>
									<div class="button radius10 yellow_bg"><a href="#" class="black" data-filter=".<?php echo $filter->slug; ?>"><?php echo $filter->name; ?></a></div>
								<?php } ?>
							</div>
						<?php } } ?>
						
				</fieldset>
			</form>	
		</div>
