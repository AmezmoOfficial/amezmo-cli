<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;

it('displays a single instance', function () {
    Http::fake([
        '*' => Http::response(
            body: fixture('amezmo/instance'),
        )
    ]);

    $this
        ->artisan(command: 'instances:create')
        ->expectsChoice(
            question: 'What runtime do you want to use?',
            answer  : 'php',
            answers : ['php', 'mysql'],
        )->expectsChoice(
            question: 'Which instance type do you want to use?',
            answer  : 'hobby',
            answers : ['hobby', 'developer', 'business'],
        )->expectsChoice(
            question: 'Which region do you want to use?',
            answer  : 'uk3-uk',
            answers : ['lb2-us', 'au2-au', 'uk3-uk', 'ca-ca'],
        )->expectsQuestion(
            question: 'What name do you want to use?',
            answer: 'test',
        )->expectsQuestion(
            question: 'What domain do you want to use?',
            answer: 'test.com',
        )->expectsQuestion(
            question: 'Which PHP version do you want to use?',
            answer: '8.1',
        )->expectsChoice(
            question: 'Which composer version do you want to use?',
            answer  : '2',
            answers : ['default', '1', '2'],
        )->expectsChoice(
            question: 'Which MySQL version do you want to use?',
            answer  : '8',
            answers : ['none', '5.7', '8'],
        )->expectsConfirmation(
            question: 'Do you want to enable MySQL?',
            answer: 'Yes',
        )->expectsQuestion(
            question: 'What name do you want to give your database?',
            answer: 'test',
        )->expectsQuestion(
            question: 'What user do you want to create for this database?',
            answer: 'test',
        )->expectsQuestion(
            question: 'What password fo you want to use?',
            answer: 'test',
        )->expectsOutputToContain(
            string: 'Requesting new Instance to be created now.'
        );
});
