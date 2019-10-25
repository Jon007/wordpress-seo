<?php

namespace Yoast\WP\Free\Tests\Presentations\Indexable_Post_Type_Presentation;

use Mockery;
use Yoast\WP\Free\Tests\TestCase;

/**
 * Class Canonical_Test
 *
 * @coversDefaultClass \Yoast\WP\Free\Presentations\Indexable_Post_Type_Presentation
 *
 * @group presentations
 * @group canonical
 */
class Canonical_Test extends TestCase {
	use Presentation_Instance_Builder;

	/**
	 * Does the setup for testing.
	 */
	public function setUp() {
		parent::setUp();

		$this->setInstance();
	}

	/**
	 * Tests the situation where the canonical is given.
	 *
	 * @covers ::generate_canonical
	 */
	public function test_with_canonical() {
		$this->indexable->canonical = 'https://example.com/my-post/';

		$this->assertEquals( 'https://example.com/my-post/', $this->instance->generate_canonical() );
	}

	/**
	 * Tests the situation where no canonical is given, and it should fall back to the permalink.
	 *
	 * @covers ::generate_canonical
	 */
	public function test_without_canonical() {
		$this->indexable->object_id = 1337;
		$this->indexable->permalink = 'https://example.com/permalink/';

		$this->current_page_helper
			->expects( 'get_current_post_page' )
			->once()
			->andReturn( 0 );

		$this->url_helper
			->expects( 'ensure_absolute_url' )
			->once()
			->andReturnUsing( function ( $val ) {
				return $val;
			} );

		$this->assertEquals( 'https://example.com/permalink/', $this->instance->generate_canonical() );
	}

	/**
	 * Tests a post with pagination.
	 *
	 * @covers ::generate_canonical
	 */
	public function test_with_pagination() {
		$this->indexable->object_id       = 1337;
		$this->indexable->number_of_pages = 2;
		$this->indexable->permalink       = 'https://example.com/permalink/';

		$this->current_page_helper
			->expects( 'get_current_post_page' )
			->once()
			->andReturn( 2 );

		$this->pagination
			->expects( 'get_paginated_url' )
			->once()
			->andReturn( 'https://example.com/permalink/2/' );

		$this->url_helper
			->expects( 'ensure_absolute_url' )
			->once()
			->andReturnUsing( function ( $val ) {
				return $val;
			} );

		$this->assertEquals( 'https://example.com/permalink/2/', $this->instance->generate_canonical() );
	}
}
