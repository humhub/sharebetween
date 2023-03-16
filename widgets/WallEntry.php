<?php

namespace humhub\modules\sharebetween\widgets;

use humhub\modules\content\widgets\stream\WallStreamModuleEntryWidget;

class WallEntry extends WallStreamModuleEntryWidget
{
    /**
     * @inheritdoc
     */
    public $layoutBody = 'wallEntryBodyLayout';

    /**
     * @inheritdoc
     */
    public $layoutHeader = 'wallEntryHeader';

    /**
     * @inheritdoc
     */
    public function renderContent()
    {
        return $this->render('wall-entry',
            [
                'share' => $this->model,
                'user' => $this->model->content->createdBy,
                'contentContainer' => $this->model->content->container
            ]
        );
    }

    /**
     * @inheritdoc
     */
    protected function renderHeadImage()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    protected function renderFooter()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return '';
    }
}