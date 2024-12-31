<?php

use App\Models\Question;
use Faker\Factory;

$faker = Factory::create();

$content = <<<'EOF'
Next, your user table must contain an email_verified_at column to store the date and time that the email address was verified. By default, the users table migration included with the Laravel framework already includes this column. So, all you need to do is run your database migrations:

- Support Standard Markdown / CommonMark and GFM(GitHub Flavored Markdown);
- Full-featured: Real-time Preview, Image (cross-domain) upload, Preformatted text/Code blocks/Tables insert, Code fold, Search replace, Read only, Themes, Multi-languages, L18n, HTML entities, Code syntax highlighting...;
- Markdown Extras : Support ToC (Table of Contents), Emoji, Task lists, @Links...;
- Compatible with all major browsers (IE8+), compatible Zepto.js and iPad;
- Support identification, interpretation, fliter of the HTML tags;
- Support TeX (LaTeX expressions, Based on KaTeX), Flowchart and Sequence Diagram of Markdown extended syntax;
- Support AMD/CMD (Require.js & Sea.js) Module Loader, and Custom/define editor plugins;

```php
/**
 * Show tutorial list
 *
 * @param Request $request
 * @return mixed
 */
public function __invoke(Request $request)
{
    $technologie = $request->get('technologie');

    if (is_null($technologie)) {
        $tutorials = $this->tutorial
            ->orderBy('created_at', 'desc')
            ->where('published', 1)
            ->paginate(static::PER_PAGE);
    } else {
        $tutorials = $this->technologie
            ->findBy('slug', $technologie)
            ->tutorials()->paginate(static::PER_PAGE);
    }

    $tutorials->withPath($request->url());

    return view('tutorial.index', compact('tutorials'));
}
```
EOF;

$question = [
    'title' => $faker->text(50),
    'content' => $content,
    'user_id' => [1, 2][rand(0, 1)],
    'slug' => $faker->slug,
    'curriculum_id' => [1, 0][rand(0, 1)],
];

return [Question::class => $question];
