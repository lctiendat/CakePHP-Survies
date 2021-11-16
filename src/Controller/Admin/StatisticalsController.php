<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class StatisticalsController extends AppController
{
    /**
     * Static survey method
     */
    public function survey($id)
    {
        $this->isAdmin();
        $errorPage = $this->{'Home'}->checkIdIsset($id, 'Survies');
        $checkIssetStatic = $this->{'Statistical'}->checkIssetStatic($id)->toArray();
        $issetId = '';
        foreach ($checkIssetStatic as $item) {
            $issetId = $item->count;
        }
        if (count($errorPage) == 0) {
            return $this->redirect(URL_404_PAGE_ADMIN);
        }
        if ($issetId == NULL) {
            return $this->redirect(URL_404_PAGE_ADMIN);
        }
        $survey = $this->{'Survey'}->getSurveyById($id);
        $result = $this->{'Statistical'}->countAnswerBySurvey($id);
        $countEachAnswerBySurvey =  $this->{'Statistical'}->countEachAnswerBySurvey($id);
        $getAnswerBySurveyId = $this->{'Answer'}->getAnswerBySurveyId($id);
        $this->set(compact(['result', 'survey', 'countEachAnswerBySurvey', 'getAnswerBySurveyId']));
    }
}
