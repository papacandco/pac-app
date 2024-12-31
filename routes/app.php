<?php

$app->get('/', 'Generic\LandingController')
    ->name('index');

$app->get('ajax/tutorials', 'Api\TutorialController');
$app->get('ajax/tutorials/:id', 'Api\TutorialController::show');

$app->get('pricing', 'PricingController')
    ->name('pricing');

$app->get('products/:product/subscribe', 'PaymentController::showProduct')
    ->name('product.subscribe')
    ->middleware('auth');

$app->post('products/:product/subscribe', 'PaymentController::subscribe')
    ->name('product.subscribe')
    ->middleware('auth');

$app->get('donation', 'PaymentController::showDonate')
    ->middleware('auth')
    ->name('donate');

$app->post('donation', 'PaymentController::donate')
    ->middleware('auth')
    ->name('donate');

$app->post('payments', 'PaymentController::payment')
    ->middleware('auth')
    ->name('payment.initialize');

$app->get('payments/:type/:slug-:id', 'PaymentController::showPayment')
    ->name('payment.element')
    ->middleware('auth')
    ->where(['id' => '\d+', 'slug' => '[a-z0-9_-]+']);

$app->post('payments/:transaction/confirmation', 'PaymentController::paymentConfirmation')
    ->name('payment.confirmation');

$app->match(['GET', 'POST'], 'payments/:transaction/congratulation', 'PaymentController::paymentStatus')
    ->name('payment.congratulation');

$app->get('payments/:transaction/congratulation', 'PaymentController::paymentStatus')
    ->name('payment.congratulation');

$app->post('payments/:transaction/congratulation', 'PaymentController::paymentStatus')
    ->name('payment.congratulation');

$app->get('terms', 'Generic\SupportController::showTerms')
    ->name('terms');

$app->get('cgu', 'Generic\SupportController::showTerms')
    ->name('terms');

$app->get('about', 'Generic\SupportController::showAbout')
    ->name('about');

$app->post('support/accept_cookie', 'Generic\SupportController::acceptCookieContracts')
    ->name('support.accept-cookie');

$app->post('support/upload_static_file', 'Generic\SupportController::uploadStaticFile')
    ->name('support.upload_static_file');

$app->post('support/newsletter', 'Generic\SupportController::addNewsletter')
    ->name('support.newsletter');

$app->get('search', 'Generic\SearchController')
    ->name('search.index');

$app->post('bookmark/:id', 'Generic\BookmarkController::bookmark')
    ->name('bookmark')
    ->where(['id' => '\d+']);

$app->post('bookmark/delete', 'Generic\BookmarkController::remove')
    ->name('bookmark.delete');

$app->post('/:type/:id/comment', 'Generic\CommentController::create')
    ->name('comment.make')
    ->middleware('auth')
    ->where(['id' => '\d+', 'type' => 'tutorial|podcast|question']);

$app->get('/:type/:id/comment', 'Generic\CommentController::show')
    ->name('comment.show')
    ->where(['id' => '\d+', 'type' => 'tutorial|podcast|question']);

// User profil setting
$app->get('profil', 'UserController')->name('user.setting');
$app->post('profil/theme', 'UserController::patchTheme')->name('user.setting.theme');
$app->post('profil', 'UserController::updateInformation')->name('user.update');
$app->get('favoris', 'UserController::showBookmark')->name('user.bookmark');
$app->get('notifications', 'UserController::showNotification')->name('user.notification');
$app->get('transactions', 'UserController::showTransaction')->name('user.transaction');
$app->get('transactions/:id/invoice', 'UserController::showTransactionInvoice')->name('user.transaction.invoice');
$app->post('notifications/delete', 'UserController::deleteNotifications')->name('user.notification.delete');
$app->post('notifications/read', 'UserController::readNotifications')->name('user.notification.read');

// Auth routing
$app->get('auth', 'SoauthController::showLoginForm')
    ->name('login');

