<?php

namespace humhub\modules\sharebetween\widgets;

use humhub\modules\content\widgets\stream\WallStreamModuleEntryWidget;

class WallEntry extends WallStreamModuleEntryWidget
{
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
     * @inheritDoc
     */
    protected function getTitle()
    {
        return "Shared";
    }
}