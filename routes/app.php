<?php

$app->get('/', 'Generic\LandingController')
    ->name('index');

$app->get('/ajax/tutorials', 'Api\TutorialController');
$app->get('/ajax/tutorials/:id', 'Api\TutorialController@show');

$app->get('pricing', 'PricingController')
    ->name('pricing');

$app->get('products/{product}/subscribe', 'PaymentController@showProduct')
    ->name('product.subscribe')
    ->middleware('auth');

$app->post('products/{product}/subscribe', 'PaymentController@subscribe')
    ->name('product.subscribe')
    ->middleware('auth');

$app->get('donation', 'PaymentController@showDonate')
    ->name('donate');

$app->post('donation', 'PaymentController@donate')
    ->name('donate');

$app->post('payments', 'PaymentController@payment')
    ->name('payment.initialize');

$app->get('payments/{type}/:slug-:id', 'PaymentController@showPayment')
    ->name('payment.element')
    ->middleware('auth')
    ->where(['id' => '\d+', 'slug' => '[a-z0-9_-]+']);

$app->post('payments/{transaction}/confirmation', 'PaymentController@paymentConfirmation')
    ->name('payment.confirmation');

$app->match(['GET', 'POST'], 'payments/{transaction}/congratulation', 'PaymentController@paymentStatus')
    ->name('payment.congratulation');

$app->get('payments/{transaction}/congratulation', 'PaymentController@paymentStatus')
    ->name('payment.congratulation');

$app->post('payments/{transaction}/congratulation', 'PaymentController@paymentStatus')
    ->name('payment.congratulation');

$app->get('terms', 'Generic\SupportController@showTerms')
    ->name('terms');

$app->get('cgu', 'Generic\SupportController@showTerms')
    ->name('terms');

$app->get('about', 'Generic\SupportController@showAbout')
    ->name('about');

$app->post('support/accept_cookie', 'SupportController@acceptCookieContracts')
    ->name('support.accept-cookie');

$app->post('support/upload_static_file', 'SupportController@uploadStaticFile')
    ->name('support.upload_static_file');

$app->post('support/newsletter', 'SupportController@addNewsletter')
    ->name('support.newsletter');

$app->get('search', 'SearchController')
    ->name('search.index');

$app->post('bookmark/:id', 'BookmarkController@bookmark')
    ->name('bookmark')
    ->where(['id' => '\d+']);

$app->post('bookmark/delete', 'BookmarkController@remove')
    ->name('bookmark.delete');

$app->post('{type}/:id/comment', 'CommentController@create')
    ->name('comment.make')
    ->middleware('auth')
    ->where(['id' => '\d+']);

$app->get('{type}/:id/comment', 'CommentController@show')
    ->name('comment.show')
    ->where(['id' => '\d+']);

// User profil setting
$app->get('profil', 'UserController')->name('user.setting');
$app->post('profil/theme', 'UserController@patchTheme')->name('user.setting.theme');
$app->post('profil', 'UserController@updateInformation')->name('user.update');
$app->get('favoris', 'UserController@showBookmark')->name('user.bookmark');
$app->get('notifications', 'UserController@showNotification')->name('user.notification');
$app->get('transactions', 'UserController@showTransaction')->name('user.transaction');
$app->get('transactions/{transaction}/invoice', 'UserController@showTransactionInvoice')->name('user.transaction.invoice');
$app->post('notifications/delete', 'UserController@deleteNotifications')->name('user.notification.delete');
$app->post('notifications/read', 'UserController@readNotifications')->name('user.notification.read');

// Auth routing
$app->get('auth', 'Auth\LoginController@showLoginForm')
    ->name('login');

$app->post('auth', 'Auth\LoginController@login');

$app->prefix('verification', function () use ($app) {
    $app->get('email', 'VerificationController@show')->name('verification.info');
    $app->get('re-envoyer', 'VerificationController@resend')->name('verification.resend');
    $app->get(':id/verifier', 'VerificationController@verify')->name('verification.verify');
});

