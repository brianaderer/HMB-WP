<?php

class PostSaveHook{
    public static array $lookups = array(
        'review' => array(
            '/reviews'
        ),
        'hero' => array(
            '/',
        ),
        'guest-book-entry' => array(
            '/guest-book'
        ),
        'attractions' => array(
            '/attractions'
        )
    );
    private static array $routes = array(
    );
    public static ?PostSaveHook $instance = null;
    private static string $endpoint;

    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public static function handle_attachment_updated($post_id): void
    {
        // Ensure it's an attachment post type
        self::$routes[] = '/gallery';
        self::$routes[] = '/';
        self::checkout();
    }

    private static function init(): void {
        add_action( 'save_post', [self::$instance, 'hmb_post_save'], 10, 3 );
        add_action('attachment_updated', [self::$instance, 'handle_attachment_updated'], 10, 3);
        add_action('add_attachment', [self::$instance, 'handle_attachment_updated'], 10, 3);
        self::$endpoint = self::get_faust_frontend_uri() . '/api/revalidate';
    }

    private static function get_faust_frontend_uri() {
        // Option key used by the Faust.js plugin to store the frontend URI
        $frontend_data = maybe_unserialize( get_option('faustwp_settings', '') );
        $frontend_uri = $frontend_data['frontend_uri'];

        if (empty($frontend_uri)) {
            // Handle case where the URI is not set
            return 'Frontend URI not configured';
        }

        return $frontend_uri;
    }

    /**
     * @throws Exception
     */
    public static function checkout():void{
        foreach (self::$routes as $route):
            $response = self::sendRevalidationRequest($route);
        endforeach;
        self::$routes = [];
    }

    public static function sendRevalidationRequest(string $path = '/') {
        $data = [
            'secret' => $_ENV['REVALIDATION_KEY'],
            'path' => $path,
        ];

        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, self::$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Execute the request
        $response = curl_exec($ch);
        // Check for errors
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL Error: $error");
        }

        // Get the HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Handle non-200 responses
        if ($httpCode !== 200) {
            throw new Exception("HTTP Error: $httpCode, Response: $response");
        }

        return json_decode($response, true);
    }

    public static function get_instance(): PostSaveHook{
        if( self::$instance === null ):
            self::$instance = new PostSaveHook();
            self::init();
        endif;
        return self::$instance;
    }

    /**
     * @throws Exception
     */
    public static function hmb_post_save($post_id, $post, $update ): void
    {
        /** @var WP_Post $post */

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        if( $post -> post_type === 'page' ):
            $permalink = get_permalink( $post );
            $relative_permalink = wp_make_link_relative( $permalink );
            self::$routes[] = $relative_permalink;
        else:
                try{
                    foreach ( self::$lookups[ $post -> post_type] as $route ):
                        self::$routes[] = $route;
                    endforeach;
                } catch (Exception $e){
                    logger('something went wrong with the isr function ' . $post -> post_type);
                }
        endif;
        self::checkout();
    }
}
$instance = PostSaveHook::get_instance();

