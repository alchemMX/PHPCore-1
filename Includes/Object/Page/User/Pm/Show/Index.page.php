<?php

namespace Page\User\Pm\Show;

use Block\Pm;
use Block\Message;

use Model\Pagination;
use Model\Database\Query;

use Visualization\Panel\Panel;
use Visualization\Block\Block;
use Visualization\Sidebar\Sidebar;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Show pm page
 */
class Index extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'id' => int,
        'editor' => EDITOR_BIG,
        'template' => 'User/Pm/Show',
        'loggedIn' => true
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // BLOCK
        $_pm = new Pm();
        $query = new Query();
        $message = new Message();

        // PM DATA
        $pm = $_pm->get($this->getID()) or $this->error();

        // ASSIGN DATA TO TEMPLATE
        $this->data->data([
            'pm_subject' => $pm['pm_subject']
        ]);

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('User/Pm');
        $this->data->breadcrumb = $breadcrumb->getData();

        // PM RECIPIENTS
        $recipients = $_pm->getRecipients($this->getID());

        // IF IS THIS UNREAD PRIVATE MESSAGE
        if (in_array($pm['pm_id'], $unread = $this->user->get('unread')) === true) {
            unset($unread[array_search($pm['pm_id'], $unread)]);
            $this->user->set('unread', $unread);

            $query->query('
                DELETE unr FROM ' . TABLE_USERS_UNREAD . '
                WHERE pm_id = ? AND user_id = ?
            ', [$pm['pm_id'], LOGGED_USER_ID]);
        }

        // GET LAST MESSAGE USER INFO
        $this->data->data['lastMessage'] = $message->getLast($this->getID());
        if (!$this->data->data['lastMessage']) {
            $this->data->data['lastMessage'] = $pm;
        }
        
        // PAGINATION
        $pagination = new Pagination();
        $pagination->max(MAX_MESSAGES);
        $pagination->total($pm['pm_messages']);
        $pagination->url($this->getURL());
        $message->pagination = $this->data->pagination = $pagination->getData();

        // PANEL
        $panel = new Panel('Pm');
        if ($pm['user_id'] == LOGGED_USER_ID) $panel->object('edit')->show();
        $this->data->panel = $panel->getData();

        // BLOCK
        $block = new Block('Pm');
        $block->object('pm')->appTo($pm);
        $block->object('message')->fill($message->getParent($this->getID()));
        $block->object('message')->row('bottom')->show();

        if (PAGE == 1) {
            $block->object('pm')->show();
        }

        $this->data->block = $block->getData();

        // SIDEBAR
        $sidebar = new Sidebar('Pm');
        $sidebar->small();
        $sidebar->object('info')
            ->row('last')->value($this->build->user->link($this->data->data['lastMessage']))
            ->row('messages')->value($pm['pm_messages'])
            ->row('recipients')->value(count($recipients))
            ->object('recipients')->fill($recipients);

        if (count($recipients) >= 10) {
            $sidebar->row('bottom')->hide();
        }

        $this->data->sidebar = $sidebar->getData();

        // LEAVE PRIVATE MESSAGE
        $this->process->call(type: 'Pm/Leave', url: '/user/pm/', data: [
            'pm_id' => $pm['pm_id'],
            'recipients' => array_column($recipients, 'user_id'),
            'options' => [
                'on' => [$this->getOperation() => 'leave']
            ]
        ]);

        // MARK AS UNREAD PRIVATE MESSAGE
        $this->process->call(type: 'Pm/Mark', data: [
            'pm_id' => $pm['pm_id'],
            'options' => [
                'on' => [$this->getOperation() => 'mark']
            ]
        ]);
    
        // HEAD
        $this->data->head = [
            'title'         => $pm['pm_subject'],
            'description'   => $pm['pm_text']
        ];
    }
}