<?php

require_once __DIR__.'/vendor/silex/autoload.php';

$app = new Silex\Application();
$app['debug'] = $_SERVER['REMOTE_ADDR'] == '127.0.0.1';

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
));

$app->get('/view', function () use($app) {
    $id = $app['request']->query->get('id');
    $template = $app['twig']->loadTemplate('mail/mail_'.$id.'.twig');
    $data = array(
        'subject'      => $template->renderBlock('subject', array()),
        'content_text' => $template->renderBlock('body_text', array()),
        'content_html' => $template->renderBlock('body_html', array())
    );
    return $app['twig']->render('page/view_mail.html.twig', $data);
});

$app->run();