$app->get('register', 'RegisterController@showRegistrationForm')
    ->name('register');

$app->get('auth/{provider}', 'SocialiteController@provider')
    ->name('soauth');

$app->get('auth/{provider}/redirect', 'SocialiteController@process')
    ->name('soauth.redirect');

$app->get('auth/{provider}/cancel', 'SocialiteController@cancel')
    ->name('soauth.cancel');

$app->post('logout', 'LoginController@logout')
    ->name('logout')
    ->middleware('auth');

// Forum routing
$app->prefix('communities', function ()use ($app) {
    $app->get('/', 'Form\ForumController')
        ->name('forum');

    $app->get('/new-question', 'Form\ForumController@showWriterForm')
        ->middleware('auth')
        ->name('forum.writer');

    $app->post('/new-question', 'Form\ForumController@createQuestion')
        ->middleware('auth')
        ->name('forum.writer');

    $app->post('curriculums/:id/new-question', 'Form\ForumController@createQuestion')
        ->where(['id' => '[\d]+'])
        ->middleware('auth')
        ->name('forum.curriculum.writer');

    $app->get(':slug-:id/questions', 'Form\ForumController@showCurriculum')
        ->where(['id' => '[\d]+', 'slug' => "[\d\w_-]+"])
        ->name('forum.single');

    $app->get(':slug-:id', 'Form\QuestionController')
        ->where(['slug' => '[a-z_-]+', 'id' => '[0-9]+'])
        ->name('forum.question');

    $app->post('question/delete', 'Form\QuestionController@deleteQuestion')
        ->name('forum.question.delete');

    $app->get(':slug-:id/update-question', 'Form\QuestionController@showUpdateQuestion')
        ->middleware('auth')
        ->where(['slug' => '[a-z_-]+', 'id' => '[0-9]+'])
        ->name('forum.question.update');

    $app->post(':slug-:id/update-question', 'Form\QuestionController@updateQuestion')
        ->middleware('auth')
        ->where(['slug' => '[a-z_-]+', 'id' => '[0-9]+'])
        ->name('forum.question.update');

    $app->post('question-:id/response', 'Form\QuestionController@createResponse')
        ->where(['id' => '[\w]+'])
        ->middleware('auth')
        ->name('forum.question.response');
});

// The route which show the tutorial
$app->get('tutoriels', 'Tutorial\TutorialController')
    ->name('tutorial');

$app->get(':slug-:id', 'Tutorial\TutorialController@showTutorial')
    ->name('tutorial.reader')
    ->where(['id' => '\d+', 'slug' => '[a-z0-9_-]+']);

$app->post(':id/progress', 'Tutorial\TutorialController@confirmProgrestion')
    ->name('tutorial.progress')
    ->where(['id' => '\d+']);

$app->get('formations', 'Tutorial\CurriculumController')
    ->name('curriculum');

$app->get('formations/:slug', 'Tutorial\CurriculumController@show')
    ->name('curriculum.single');

$app->get('challenges', 'Tutorial\ChallengeController')
    ->name('challenge');

$app->get('challenges/:slug-{challenge}', 'Tutorial\ChallengeController@show')
    ->name('challenge.single')
    ->where(['challenge' => '\d+', 'slug' => '[a-z_-]+']);

$app->get('challenges/:slug-{challenge}/direct', 'Tutorial\ChallengeController@showDirect')
    ->middleware('auth')
    ->where(['challenge' => '\d+', 'slug' => '[a-z_-]+'])
    ->name('challenge.direct');

$app->get('podcasts', 'Tutorial\PodcastController')
    ->name('podcast');

$app->get('podcasts/:slug-{podcast}', 'Tutorial\PodcastController@showPodcast')
    ->name('podcast.single')
    ->where(['podcast' => '\d+', 'slug' => '[a-z0-9_-]+']);

$app->get('{technologie}', 'Tutorial\TechnologieController')
    ->name('technologie.index');
