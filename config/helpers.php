<?php

use Carbon\Carbon;
use Bow\Support\Str;
use App\Models\Country;
use App\Models\Podcast;
use App\Models\Question;
use App\Models\Tutorial;
use League\CommonMark\CommonMarkConverter;
use Bow\Database\Collection as DatabaseCollection;

if (! function_exists("markdown")) {
    function markdown($expression)
    {
        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => true,
        ]);

        return $converter->convert($expression);
    }
}

if (! function_exists('now')) {
    /**
     * The Str::slug helper
     */
    function now(): Carbon
    {
        return Carbon::now();
    }
}

if (! function_exists('str_slug')) {
    /**
     * The Str::slug helper
     */
    function str_slug($str): string
    {
        return Str::slugify($str);
    }
}

if (! function_exists('get_preview_url')) {
    /**
     * Get the preview url
     *
     * @return string
     */
    function get_preview_url()
    {
        $url = request()->url();

        $routes = [
            route('index'),
            route('login'),
            route('logout'),
        ];

        if (! in_array($url, $routes)) {
            return 'redirect=' . $url;
        }

        return '';
    }
}

if (! function_exists('get_greeting_by_time')) {
    /**
     * Get the greeting by time
     *
     * @param  string|null  $name
     * @return string
     */
    function get_greeting_by_time($name = null)
    {
        if (is_null($name)) {
            $name = '';
        } else {
            $name = ' ' . $name;
        }

        return (((int) now()->format('H')) > 13 ? 'Bonsoir' : 'Bonjour') . $name;
    }
}

if (! function_exists('get_technologies')) {
    /**
     * Get the available tags
     *
     * @return array
     */
    function get_technologies()
    {
        static $technologies;

        if (is_null($technologies)) {
            $technologies = \App\Models\Technology::where('parent_id', 0)->get();
        }

        return $technologies;
    }
}

if (! function_exists('get_authors')) {
    /**
     * Get the available authors
     *
     * @return DatabaseCollection
     */
    function get_authors(): DatabaseCollection
    {
        static $authors;

        if (is_null($authors)) {
            $authors = \App\Models\Author::all();
        }

        return $authors;
    }
}

if (! function_exists('challenge_in_progress')) {
    /**
     * Get define doamin name
     *
     * @return bool
     */
    function challenge_in_progress(): bool
    {
        $challenge = \App\Models\Challenge::orderBy('diffused_at', 'desc')->first();

        return is_null($challenge) ? false : $challenge->inProgress();
    }
}

if (! function_exists('get_domain')) {
    /**
     * Get define doamin name
     *
     * @return array
     */
    function get_domain()
    {
        return [app_env('FRONTEND_DOMAIN'), app_env('DASHBOARD_DOMAIN')];
    }
}

if (! function_exists('format_date')) {
    /**
     * Format carbon date instance
     *
     * @return object
     */
    function format_date(?Carbon $date = null)
    {
        if (is_null($date)) {
            $date = now();
        }

        return (object) [
            'day' => $date->day,
            'month' => $date->month,
            'year' => $date->year,
            'hour' => $date->hour,
            'munite' => $date->minute,
        ];
    }
}

if (! function_exists('get_latest_comment')) {
    /**
     * Get latest comment
     *
     * @param  mixed  $context
     * @param  int  $take
     * @return DatabaseCollection
     */
    function get_latest_comment($context = null, $take = 5)
    {
        if (is_null($context)) {
            return \App\Models\Comment::take($take)->get();
        }

        return \App\Models\Comment::take($take)
            ->whereIn('commentable_type', [Question::class, Tutorial::class, Podcast::class])->get();
    }
}

if (! function_exists('str_words')) {
    /**
     * Truncate string
     *
     * @param  int  $words
     * @param  string  $end
     * @return string
     */
    function str_words(string $words, int $len = 100, $end = '...')
    {
        $wordParts = explode(' ', $words);

        $sentence = '';

        for ($i = 0; $i < $len; $i++) {
            if (!isset($wordParts[$i])) {
                break;
            }
            $sentence .= ' ' . $wordParts[$i];
        }

        return trim($sentence) . $end;
    }
}

if (! function_exists('str_limit')) {
    /**
     * Truncate string
     *
     * @param  int  $limit
     * @param  string  $end
     */
    function str_limit($value, $limit = 100, $end = '...'): string
    {
        return Str::slice($value, 0, $limit) . $end;
    }
}

if (! function_exists('gravatar')) {
    /**
     * Create a gravatar
     *
     * @param  int  $size
     */
    function gravatar(?string $email = null, $size = 150): string
    {
        if (is_null($email)) {
            $email = 'contact@papac.dev';
        }

        $hash = md5($email);

        return sprintf('https://secure.gravatar.com/avatar/%s?s=%s', $hash, $size);
    }
}

if (! function_exists('get_country_list')) {
    /**
     * Contry list
     *
     * @return array
     */
    function get_country_list(): DatabaseCollection
    {
        $countries = Country::all();

        return $countries;
    }
}

if (! function_exists('gen_unique_id')) {
    /**
     * Generate unique ID
     *
     * @return string
     */
    function gen_unique_id()
    {
        $id = base_convert(microtime(false), 10, 36);

        return $id;
    }
}

if (! function_exists('get_annonces')) {
    /**
     * Get the annonces
     *
     * @return array
     */
    function get_annonces(): DatabaseCollection
    {
        return \App\Models\Annonce::online()
            ->where('type', \App\Models\Annonce::ANNONCE_ADS)
            ->orderBy('ended_at')->get();
    }
}


if (!function_exists('mix')) {
    /**
     * Get mixfile chunkhash version
     *
     * @param string $path
     * @return string
     */
    function mix($path)
    {
        $manifest = config('app.mixfile_path');

        if (! file_exists($manifest)) {
            return $path;
        }

        $content = json_decode(file_get_contents($manifest), true);

        $key = '/' . ltrim($path, '/');

        if (isset($content[$key])) {
            return $content[$key];
        }

        throw new Exception($path . " Not exists");
    }
}

if (!function_exists('public_path')) {
    /**
     * Get public directory
     *
     * @param string $path
     * @return string
     */
    function public_path($path = '')
    {
        return __DIR__ . '/../public/' . ltrim($path, '/');
    }
}

if (!function_exists('frontend_path')) {
    /**
     * Get frontend directory
     *
     * @param string $path
     * @return string
     */
    function frontend_path($path = '')
    {
        return __DIR__ . '/../frontend/' . ltrim($path, '/');
    }
}

if (!function_exists('storage_path')) {
    /**
     * Get storages directory
     *
     * @param string $path
     * @return string
     */
    function storage_path($path = '')
    {
        return __DIR__ . '/../var/' . ltrim($path, '/');
    }
}

if (! function_exists('base_path')) {
    /**
     * Returns the path of the root folder of the bow framework application
     *
     * @return string
     */
    function base_path($path = '')
    {
        return rtrim(rtrim(realpath(__DIR__ . '/..'), '/') . '/' . $path, '/');
    }
}

if (! function_exists('gen_slix')) {
    /**
     * Generate a random code.
     * Can be used to hide the name of form fields.
     *
     * @param int $len
     * @return string
     */
    function gen_slix($len = 4)
    {
        return substr(str_shuffle(uniqid()), 0, $len);
    }
}

if (! function_exists('gen_unique_id')) {
    /**
     * Generate unique ID
     *
     * @return string
     */
    function gen_unique_id()
    {
        $id = base_convert(microtime(false), 10, 36);

        return $id;
    }
}
