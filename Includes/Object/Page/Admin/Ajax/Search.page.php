<?php

namespace Page\Admin\Ajax;

use Visualization\Field\Field;

/**
 * Search
 */
class Search extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'loggedIn' => true,
        'permission' => 'admin.settings'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        $API = json_decode(@file_get_contents('https://api.github.com/repos/Infin48/PHPCore/releases', false, CONTEXT), true);

        if (($API[0] ?? false) and $API[0]['tag_name'] != $this->system->settings->get('site.version')) {
            
            $field = new Field('Admin/Update');
            $field->data($API[0]);
            $field->object('available')->show();

            $field->data(array_merge($API[0], [
                'pre-release' => $this->language->get($API[0]['prerelease'] == 1 ? 'L_UPDATE_TYPE_PRERELEASE' : 'L_UPDATE_TYPE_STABLE')
            ]));

            $field->object('available')->row('details')->setData('href', '$' . $API[0]['html_url']);
            $this->data->field = $field->getData();

            $this->data->data([
                'status' => 'ok',
                'content' => $this->file('/Blocks/Field/Field.phtml')
            ]);
        } else {

            $field = new Field('Admin/Update');
            $field->object('empty')->show();
            $this->data->field = $field->getData();

            $this->data->data([
                'status' => 'ok',
                'content' => $this->file('/Blocks/Field/Field.phtml')
            ]);
        }
    }
}