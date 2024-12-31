<?php

namespace App\Services;

use App\Models\Curriculum;

class CurriculumService
{
    /**
     * The Curriculum instance
     *
     * @var Curriculum
     */
    private $curriculum;

    /**
     * CurriculumController constructor
     */
    public function __construct(Curriculum $curriculum)
    {
        $this->curriculum = $curriculum;
    }

    /**
     * Get curriculum pagination
     *
     * @return array
     */
    public function getCurriculumPagination(?string $url = null)
    {
        $curriculums = $this->curriculum->where('published', true)->get();

        return $curriculums;
    }

    /**
     * Get curriculum single
     *
     * @return array
     */
    public function getCurriculum(string $slug)
    {
        $curriculum = $this->curriculum
            ->where('published', true)
            ->where('slug', $slug)->first();

        $is_curriculum = true;

        return compact('curriculum', 'is_curriculum');
    }
}
