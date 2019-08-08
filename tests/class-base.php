<?php
namespace PMP\Tests;

use PMP\Tests\Helpers\Factory\Level;

abstract class Base Extends \WP_UnitTestCase {

	function __get( $name ) {
		if ( 'factory' === $name ) {
			return $this->_pmp_factory();
		}
	}

	/**
	 * Fetches the factory object for generating WordPress & PMP fixtures.
	 *
	 * @return WP_UnitTest_Factory The fixture factory.
	 */
	protected function _pmp_factory() {
		$factory = self::factory();

		$factory->pmp_level = new Level( $this );

		return $factory;
	}

	/**
	 * Runs the routine after all tests have been run.
	 */
	public static function tearDownAfterClass() {
		self::_delete_all_pmp_data();

		parent::tearDownAfterClass();
	}

	protected static function _delete_all_pmp_data() {
		global $wpdb;

		$tables = [
			$wpdb->pmpro_discount_codes,
			$wpdb->pmpro_discount_codes_levels,
			$wpdb->pmpro_discount_codes_uses,
			$wpdb->pmpro_membership_levelmeta,
			$wpdb->pmpro_membership_levels,
			$wpdb->pmpro_membership_orders,
			$wpdb->pmpro_memberships_categories,
			$wpdb->pmpro_memberships_pages,
			$wpdb->pmpro_memberships_users,
		];

		foreach ( $tables as $table ) {
			$wpdb->query( "DELETE FROM {$table}" );
			$wpdb->query( "ALTER TABLE {$table} AUTO_INCREMENT = 0" );
		}
	}

} // end of class

//EOF