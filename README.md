<p align="center">
<img src="https://user-images.githubusercontent.com/51158042/132866397-5f187b7d-5d56-46aa-877c-bee24ac333d8.png">
</p>

# DevMakerLab/My-Mine

Want to track and analyze your Redmine tickets/projects, 

* [Installation](#installation)
* [Examples](#examples)

## Installation
<small>⚠️ Requires >= PHP 7.4 ⚠️</small>
```shell
composer require devmakerlab/my-mine
```

## Examples

```php
<?php
    // This retrieve all tickets created since 2020
    $monthOldTickets = $ticketService->inRange(Carbon::parse('2020-01-01 00:00:00'), Carbon::now())->get();

    // This retrieve all tickets containing the word 'urgent' in the subject.
    $urgentTickets = $ticketService->addFilter('subject', '~urgent')->get();

    // This retrieve all tickets created by a specific author id.
    $johnTickets = $ticketService->addFilter('author_id', 1)->get();

    //And you can chain!
    $johnUrgentTicketsCreatedSinceTwentyTwenty = $ticketService()
        ->inRange(Carbon::parse('2020-01-01 00:00:00'), Carbon::now())
        ->addFilter('subject', '~urgent')
        ->addFilter('author_id', 1)
        ->get();
```