$app->get('auth/:provider', 'SoauthController::provider')
    ->name('soauth');

$app->get('auth/:provider/redirect', 'SoauthController::process')
    ->name('soauth.redirect');

$app->get('auth/:provider/cancel', 'SoauthController::cancel')
    ->name('soauth.cancel');

$app->post('logout', 'SoauthController::logout')
    ->name('logout')
    ->middleware('auth');

// Forum routing
$app->get('communities', 'Forum\ForumController')
    ->name('forum');

$app->get('communities/new-question', 'Forum\ForumController::showWriterForm')
    ->middleware('auth')
    ->name('forum.writer');

$app->post('communities/new-question', 'Forum\ForumController::createQuestion')
    ->middleware('auth')
    ->name('forum.writer');

$app->post('communities/curriculums/:id/new-question', 'Forum\ForumController::createQuestion')
    ->where(['id' => '[\d]+'])
    ->middleware('auth')
    ->name('forum.curriculum.writer');

$app->get('communities/:slug-:id/questions', 'Forum\ForumController::showCurriculum')
    ->where(['id' => '[\d]+', 'slug' => "[\d\w_-]+"])
    ->name('forum.single');

$app->get('communities/:slug-:id', 'Forum\QuestionController')
    ->where(['slug' => '[a-z0-9_-]+', 'id' => '[0-9]+'])
    ->name('forum.question');

$app->post('communities/question/delete', 'Forum\QuestionController::deleteQuestion')
    ->name('forum.question.delete');

$app->get('communities/:slug-:id/update-question', 'Forum\QuestionController::showUpdateQuestion')
    ->middleware('auth')
    ->where(['slug' => '[a-z0-9_-]+', 'id' => '[0-9]+'])
    ->name('forum.question.update');

$app->post('communities/:slug-:id/update-question', 'Forum\QuestionController::updateQuestion')
    ->middleware('auth')
    ->where(['slug' => '[a-z0-9_-]+', 'id' => '[0-9]+'])
    ->name('forum.question.update');

$app->post('communities/question-:id/response', 'Forum\QuestionController::createResponse')
    ->where(['id' => '[\w]+'])
    ->middleware('auth')
    ->name('forum.question.response');

// The route which show the tutorial
$app->get('tutoriels', 'Tutorial\TutorialController')
    ->name('tutorial');

$app->get('/:slug-:id', 'Tutorial\TutorialController::showTutorial')
    ->name('tutorial.reader')
    ->where(['id' => '\d+', 'slug' => '[a-z0-9_-]+']);

$app->post('/:id/progress', 'Tutorial\TutorialController::confirmProgrestion')
    ->name('tutorial.progress')
    ->where(['id' => '\d+']);

$app->get('formations', 'Tutorial\CurriculumController')
    ->name('curriculum');

$app->get('formations/:slug', 'Tutorial\CurriculumController::show')
    ->name('curriculum.single');

$app->get('challenges', 'Tutorial\ChallengeController')
    ->name('challenge');

$app->get('challenges/:slug-:id', 'Tutorial\ChallengeController::show')
    ->name('challenge.single')
    ->where(['id' => '\d+', 'slug' => '[a-z0-9_-]+']);

$app->get('challenges/:slug-:id/direct', 'Tutorial\ChallengeController::showDirect')
    ->middleware('auth')
    ->where(['id' => '\d+', 'slug' => '[a-z0-9_-]+'])
    ->name('challenge.direct');

$app->get('podcasts', 'Tutorial\PodcastController')
    ->name('podcast');

$app->get('podcasts/:slug-:id', 'Tutorial\PodcastController::showPodcast')
    ->name('podcast.single')
    ->where(['id' => '\d+', 'slug' => '[a-z0-9_-]+']);

$app->get(':technologie', 'Tutorial\TechnologyController')
    ->name('technologie.index');
