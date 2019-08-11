<?php
namespace Mageglob\Customerstatus\Controller\Manage;
 
 class Index extends \Mageglob\Customerstatus\Controller\Manage
{
    /**
     * Managing Customer status page
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
