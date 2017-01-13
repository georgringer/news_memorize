<?php

namespace GeorgRinger\NewsMemorize\Controller;

class NewsController extends \GeorgRinger\News\Controller\NewsController {

    /**
     * Output a list view of news
     */
    public function memorizeListAction()
    {
        $demand = $this->createDemandObjectFromSettings($this->settings);
        $demand->setActionAndClass(__METHOD__, __CLASS__);

        $newsRecords = $this->newsRepository->findDemanded($demand);

        $assignedValues = [
            'news' => $newsRecords,
            'demand' => $demand,
        ];

        $this->view->assignMultiple($assignedValues);
    }
}