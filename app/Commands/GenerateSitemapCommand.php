<?php

namespace App\Commands;

use Bow\Console\Command\AbstractCommand;
use App\Models\Challenge;
use App\Models\Curriculum;
use App\Models\Question;
use App\Models\Technology;
use App\Models\Tutorial;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemapCommand extends AbstractCommand
{
    /**
     * Sitemap instance
     *
     * @var Sitemap
     */
    private $sitemap;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sitemap = Sitemap::create();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function process()
    {
        $this->generateBaseSitemap();
        $this->generateForumSitemap();
        $this->generatePodcastSitemap();
        $this->generateForumQuestionSitemap();
        $this->generateTechnologySitemap();
        $this->generateTutorialSitemap();
        $this->generateChallengeSitemap();
        $this->generateCurriculumSitemap();

        SitemapIndex::create()
            ->add('/base_sitemap.xml')
            ->add('/forum_sitemap.xml')
            ->add('/podcast_sitemap.xml')
            // ->add('/challenge_sitemap.xml')
            // ->add('/tag_sitemap.xml')
            ->add('/question_sitemap.xml')
            ->add('/technologie_sitemap.xml')
            ->add('/tutorial_sitemap.xml')
            ->add('/curriculum_sitemap.xml')
            ->writeToFile(public_path('sitemap.xml'));
    }

    /**
     * Generate the site for all available tag
     *
     * @return void
     */
    private function generatePodcastSitemap()
    {
        $this->sitemap = Sitemap::create();

        $podcasts = \App\Models\Podcast::where('status', 1)->get();

        foreach ($podcasts as $podcast) {
            $route = route('podcast.single', ['slug' => $podcast->slug, 'podcast' => $podcast->id]);

            $this->sitemap->add($this->buildUrl($route, 0.1));
        }

        $this->sitemap->writeToFile(public_path('podcast_sitemap.xml'));
    }

    /**
     * Generate the site for all available tutorials
     *
     * @return void
     */
    private function generateTechnologySitemap()
    {
        $this->sitemap = Sitemap::create();

        $technologies = Technology::all();

        foreach ($technologies as $technologie) {
            $route = route(
                'technologie.index',
                [
                    'technologie' => $technologie->slug,
                ]
            );

            $url = $this->buildUrl($route, 0.1);
            $this->sitemap->add($url);
        }

        $this->sitemap->writeToFile(public_path('technologie_sitemap.xml'));
    }

    /**
     * Generate the site for all available tutorials
     *
     * @return void
     */
    private function generateCurriculumSitemap()
    {
        $this->sitemap = Sitemap::create();

        $curriculums = Curriculum::where('published', 1)->get();

        foreach ($curriculums as $curriculum) {
            $route = route('curriculum.single', [ 'slug' => $curriculum->slug,]);

            $this->sitemap->add($url = $this->buildUrl($route, 0.1));
        }

        $this->sitemap->writeToFile(public_path('curriculum_sitemap.xml'));
    }

    /**
     * Generate the site for all available challenges
     *
     * @return void
     */
    private function generateForumSitemap()
    {
        $this->sitemap = Sitemap::create();

        $forums = Technology::where('with_forum', 1)->get();

        foreach ($forums as $forum) {
            $route = route(
                'forum.single',
                [
                'slug' => $forum->slug,
                'id' => $forum->id,
                'type' => 'technologie',
                ]
            );

            $url = $this->buildUrl($route, 0.1);
            $this->sitemap->add($url);
        }

        $forums = Curriculum::where('with_forum', 1)->get();

        foreach ($forums as $forum) {
            $route = route(
                'forum.single',
                [
                'slug' => $forum->slug,
                'id' => $forum->id,
                'type' => 'curriculum',
                ]
            );

            $url = $this->buildUrl($route, 0.1);
            $this->sitemap->add($url);
        }

        $this->sitemap->writeToFile(public_path('forum_sitemap.xml'));
    }

    /**
     * Generate the site for all available Forum Question
     *
     * @return void
     */
    private function generateForumQuestionSitemap()
    {
        $this->sitemap = Sitemap::create();
        $questions = Question::all();

        foreach ($questions as $question) {
            $route = route('forum.question', ['slug' => str_slug($question->slug), 'id' => $question->id]);
            $url = $this->buildUrl($route, 0.1);
            $this->sitemap->add($url);
        }

        $this->sitemap->writeToFile(public_path('question_sitemap.xml'));
    }

    /**
     * Generate the site for all available challenges
     *
     * @return void
     */
    private function generateChallengeSitemap()
    {
        $this->sitemap = Sitemap::create();

        $challenges = Challenge::whereDiffused(true)->get();

        foreach ($challenges as $challenge) {
            $route = route(
                'challenge.single',
                [
                'slug' => $challenge->slug,
                'id' => $challenge->id,
                ]
            );
            $url = $this->buildUrl($route, 0.1);
            $this->sitemap->add($url);
        }

        $this->sitemap->writeToFile(public_path('challenge_sitemap.xml'));
    }

    /**
     * Generate the site for all available tutorials
     *
     * @return void
     */
    private function generateTutorialSitemap()
    {
        $tutorials = Tutorial::where('published', true)->get();

        $this->sitemap = Sitemap::create();

        foreach ($tutorials as $tutorial) {
            $route = route(
                'tutorial.reader',
                [
                'slug' => $tutorial->slug,
                'id' => $tutorial->id,
                ]
            );
            $url = $this->buildUrl($route, 0.1, Carbon::now());
            $this->sitemap->add($url);
        }

        $this->sitemap->writeToFile(public_path('tutorial_sitemap.xml'));
    }

    /**
     * Generate the base route sitemap
     *
     * @return void
     */
    private function generateBaseSitemap()
    {
        $this->sitemap = Sitemap::create();

        $routes = [
            route('index'),
            route('tutorial'),
            route('terms'),
            route('about'),
            route('login'),
            route('search.index'),
            // route('password.email'),
            route('curriculum'),
            route('forum'),
            // route('pricing'),
            route('podcast'),
            route('donate'),
            // route('support.markdown'),
        ];

        foreach ($routes as $route) {
            $url = $this->buildUrl($route, 0.9);
            $this->sitemap->add($url);
        }

        $this->sitemap->writeToFile(public_path('base_sitemap.xml'));
    }

    /**
     * Build the sitemap url
     *
     * @param  string $route
     * @param  float  $priority
     * @param  mixed  $date
     * @return mixed
     */
    private function buildUrl($route, $priority = 0.1, $date = null)
    {
        if (is_null($date)) {
            $date = Carbon::yesterday();
        }

        $url = Url::create($route)
            ->setLastModificationDate($date)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority($priority);

        return $url;
    }
}
