<?php

class TTMigrationPlugin extends MantisPlugin {
	function register() {
		plugin_require_api( 'core/constants.php' );
		$this->name = 'Time Tracking Migration Tool';
		$this->description = 'Data Migration tool from MantisBT native time tracking to TimeTracking Plugin';
		$this->page = 'migration_overview_page';

		$this->version = '3.0-dev';
		$this->requires = array(
			'MantisCore' => '2.0',
			'TimeTracking' => '3.0-dev'
		);

		$this->author = 'Carlos Proensa';
		$this->contact = '';
		$this->url = 'https://github.com/mantisbt-plugins/timetracking';
	}

	function init() {
		plugin_require_api( 'core/migration_api.php' );
		plugin_require_api( 'core/migration_steps_api.php' );
	}

	function hooks() {
		$h['EVENT_LAYOUT_RESOURCES'] = 'resources';
		return $h;
	}

	function errors() {
		return array(
			TTMigration\ERROR_MIGRATION_ALREADY_EXISTS => plugin_lang_get( 'ERROR_MIGRATION_ALREADY_EXISTS' ),
			TTMigration\ERROR_MANTISTT_ENABLED => plugin_lang_get( 'ERROR_MANTISTT_ENABLED' ),
			TTMigration\ERROR_MANTISTT_NO_DATA => plugin_lang_get( 'ERROR_MANTISTT_NO_DATA' ),
			TTMigration\ERROR_MANTISTT_PREVIOUS_STEP_INCOMPLETE => plugin_lang_get( 'ERROR_MANTISTT_PREVIOUS_STEP_INCOMPLETE' ),
		);
	}

	function schema() {
		$schema[0] =
			array( 'CreateTableSQL', array( plugin_table( 'status' ), "
				status_key		C(16)	NOTNULL,
				status_data		XL		NOTNULL
				" )
		);

		return $schema;
	}

	function resources( $p_event ) {
		$res = '<script type="text/javascript" src="'. plugin_file( 'ttmigration.js' ) .'"></script>';
		return $res;
	}
}

