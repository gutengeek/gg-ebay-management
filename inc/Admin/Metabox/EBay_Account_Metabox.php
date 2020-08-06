<?php
namespace GGEM\Admin\Metabox;


use GGEM\Core\Metabox;

class EBay_Account_Metabox extends Metabox {
	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->set_types(
			[
				'ggem_ebay',
			]
		);

		$this->metabox_id    = 'ggem-ebay-metabox-form-data';
		$this->metabox_label = esc_html__( 'Account Settings', 'ggem' );

		add_action( 'add_meta_boxes', [ $this, 'add_side_metaboxes' ] );
		add_action( 'save_post', [ $this, 'save_metaboxes' ] );
	}

	public function add_side_metaboxes() {
		add_meta_box( GGEM_METABOX_PREFIX . 'status-metabox', esc_html__( 'Status', 'ggem' ), [ $this, 'render_status_metabox' ], 'ggem_ebay', 'side', 'high' );
		add_meta_box( GGEM_METABOX_PREFIX . 'note-metabox', esc_html__( 'Note', 'ggem' ), [ $this, 'render_note_metabox' ], 'ggem_ebay', 'side', 'high' );
	}

	public function render_note_metabox( $post ) {
		$note = get_post_meta( $post->ID, GGEM_METABOX_PREFIX . 'note', true );
		?>
        <textarea name="<?php echo GGEM_METABOX_PREFIX . 'note'; ?>" id="<?php echo GGEM_METABOX_PREFIX . 'note'; ?>" cols="30" rows="3"><?php echo $note ? esc_html( $note ) : ''; ?></textarea>
		<?php
	}

	public function render_status_metabox( $post ) {
		$current_status = get_post_status( $post->ID );

		$statuses = ggem_get_account_statuses();
		?>
        <select name="<?php echo GGEM_METABOX_PREFIX . 'status'; ?>" id="<?php echo GGEM_METABOX_PREFIX . 'status'; ?>" style="width: 100%;">
			<?php foreach ( $statuses as $status => $status_label ) : ?>
                <option value="<?php echo esc_attr( $status ); ?>" <?php selected( $status, $current_status, true ); ?>><?php echo esc_html( $status_label ); ?></option>
			<?php endforeach; ?>
        </select>
		<?php
	}

	public function save_metaboxes( $post_id ) {
		if ( ! isset( $_POST['ggem_meta_nonce'] ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['post_type'] ) && 'ggem_ebay' !== $_POST['post_type'] ) {
			return;
		}

		if ( isset( $_POST[ GGEM_METABOX_PREFIX . 'note' ] ) ) {
			update_post_meta( $post_id, GGEM_METABOX_PREFIX . 'note', sanitize_text_field( $_POST[ GGEM_METABOX_PREFIX . 'note' ] ) );
		}

		if ( isset( $_POST[ GGEM_METABOX_PREFIX . 'status' ] ) ) {
			remove_action( 'save_post', [ $this, 'save_metaboxes' ] );

			wp_update_post( [
				'ID'          => $post_id,
				'post_status' => sanitize_text_field( $_POST[ GGEM_METABOX_PREFIX . 'status' ] ),
			] );

			add_action( 'save_post', [ $this, 'save_metaboxes' ] );
		}
	}

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadata of the post and stored in post_meta table
	 *
	 * @param string $post_id The id of current post.
	 * @param string $post    The instance of Post having post typo ggem
	 */
	public function save( $post_id, $post ) {
		// $post_id and $post are required.
		if ( empty( $post_id ) || empty( $post ) ) {
			return;
		}

		// Don't save meta boxes for revisions or autosaves.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check user has permission to edit.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['ggem_meta_nonce'] ) ) {
			$this->save_fields_data( 'post', $post_id );
		}
	}

	/**
	 * Get settings.
	 *
	 * @return array
	 */
	public function get_settings() {
		$prefix = GGEM_METABOX_PREFIX;

		$settings = [
			[
				'name' => esc_html__( 'SKU', 'ggem' ),
				'id'   => $prefix . 'sku',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'Email', 'ggem' ),
				'id'   => $prefix . 'email',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'User ID', 'ggem' ),
				'id'   => $prefix . 'user_id',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'Password', 'ggem' ),
				'id'   => $prefix . 'password',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'First Name', 'ggem' ),
				'id'   => $prefix . 'first_name',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'Last Name', 'ggem' ),
				'id'   => $prefix . 'last_name',
				'type' => 'text',
			],
			[
				'name' => esc_html__( 'Date Registered', 'ggem' ),
				'id'   => $prefix . 'date_registered',
				'type' => 'date',
			],
		];

		return apply_filters( 'ggem_ebay_fields_options', $settings );
	}
}
