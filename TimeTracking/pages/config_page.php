<?php
namespace TimeTracking;

/*
   Copyright 2011 Michael L. Baker

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.

   Notes: Based on the Time Tracking plugin by Elmar:
   2005 by Elmar Schumacher - GAMBIT Consulting GmbH
   http://www.mantisbt.org/forums/viewtopic.php?f=4&t=589	
*/


access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
layout_page_header( plugin_lang_get( 'title' ) . ': ' . plugin_lang_get( 'configuration' ) );
layout_page_begin( 'manage_overview_page.php' );
print_manage_menu( 'manage_plugin_page.php' );

$t_project = helper_get_current_project();
if( ALL_PROJECTS == $t_project ) {
	$t_project_title = lang_get( 'config_all_projects' );
} else {
	$t_project_title = sprintf( lang_get( 'config_project' ), string_display_line( project_get_name( $t_project ) ) );
}

?>

<div class="col-md-12 col-xs-12">
	<div class="space-10"></div>

	<div class="form-container" class="form-inline">
		<form action="<?php echo plugin_page( 'config_update' ) ?>" method="post">
			<div class="widget-box widget-color-blue2">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title lighter">
						<i class="ace-icon fa fa-exchange"></i>
						<?php echo plugin_lang_get( 'title' ), ': ', plugin_lang_get( 'project_configuration' ) ?>
					</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main no-padding">
						<div class="widget-toolbox padding-8 clearfix">
							<p class="bold"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $t_project_title ?></p>
						</div>
						<?php echo form_security_field( 'plugin_TimeTracking_config_update' ) ?>
						<input type="hidden" name="project_id" value="<?php echo $t_project ?>" />
						<div class="table-responsive">
							<table class="table table-bordered table-condensed table-striped">
								<tbody>
									<tr>
										<td class="category"><?php echo plugin_lang_get( 'enable_timetracking' ) ?></td>
										<td>
											<select name="entry_enabled" class="input-sm">
												<?php
												$t_basename = plugin_get_current();
												$t_full_option = 'plugin_' . $t_basename . '_' . 'enabled';
												# Avoid fallback to plugin config() to exactly know if the option has been set
												unregister_global_config( $t_full_option );
												$t_conf_enabled = plugin_config_get( 'enabled', -1, false, ALL_USERS, $t_project );
												//$t_conf_enabled = config_get( $t_full_option, -1, ALL_USERS, $t_project );
												$t_sel_default = $t_conf_enabled == -1 ? 'selected' : '';
												$t_sel_disabled = $t_conf_enabled == OFF ? 'selected' : '';
												$t_sel_enabled = $t_conf_enabled == ON ? 'selected' : '';
												echo '<option value="2" ', $t_sel_default, '>DEFAULT</option>';
												echo '<option value="0" ', $t_sel_disabled, '>DISABLED</option>';
												echo '<option value="1" ', $t_sel_enabled, '>ENABLED</option>';
												?>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="widget-toolbox padding-8 clearfix">
						<input type="submit" name="update-project" class="btn btn-primary btn-white btn-round" value="<?php echo lang_get( 'change_configuration' ) ?>" />
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="space-10"></div>

	<div class="form-container" class="form-inline">
		<form action="<?php echo plugin_page( 'config_update' ) ?>" method="post">
			<div class="widget-box widget-color-blue2">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title lighter">
						<i class="ace-icon fa fa-exchange"></i>
						<?php echo plugin_lang_get( 'title' ), ': ', plugin_lang_get( 'global_configuration' ) ?>
					</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main no-padding">
						<?php echo form_security_field( 'plugin_TimeTracking_config_update' ) ?>
						<div class="table-responsive">
							<table class="table table-bordered table-condensed table-striped">
								<tbody>
									<tr>
										<td class="category"><?php echo plugin_lang_get( 'view_threshold' ) ?></td>
										<td>
											<select name="view_threshold" class="input-sm">
												<?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'view_threshold' ) ) ?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="category"><?php echo plugin_lang_get( 'edit_threshold' ) ?></td>
										<td><select name="edit_threshold" class="input-sm">
											<?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'edit_threshold' ) ) ?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="category"><?php echo plugin_lang_get( 'reporting_threshold' ) ?></td>
										<td><select name="reporting_threshold" class="input-sm">
											<?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'reporting_threshold' ) ) ?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="category"><?php echo plugin_lang_get( 'config_enable_stopwatch' ) ?></td>
										<td>
											<input type="checkbox" class="ace" name="stopwatch_enabled" value="<?php echo ON ?>" <?php check_checked( plugin_config_get( 'stopwatch_enabled' ), ON ) ?>>
											<span class="lbl"></span>
										</td>
									</tr>
									<tr>
										<td class="category"><?php echo plugin_lang_get( 'categories' ) ?></td>
										<td>
											<textarea class="form-control" id="categories" name="categories" cols="80" rows="10">
												<?php echo plugin_config_get( 'categories' ) ?>
											</textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="widget-toolbox padding-8 clearfix">
						<input type="submit" name="update-global" class="btn btn-primary btn-white btn-round" value="<?php echo lang_get( 'change_configuration' ) ?>" />
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<?php
layout_page_end();
