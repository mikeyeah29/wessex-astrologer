<?php

class WA_AdminMenu
{
    private $title;
    private $menu_title;
    private $permissions = 'manage_options';
    private $slug = 'wa-settings';
    private $callback;

    public function admin_menu_view()
    {
        $message = '';
        $error = false;

        if (isset($_POST['wa_options'])) {

            WA_Options::update('wes_astr_contact', [
                'ADDRESS' => ( isset($_POST['wa-address']) ? $_POST['wa-address'] : '' ),
                'PHONE_UK' => ( isset($_POST['wa-phone-uk']) ? $_POST['wa-phone-uk'] : '' ),
                'PHONE_INTERNATIONAL' => ( isset($_POST['wa-phone-international']) ? $_POST['wa-phone-international'] : '' ),
                'EMAIL' => ( isset($_POST['wa-email']) ? $_POST['wa-email'] : '' )
            ]);

            $message = 'options updated';
        }

        $options = WA_Options::get('wes_astr_contact');

        $page = (isset($_GET['page']) ? $_GET['page'] : '');

        include_once( plugin_dir_path( __FILE__ ) . '../admin/views/settings.php' );
    }

    public function submenu_edit_footer_view()
    {
        $message = '';
        $error = false;

        if (isset($_POST['wa_footer_about'])) {
            WA_Options::update('wes_astr_footer_about', $_POST['wa_footer_about_text']);
            $message = 'about updated';
        }

        $footer_about = WA_Content::getFooterAbout();

        $page = (isset($_GET['page']) ? $_GET['page'] : '');
        include_once( plugin_dir_path( __FILE__ ) . '../admin/views/edit-footer.php' );
    }

    public function admin_menu()
    {
        add_menu_page(
            'General', // title
            'Wessex Astrologer', // menu title
            $this->permissions, // permissions
            $this->slug, // slug
            array($this, 'admin_menu_view'), // callback
            'dashicons-book-alt', // dash icon
            4 // position
        );
        add_submenu_page(
            $this->slug, // parent slug
            'Edit Footer', // title
            'Edit Footer', // menu title
            $this->permissions,
            'wa-footer', // slugw
            array($this, 'submenu_edit_footer_view')
        );
    }

    public function __construct()
    {
        add_action('admin_menu', array($this, 'admin_menu'));
    }
}

?>
