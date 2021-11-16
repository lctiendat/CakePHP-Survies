<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class AdminController extends AppController
{
    /**
     * Static method
     */
    public function index()
    {
        $this->isAdmin();
        $ranking = $this->{'Home'}->ranking();
        $issetRanking = count($this->{'Home'}->ranking()->toArray());
        $category = $this->{'Home'}->countQuality('Categories');
        $survey = $this->{'Home'}->countQuality('Survies');
        $answer = $this->{'Home'}->countQuality('Answers');
        $user = $this->{'Home'}->countQuality('Users');
        $categoryToday = $this->{'Home'}->countQualityToday('Categories');
        $surveyToday = $this->{'Home'}->countQualityToday('Survies');
        $answerToday = $this->{'Home'}->countQualityToday('Answers');
        $userToday = $this->{'Home'}->countQualityToday('Users');
        $this->set(compact(
            [
                'category',
                'survey',
                'answer',
                'user',
                'categoryToday',
                'surveyToday',
                'answerToday',
                'userToday',
                'ranking',
                'issetRanking'
            ]
        ));
    }
}
